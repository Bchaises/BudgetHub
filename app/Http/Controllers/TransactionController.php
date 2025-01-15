<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $transaction = new Transaction();
        $transaction->label = $request->label;
        $transaction->amount = $request->amount;
        $transaction->status = $request->status;
        $transaction->date = $request->date;
        $transaction->account_id = $request->account;
        $transaction->category_id = $request->category;
        $transaction->save();

        return redirect()->route('transaction.index');
    }

    public function update(string $id, Request $request): RedirectResponse
    {
        $transaction = Transaction::find($id);
        $transaction->label = $request->label;
        $transaction->amount = $request->amount;
        $transaction->status = $request->status;
        $transaction->date = $request->date;
        $transaction->account_id = $request->account;
        $transaction->category_id = $request->category;
        $transaction->save();

        return redirect()->route('transaction.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        Transaction::destroy($id);
        return redirect()->route('transaction.index');
    }
}
