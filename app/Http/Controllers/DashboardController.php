<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(Request $request): View
    {
        // Récupération de l'utilisateur et de ses comptes
        $user = Auth()->user();
        $accounts = $user
            ->accounts()
            ->get()
            ->sortBy('id');

        // Setup du compte affiché sur le dashboard
        $currentAccount = $accounts->first();
        $accountId = $request->get('accountId') ?? session('accountId');
        if ($accountId) {
            $account = $accounts->firstWhere('id', $accountId);
            if ($account) {
                $currentAccount = $account;
                session(['accountId' => $accountId]);
            }
        }

        // Calcul des statistiques
        $accountsStat = $this->getDiffTransactionsAccounts($accounts);
        $notifications = Invitation::where('receiver_id', Auth::id())->where('status', 'LIKE', 'pending')->get();
        $monthlyExpenses = $this->getMonthlyExpenses($currentAccount);
        $monthlyExpensesByCategories = $this->getMonthlyExpensesByCategories($currentAccount);
        $expensesByCategories = $this->getExpensesByCategories($currentAccount);
        $budgetProgress = $this->getBudgetProgress($currentAccount);

        return view('dashboard', [
            'accounts' => $accounts,
            'user' => $user,
            'accountsStat' => $accountsStat,
            'expensesByCategories' => $expensesByCategories,
            'notifications' => $notifications,
            'monthlyExpenses' => $monthlyExpenses,
            'monthlyExpensesByCategories' => $monthlyExpensesByCategories,
            'currentAccount' => $currentAccount,
            'budgetProgress' => $budgetProgress,
        ]);
    }

    private function getExpensesByCategories(Account $account): array
    {
        $categories = Category::with(['transactions' => function ($query) use ($account) {
            $query->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->where('account_id', $account->id);
        }])->get();

        $result = $categories->map(function ($category) {
            $sum = $category->transactions->reduce(function ($carry, $transaction) {
                return $carry + ($transaction->status === 'debit' ? $transaction->amount : -$transaction->amount);
            }, 0);

            return [
                'id' => $category->id,
                'title' => $category->title,
                'color' => $category->color,
                'sum' => $sum,
            ];
        });

        return $result->sortByDesc('sum')->values()->all();
    }

    private function getBudgetProgress(Account $account): array
    {
        $result = [];
        $budgets = $account->budgets()->with(['category.transactions' => function ($query) use ($account) {
            $query->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->where('account_id', $account->id);
        }])->get();

        foreach ($budgets as $budget) {
            $category = $budget->category;
            $transactions = $category->transactions;

            $total = $transactions->reduce(function ($carry, $transaction) {
                return $carry + ($transaction->status === 'debit' ? $transaction->amount : -$transaction->amount);
            }, 0);

            $progress = $budget->amount > 0 ? round($total / $budget->amount * 100) : 0;

            $result[] = [
                'category' => $category,
                'progress' => $progress,
            ];
        }

        return collect($result)->sortByDesc('progress')->values()->all();
    }


    private function getMonthlyExpensesByCategories(Account $account): array
    {
        $result = [];
        $categories = Category::all();

        foreach ($categories as $category) {
            $transactions = $category->transactions()
                ->where('account_id', $account->id)
                ->whereYear('date', date('Y'))
                ->get();

            $result[$category->id] = [
                'title' => $category->title,
                'color' => $category->color,
                'months' => array_fill(0, 12, 0)
            ];

            for ($month = 1; $month <= 12; $month++) {
                $total = $transactions
                    ->filter(fn ($t) => Carbon::parse($t->date)->month === $month)
                    ->sum(fn ($tr) => $tr->status === 'debit' ? $tr->amount : -$tr->amount);
                $result[$category->id]['months'][$month - 1] = max($total, 0);
            };
        }

        return $result;
    }

    private function getMonthlyExpenses(Account $account): array
    {
        $transactions = $account->transactions()
            ->whereYear('date', date('Y'))
            ->get();

        // Initialiser les mois à zéro
        $monthlyCredits = array_fill(1, 12, 0);
        $monthlyDebits = array_fill(1, 12, 0);

        foreach ($transactions as $transaction) {
            $month = Carbon::parse($transaction->date)->month;
            if ($transaction->status === 'credit') {
                $monthlyCredits[$month] += $transaction->amount;
            } elseif ($transaction->status === 'debit') {
                $monthlyDebits[$month] += $transaction->amount;
            }
        }

        return [
            'monthlyCredits' => array_values($monthlyCredits),
            'monthlyDebits' => array_values($monthlyDebits),
        ];
    }

    private function getDiffTransactionsAccounts(Collection $accounts): array
    {
        $result = [];
        foreach ($accounts as $account) {

            $sumPrevMonth = $this->sumTransactions(
                $account
                    ->transactions()
                    ->select('status', 'amount')
                    ->whereBetween('date', [
                        date('Y-m-d', strtotime('first day of last month')),
                        date('Y-m-d', strtotime('last day of last month'))
                    ])
                    ->get()
            );

            $sumThisMonth = $this->sumTransactions(
                $account
                    ->transactions()
                    ->select('status', 'amount')
                    ->whereBetween('date', [
                        date('Y-m-d', strtotime('first day of this month')) ,
                        date('Y-m-d', strtotime('last day of this month'))
                    ])
                    ->get()
            );

            $result[$account->id] = $sumPrevMonth + $sumThisMonth;
        }

        return $result;
    }

    private function sumTransactions(Collection $transactions): int
    {
        $sum = 0;
        foreach ($transactions as $transaction) {
            $sum += $transaction->status === 'debit' ?
                -$transaction->amount :
                $transaction->amount;
        }
        return $sum;
    }
}
