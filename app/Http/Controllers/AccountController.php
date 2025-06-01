<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Invitation;
use App\Models\Transaction;
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

    public function edit(string $id): View
    {
        $account = User::find(Auth::id())->accounts->find($id);
        $notifications = Invitation::where('receiver_id', Auth::id())->where('status', 'LIKE', 'pending')->get();
        $budgets = $account->budgets->sortBy('created_at');
        $categories = Category::query()
            ->orderBy('order')
            ->get()
            ->mapWithKeys(fn ($cat) => [
                $cat->id => [
                    'icon' => $cat->icon,
                    'label' => $cat->title,
                ]
            ])
            ->toArray();
        $categories[null] = ['icon' => 'fa-ban', 'label' => 'None'];

        return view('account.edit', [
            'account' => $account,
            'invitations' => $account->invitations,
            'notifications' => $notifications,
            'budgets' => $budgets,
            'categories' => $categories,
        ]);
    }

    public function show(?string $id = null): View
    {
        $user = Auth()->user();
        $accounts = $user->accounts->sortBy('id');
        $notifications = Invitation::where('receiver_id', Auth::id())->where('status', 'LIKE', 'pending')->get();
        $categories = Category::query()
            ->orderBy('order')
            ->get()
            ->mapWithKeys(fn ($cat) => [
                $cat->id => [
                    'icon' => $cat->icon,
                    'label' => $cat->title,
                ]
            ])
            ->toArray();
        $categories[null] = ['icon' => 'fa-ban', 'label' => 'None'];

        $currentAccount = $id !== null ? $accounts->where('id', $id)->first() : $accounts->first();

        $totalIncome = 0;
        $totalOutcome = 0;

        if ($currentAccount) {
            $transactionsQuery = $currentAccount->transactions()
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year);

            $totals = $transactionsQuery
                ->selectRaw('status, SUM(amount) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $totalIncome = $totals['credit'] ?? 0;
            $totalOutcome = $totals['debit'] ?? 0;
        }

        return view('account.show', [
            'currentAccount' => $currentAccount,
            'accounts' => $accounts,
            'categories' => $categories,
            'totalIncome' => $totalIncome,
            'totalOutcome' => $totalOutcome,
            'notifications' => $notifications,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validateWithBag('accountCreation', Account::rules());

        $account = Account::create($validate);
        $balance = (float) $account->balance;
        if ($balance > 0) {
            Transaction::create([
                'label' => 'Initial balance',
                'amount' => $balance,
                'status' => 'credit',
                'date' => now()->toDateString(),
                'account_id' => $account->id,
                'category_id' => null,
            ]);
        }
        $account->users()->attach(Auth::id(), ['role' => 'owner', 'created_at' => now(), 'updated_at' => now()]);

        return redirect()->back()->with('success', 'Bank account created successfully!');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validate = $request->validate(Account::rules(true));

        $account = Account::findOrFail($id);

        $account->fill($validate)->save();

        return redirect()->back()->with('status', 'account-updated');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $account = User::find(Auth::id())->accounts->find($id);
        if ($request->get('confirm_message') !== $account->title) {
            return redirect()->back()
                ->withErrors(
                    ['confirm_message' => 'Wrong confirm message.']
                )
                ->withInput();
        }
        Account::destroy($id);
        return redirect()->route('dashboard')->with('status', 'Account deleted.');
    }
}
