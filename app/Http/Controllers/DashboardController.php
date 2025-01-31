<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(): View
    {
        $user = User::findOrFail(Auth::id());
        $accounts = $user->accounts;
        $accountsStat = $this->getDiffTransactionsAccounts($accounts);

        return view('dashboard', [
            'accounts' => $accounts,
            'user' => $user,
            'accountsStat' => $accountsStat
        ]);
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
