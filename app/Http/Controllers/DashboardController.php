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

        // setup du compte affiché sur le dashboard
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

        return view('dashboard', [
            'accounts' => $accounts,
            'user' => $user,
            'accountsStat' => $accountsStat,
            'expensesByCategories' => $expensesByCategories,
            'notifications' => $notifications,
            'monthlyExpenses' => $monthlyExpenses,
            'monthlyExpensesByCategories' => $monthlyExpensesByCategories,
            'currentAccount' => $currentAccount,
            'budgets' => $currentAccount->budgets,
        ]);
    }

    private function getExpensesByCategories(Account $account): array
    {
        $result = [];
        $categories = Category::all();

        foreach ($categories as $category) {
            $sum = $category
                ->transactions()
                ->whereMonth('date', date('m'))
                ->where('account_id', $account->id)
                ->where('status', 'debit')
                ->sum('amount');

            $result[] = [
                'id' => $category->id,
                'title' => $category->title,
                'color' => $category->color,
                'sum' => $sum,
            ];
        }
        return collect($result)->sortByDesc('sum')->values()->all();
    }

    public function getMonthlyExpensesByCategories(Account $account): array
    {
        $result = [];
        $categories = Category::all();

        foreach ($categories as $category) {
            $transactions = $category->transactions()
                ->where('account_id', $account->id)
                ->where('status', 'debit')
                ->get();

            $result[$category->id] = [
                'title' => $category->title,
                'color' => $category->color,
                'months' => array_fill(0, 12, 0)
            ];

            for ($month = 1; $month <= 12; $month++) {
                $total = $transactions->filter(function ($transaction) use ($month) {
                    return Carbon::parse($transaction->date)->month === $month;
                })->sum('amount');
                $result[$category->id]['months'][$month - 1] = $total;
            };
        }

        return $result;
    }

    private function getMonthlyExpenses(Account $account): array
    {
        $transactions = $account->transactions;

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
