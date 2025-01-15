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
            'title' => 'Account',
            'accounts' => Account::all(),
        ]);
    }

    public function show(string $id): View
    {
        return view('account.show', [
            'title' => 'Account',
            'account' => Account::find($id),
            'transactions' => Transaction::where('account_id', $id)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $account = new Account();
        $account->title = $request->title;
        $account->description = $request->description;
        $account->balance = $request->balance;
        $account->save();

        return redirect('/account');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $account = Account::find($id);
        $account->title = $request->title;
        $account->description = $request->description;
        $account->balance = $request->balance;
        $account->save();

        return redirect('/account');
    }

    public function delete(string $id): RedirectResponse
    {
        Account::destroy($id);
        return redirect('/account');
    }
}
