<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('account.index', [
            'accounts' => Account::all(),
        ]);
    }

    public function show(string $id): View
    {
        return view('account.show', [
            'account' => Account::findOrFail($id),
            'transactions' => Transaction::where('account_id', $id)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(Account::rules());

        $account = new Account();
        $account->title = ucfirst($validated['title']);
        $account->description = ucfirst($validated['description']);
        $account->balance = $validated['balance'];
        $account->save();

        return redirect()->back();
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate(Account::rules());

        $account = Account::find($id);
        $account->title = ucfirst($validated['title']);
        $account->description = ucfirst($validated['description']);
        $account->balance = $validated['balance'];
        $account->save();

        return redirect()->back();
    }

    public function destroy(string $id): RedirectResponse
    {
        Account::destroy($id);
        return redirect()->back();
    }
}
