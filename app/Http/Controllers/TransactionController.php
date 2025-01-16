<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        return view('transaction.index', [
            'title' => 'Transaction',
            'transactions' => Transaction::all(),
            'accounts' => Account::all(),
            'categories' => TransactionCategory::all(),
        ]);
    }

    public function show(string $id): View
    {
        return view('transaction.show', [
            'title' => 'Une transaction',
            'transaction' => Transaction::findOrFail($id),
            'accounts' => Account::all(),
            'categories' => TransactionCategory::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(Transaction::$rules);
        $account = Account::findOrFail($validated['account']);

        DB::transaction(function () use ($validated, $account) {
            $transaction = new Transaction();
            $transaction->label = ucfirst($validated['label']);
            $transaction->amount = $validated['amount'];
            $transaction->status = $validated['status'];
            $transaction->date = $validated['date'];
            $transaction->account_id = $validated['account'];
            $transaction->category_id = $validated['category'];

            $balanceChange = $transaction->status === 'debit'
                ? -$transaction->amount
                : $transaction->amount;

            if ($balanceChange !== 0) {
                $account->update([
                    'balance' => $account->balance + $balanceChange,
                ]);
            }

            $transaction->save();
        });

        return redirect()->back();
    }

    public function update(string $id, Request $request): RedirectResponse
    {
        $validated = $request->validate(Transaction::$rules);

        $transaction = Transaction::findOrFail($id);
        $transaction->label = ucfirst($validated['label']);
        $transaction->amount = $validated['amount'];
        $transaction->status = $validated['status'];
        $transaction->date = $validated['date'];
        $transaction->account_id = $validated['account'];
        $transaction->category_id = $validated['category'];
        $transaction->save();

        return redirect()->back();
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

        return redirect()->back();
    }
}
