<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(Request $request): View
    {

        $user = Auth()->user();
        $accounts = $user
            ->accounts()
            ->with(['budgets.category'])
            ->get()
            ->sortBy('id');

        $requestAccountId = $request->get('accountId');
        $currentAccount = $user->accounts()->where('id', $requestAccountId)->with(['budgets.category'])->first() ?? $accounts->first();

        $accountsStat = $this->getDiffTransactionsAccounts($accounts);

        $expensesByCategories = null;
        if (!$accounts->isEmpty()) {
            $expensesByCategories = $this->getExpensesByCategories($currentAccount->id);
        }

        $notifications = Invitation::where('receiver_id', Auth::id())->where('status', 'LIKE', 'pending')->get();

        $monthlyExpenses = $this->getMonthlyExpenses(Account::find($currentAccount->id));

        $monthlyExpensesByCategories = $this->getMonthlyExpensesByCategories($currentAccount->id);

        return view('dashboard', [
            'accounts' => $accounts,
            'user' => $user,
            'accountsStat' => $accountsStat,
            'expensesByCategories' => $expensesByCategories,
            'notifications' => $notifications,
            'monthlyExpenses' => $monthlyExpenses,
            'monthlyExpensesByCategories' => $monthlyExpensesByCategories,
            'currentAccount' => $currentAccount,
        ]);
    }

    private function getExpensesByCategories(String $accountId): Collection
    {
        return DB::table('categories')
            ->leftJoin('transactions', function ($join) {
                $join->on('transactions.category_id', '=', 'categories.id')
                    ->where('transactions.status', '=', 'debit')
                    ->whereRaw('EXTRACT(MONTH FROM transactions.date) = ?', [date('n')]);
            })
            ->leftJoin('user_transaction', 'transactions.id', '=', 'user_transaction.transaction_id')
            ->where('user_transaction.user_id', '=', Auth::id())
            ->where('account_id', $accountId)
            ->select(
                'categories.id',
                'categories.title',
                'categories.color',
                DB::raw('COALESCE(SUM(transactions.amount),0) as amount')
            )
            ->groupBy('categories.id', 'categories.title', 'categories.color', 'categories.icon')
            ->orderBy('amount', 'desc')
            ->get();
    }

    private function getMonthlyExpensesByCategories(String $accountId): array
    {
        $data = DB::table('categories')
            ->select(
                'categories.id',
                'categories.title',
                'categories.color',
                DB::raw('EXTRACT(MONTH FROM transactions.date) as month'),
                DB::raw('COALESCE(SUM(transactions.amount), 0) as amount')
            )
            ->leftJoin('transactions', function ($join) use ($accountId) {
                $join->on('transactions.category_id', '=', 'categories.id')
                    ->where('transactions.account_id', '=', $accountId)
                    ->where('transactions.status', '=', 'debit');
            })
            ->leftJoin('user_transaction', 'transactions.id', '=', 'user_transaction.transaction_id')
            ->where('user_transaction.user_id', '=', Auth::id())
            ->groupBy(
                'categories.id',
                'categories.title',
                'categories.color',
                DB::raw('EXTRACT(MONTH FROM transactions.date)')
            )
            ->orderBy('categories.title')
            ->get();

        foreach ($data as $row) {
            $catId = $row->id;
            if (!isset($results[$catId])) {
                $results[$catId] = [
                    'title' => $row->title,
                    'color' => $row->color,
                    'months' => array_fill(0, 12, 0)
                ];
            }

            $monthIndex = (int)$row->month - 1;
            $results[$catId]['months'][$monthIndex] = (float) $row->amount;
        }

        return $results;
    }

    //    public function getExpensesByBudget(Account $account): Collection
    //    {
    //        $transactions = $account->transactions()->
    //        return DB::table('budgets');
    //    }

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
