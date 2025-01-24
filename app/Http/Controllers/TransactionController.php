<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $user = User::findOrFail(Auth::id());
        return view('transaction.index', [
            'transactions' => $user->transactions,
            'accounts' => $user->accounts,
            'categories' => TransactionCategory::all(),
        ]);
    }

    public function show(string $id): View
    {
        $user = User::findOrFail(Auth::id());
        return view('transaction.show', [
            'transaction' => $user->transactions->where('id', $id)->firstOrFail(),
            'accounts' => $user->accounts,
            'categories' => TransactionCategory::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(Transaction::rules());
        $account = Account::findOrFail($validate['account']);

        DB::transaction(function () use ($validate, $account) {
            $transaction = new Transaction();
            $transaction->label = ucfirst($validate['label']);
            $transaction->amount = $validate['amount'];
            $transaction->status = $validate['status'];
            $transaction->date = $validate['date'];
            $transaction->account_id = $validate['account'];
            $transaction->category_id = $validate['category'];

            $balanceChange = $transaction->status === 'debit'
                ? -$transaction->amount
                : $transaction->amount;

            if ($balanceChange !== 0) {
                $account->update([
                    'balance' => $account->balance + $balanceChange,
                ]);
            }

            $transaction->save();
            $transaction->users()->attach(Auth::id(), ['is_initiator' => true, 'created_at' => now(), 'updated_at' => now()]);
        });

        return redirect()->back()->with('success', 'Transaction created!');
    }

    public function update(string $id, Request $request): RedirectResponse
    {
        $validated = $request->validate(Transaction::rules());

        $transaction = Transaction::findOrFail($id);

        $transaction->fill($validated)->save();

        return redirect()->back()->with('success', 'Transaction updated!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $transaction = Transaction::findOrFail($id);
        $account = Account::findOrFail($transaction->account_id);

        DB::transaction(function () use ($transaction, $account) {

            $balanceChange = $transaction->status === 'debit'
                ? $transaction->amount
                : -$transaction->amount;

            if ($balanceChange !== 0) {
                $account->update([
                    'balance' => $account->balance + $balanceChange,
                ]);
            }

            Transaction::destroy($transaction->id);
        });

        return redirect()->back()->with('success', 'Transaction deleted!');
    }
}
