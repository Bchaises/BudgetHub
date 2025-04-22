<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(): View
    {
        $user = User::findOrFail(Auth::id());
        $accounts = $user->accounts;
        $accountsStat = $this->getDiffTransactionsAccounts($accounts);

        $expensesByCategories = null;
        if (!$accounts->isEmpty()) {
            $expensesByCategories = $this->getExpensesByCategories($accounts->first()->id);
        }

        $notifications = Invitation::where('receiver_id', Auth::id())->where('status', 'LIKE', 'pending')->get();

        return view('dashboard', [
            'accounts' => $accounts,
            'user' => $user,
            'accountsStat' => $accountsStat,
            'expensesByCategories' => $expensesByCategories,
            'notifications' => $notifications,
        ]);
    }

    public function getExpensesByCategories(String $accountId): Collection
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
                'categories.title',
                'categories.color',
                DB::raw('COALESCE(SUM(transactions.amount),0) as amount')
            )
            ->groupBy('categories.title', 'categories.color')
            ->orderBy('amount', 'desc')
            ->get();
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
