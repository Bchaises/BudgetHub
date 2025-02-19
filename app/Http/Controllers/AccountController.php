<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
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

    public function show(?string $id = null): View
    {
        $user = Auth::user();
        $accounts = $user->accounts;

        $categories[''] = ['icon' => 'fa-solid fa-xmark', 'label' => 'None'];
        foreach (Category::all() as $category) {
            $categories[$category->id] = ['icon' => 'fa-solid '.$category->icon, 'label' => $category->title];
        }

        $currentAccount = $id !== null ? $user->accounts()->where('id', $id)->first() : $user->accounts()->first();

        $transactionsQuery = $currentAccount->transactions()
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year);

        $totals = $transactionsQuery
            ->selectRaw('status, SUM(amount) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalIncome = $totals['credit'] ?? 0;
        $totalOutcome = $totals['debit'] ?? 0;

        return view('account.show', [
            'currentAccount' => $currentAccount,
            'accounts' => $accounts,
            'categories' => $categories,
            'totalIncome' => $totalIncome,
            'totalOutcome' => $totalOutcome,
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
        Account::destroy($id);
        return redirect()->back()->with('status', 'Account deleted.');
    }
}
