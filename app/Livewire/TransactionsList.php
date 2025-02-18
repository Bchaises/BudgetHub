<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Livewire\Component;

class TransactionsList extends Component
{
    public $accountId;
    public $currentMonth;
    public $currentYear;

    protected $listeners = ['changeMonth'];

    public function mount($accountId)
    {
        $this->accountId = $accountId;
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    public function previousMonth()
    {
        if ($this->currentMonth == 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }
    }

    public function nextMonth()
    {
        if ($this->currentMonth == 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
    }

    public function render()
    {
        $transactionsQuery = Transaction::where('account_id', $this->accountId)
            ->whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear);

        $transactions = $transactionsQuery->get();

        $totals = $transactionsQuery
            ->selectRaw('status, SUM(amount) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalIncome = $totals['credit'] ?? 0;
        $totalOutcome = $totals['debit'] ?? 0;

        $categories = [];
        foreach (Category::all() as $category) {
            $categories[$category->id] = ['icon' => 'fa-solid '.$category->icon, 'label' => $category->title];
        }

        return view('livewire.transactions-list', compact('transactions'), ['account' => Account::find($this->accountId), 'totalIncome' => $totalIncome, 'totalOutcome' => $totalOutcome, 'categories' => $categories]);
    }
}
