<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
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
            'categories' => Category::all(),
        ]);
    }

    public function show(string $id): View
    {
        $user = User::findOrFail(Auth::id());
        return view('transaction.show', [
            'transaction' => $user->transactions->where('id', $id)->firstOrFail(),
            'accounts' => $user->accounts,
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
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

        session([
            'last_transaction_date' => $validate['date'],
            'last_transaction_status' => $validate['status'],
        ]);

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

        $user = Auth::user();
        $transaction = $user->transactions()->where('id', $id)->first();
        $account = $transaction->account()->where('id', $validated['account_id'])->first();

        DB::transaction(function () use ($transaction, $account, $validated) {
            $balanceChange = $transaction->amount - $validated['amount'];

            if ($transaction->status === 'debit') {
                $account->increment('balance', $balanceChange);
            }

            if ($transaction->status === 'credit') {
                $account->decrement('balance', $balanceChange);
            }

            $transaction->fill($validated)->save();
        });

        return redirect()->back()->with('success', 'Transaction updated!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $user = Auth::user();
        $transaction = $user->transactions()->where('id', $id)->get()->first();
        $account = $transaction->account()->get()->first();

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
