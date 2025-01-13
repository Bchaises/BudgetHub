<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function show(): View
    {
        return view('account', [
            'title' => 'Account',
            'accounts' => Account::all()
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

    public function delete(string $id): RedirectResponse
    {
        Account::all()->find($id)->delete();
        return redirect('/account');
    }
}
