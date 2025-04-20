<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invitation;
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
        $ExpensesByCategories = $this->getExpensesByCategories();
        $invitations = Invitation::where('receiver_id', Auth::id())->where('status', 'LIKE', 'pending')->get();

        return view('dashboard', [
            'accounts' => $accounts,
            'user' => $user,
            'accountsStat' => $accountsStat,
            'expensesByCategories' => $ExpensesByCategories,
            'invitations' => $invitations,
            'invitationCount' => $invitations->count(),
        ]);
    }

    public function getExpensesByCategories(): array
    {
        $categories = Category::all();
        $result = [];

        foreach ($categories as $category) {
            $transactions = $category->transactions;
            $sum = 0;
            foreach ($transactions as $transaction) {
                $sum += $transaction->status === 'debit' ?
                    -$transaction->amount :
                    $transaction->amount;
            }
            if ($sum != 0) {
                $result[$category->title] = $sum;
            }
        }
        asort($result);

        return $result;
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
