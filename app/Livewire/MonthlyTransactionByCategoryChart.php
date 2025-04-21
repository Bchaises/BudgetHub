<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MonthlyTransactionByCategoryChart extends Component
{
    public $accounts;

    public $accountId;

    public function mount($accountId)
    {
        $this->accounts = User::find(Auth::id())->accounts;
        $this->accountId = $accountId ?? $this->accounts->first()->id;
    }

    public function setAccountId($id)
    {
        $this->accountId = $id;
    }

    public function render()
    {
        $accountId = $this->accountId;

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

        $results = [];
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

        return view('livewire.monthly-transaction-by-category-chart', [
            'expenses' => $results,
            'accounts' => $this->accounts,
        ]);
    }
}
