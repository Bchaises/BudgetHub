<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\RecurringTransaction;
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
        if ($request['is_recurring'] === null) {

            $validate = $request->validate(array_merge(Transaction::rules(), [
                'target_account_id' => 'nullable|exists:accounts,id|different:account_id',
            ]));

            $account = Account::findOrFail($validate['account_id']);
            $targetAccount = $validate['target_account_id'] !== null ? Account::findOrFail($validate['target_account_id']) : null;

            DB::transaction(function () use ($validate, $account, $targetAccount) {
                $this->createTransaction($validate, $account);

                if ($targetAccount) {
                    $this->createTransaction([
                        'label' => $validate['label'],
                        'amount' => $validate['amount'],
                        'status' => $validate['status'] === 'debit' ? 'credit' : 'debit',
                        'date' => $validate['date'],
                        'account_id' => $validate['target_account_id'],
                        'category_id' => $validate['category_id'],
                    ], $targetAccount);
                }
            });
        } else {
            $validate = $request->validate(RecurringTransaction::rules());

            RecurringTransaction::create([
                'label' => $validate['label'],
                'amount' => $validate['amount'],
                'status' => $validate['status'],
                'frequency' => $validate['frequency'],
                'start_date' => $validate['start_date'],
                'end_date' => $validate['end_date'],
                'account_id' => $validate['account_id'],
                'category_id' => $validate['category_id'],
            ]);
        }

        return redirect()->back()->with('success', 'Transaction created!');
    }

    private function createTransaction(array $data, Account $account): Transaction
    {
        $transaction = Transaction::create($data);

        $balanceChange = $transaction->status === 'debit'
            ? -$transaction->amount
            : $transaction->amount;

        if ($balanceChange !== 0) {
            $account->increment('balance', $balanceChange);
        }

        $transaction->users()->attach(Auth::id(), [
            'is_initiator' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $transaction;
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
                $account->increment('balance', $balanceChange);
            }

            Transaction::destroy($transaction->id);
        });

        return redirect()->back()->with('success', 'Transaction deleted!');
    }
}
