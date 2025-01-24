<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InvitationController
{
    public function index(): View
    {
        $user = User::findOrFail(Auth::id());
        return view('invitation.index', [
            'invitations' => $user->invitations,
            'accounts' => $user->accounts,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validate = $request->validate(Invitation::rules(), Invitation::messages());
        } catch (ValidationException $exception) {
            return redirect()->back()
                ->withErrors($exception->errors())
                ->withInput();
        }

        $receiver = User::where('email', $validate['receiver_email'])->first();

        if (Auth::id() === $receiver->id) {
            return redirect()->back()
                ->withErrors(['receiver_email' => 'You cannot send an invitation to yourself.'])
                ->withInput();
        }

        if ($receiver->accounts()->where('id', $validate['account'])->exists()) {
            return redirect()->back()
                ->withErrors(['account' => 'This user has already access to this account.'])
                ->withInput();
        }

        $existingInvitation = Invitation::where('receiver_id', $receiver->id)
            ->where('account_id', $validate['account'])
            ->where('status', 'pending')
            ->where('expired_at', '>', now())
            ->first();

        if ($existingInvitation) {
            $timeLeft = $existingInvitation->expired_at->diffForHumans();
            return redirect()->back()
                ->withErrors(['receiver_email' => "An invitation was already sent to this user and will expire in $timeLeft. Please wait before sending another."])
                ->withInput();
        }

        $invitation = Invitation::create([
            'account_id' => $validate['account'],
            'receiver_id' => $receiver->id,
            'sender_id' => Auth::id(),
            'status' => 'pending',
            'role' => $validate['role'],
            'expired_at' => now()->addDay(),
        ]);

        $this->sendInvitationEmail($invitation, $receiver->email);

        return redirect()->route('invitation.index')->with(['status' => 'invitation-sent']);
    }

    public function sendInvitationEmail(Invitation $invitation, string $email)
    {
        $token = Str::random(32);

        $invitation->update(['token' => $token]);

        Mail::to($email)->send(new InvitationMail($invitation));
    }

    public function destroy(Invitation $invitation): RedirectResponse
    {
        if (Auth::id() !== $invitation->sender_id) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'You are not authorized to delete this invitation.']);
        }

        $invitation->delete();

        return redirect()->route('invitation.index')->with(['status' => 'invitation-deleted']);
    }

    public function respond(Request $request, $token): RedirectResponse
    {
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation || $invitation->expired_at < now()) {
            return redirect()->route('home')->withErrors(['error' => 'This invitation is invalid or has expired.']);
        }

        $status = $request->query('status');

        if (!in_array($status, ['accepted', 'declined'])) {
            return redirect()->route('home')->withErrors(['error' => 'Invalid response.']);
        }

        $invitation->update(['status' => $status]);

        if ($status === 'accepted') {
            $invitation->account->users()->attach($invitation->receiver_id, ['role' => $invitation->role]);
        }

        return redirect()->route('dashboard')->with(['status' => 'Invitation ' . $status . '.']);
    }

}
