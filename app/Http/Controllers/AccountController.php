<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('account.index', [
            'accounts' => Account::where('user_id', Auth::id())->get(),
        ]);
    }

    public function show(string $id): View
    {
        $account = Account::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('account.show', [
            'account' => $account,
            'transactions' => $account->transactions,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(Account::rules());

        $validate['user_id'] = Auth::id();

        Account::create($validate);

        return redirect()->back()->with('success', 'Bank account created successfully!');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validate = $request->validate(Account::rules(true));

        $account = Account::findOrFail($id);

        $account->fill($validate)->save();

        return redirect()->back()->with('success', 'Bank account updated successfully!');
    }

    public function destroy(string $id): RedirectResponse
    {
        Account::destroy($id);
        return redirect()->back();
    }
}
