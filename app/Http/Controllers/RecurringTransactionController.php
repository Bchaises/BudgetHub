<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\RecurringTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RecurringTransactionController
{
    public function show(int $accountId): View
    {
        $user = Auth::user();
        $account = $user->accounts()->where('id', $accountId)->get()->first();
        $categories[''] = ['icon' => 'fa-solid fa-xmark', 'label' => 'None'];
        foreach (Category::all() as $category) {
            $categories[$category->id] = ['icon' => 'fa-solid '.$category->icon, 'label' => $category->title];
        }
        $recurringTransactions = RecurringTransaction::where('account_id', $accountId)->groupBy('id')->orderBy('id', 'desc')->get();

        return view('recurring-transaction.show', [
            'account' => $account,
            'categories' => $categories,
            'recurringTransactions' => $recurringTransactions
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(RecurringTransaction::rules());

        RecurringTransaction::create($validate);

        return redirect()->back()->with('success', 'Recurring transaction created successfully!');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validate = $request->validate(RecurringTransaction::rules());

        $recurringTransaction = RecurringTransaction::findOrFail($id);
        $recurringTransaction->fill($validate)->save();

        return redirect()->back()->with('success', 'Recurring transaction updated successfully!');
    }

    public function destroy(string $id): RedirectResponse
    {
        RecurringTransaction::destroy($id);
        return redirect()->back()->with('status', 'Recurring transaction deleted.');
    }
}
