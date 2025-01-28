<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('account.index', [
            'accounts' => User::find(Auth::id())->accounts,
        ]);
    }

    public function show(string $id): View
    {
        $account = User::findOrFail(Auth::id())->accounts->where('id', $id)->first();
        return view('account.show', [
            'account' => $account,
            'transactions' => $account->allTransactions()->sortByDesc('date'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(Account::rules());

        $account = Account::create($validate);
        $account->users()->attach(Auth::id(), ['role' => 'owner', 'created_at' => now(), 'updated_at' => now()]);

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
        $account = Account::findOrFail($id);

        $transactionsAsInitiator = $account->transactionsInitiated;
        $transactionsAsTarget = $account->transactionsReceived;

        foreach ($transactionsAsInitiator as $transaction) {
            $targetAccount = $transaction->targetAccount;
            if ($targetAccount) {
                $adjustment = ($transaction->status === 'debit') ? -$transaction->amount : $transaction->amount;
                $targetAccount->balance += $adjustment;
                $targetAccount->save();
            }
        }

        foreach ($transactionsAsTarget as $transaction) {
            $initiatorAccount = $transaction->account;
            if ($initiatorAccount) {
                $adjustment = ($transaction->status === 'debit') ? $transaction->amount : -$transaction->amount;
                $initiatorAccount->balance += $adjustment;
                $initiatorAccount->save();
            }
        }

        $account->delete();

        return redirect()->back()->with('status', 'Account deleted and related balances updated.');
    }
}
