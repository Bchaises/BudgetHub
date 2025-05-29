<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;

class TransactionsList extends Component
{
    public $accountId;
    public $currentMonth;
    public $currentYear;

    protected $listeners = ['changeMonth'];

    public function mount($accountId, $currentMonth, $currentYear)
    {
        $this->accountId = $accountId ?? User::find(auth()->id())->accounts()->first()->id;
        $this->currentMonth = $currentMonth;
        $this->currentYear = $currentYear;
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
        $transactions = Transaction::where('account_id', $this->accountId)
            ->whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->groupBy('id', 'date')
            ->orderByRaw('date DESC, created_at DESC')
            ->get();

        $totals = Transaction::where('account_id', $this->accountId)
            ->whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->selectRaw('status, SUM(amount) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalIncome = isset($totals['credit']) ? strval(round($totals['credit'], 2)) : 0;
        $totalOutcome = isset($totals['debit']) ? strval(round($totals['debit'], 2)) : 0;

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

        return view('livewire.transactions-list', compact('transactions'), ['account' => Account::find($this->accountId), 'totalIncome' => $totalIncome, 'totalOutcome' => $totalOutcome, 'categories' => $categories]);
    }
}
