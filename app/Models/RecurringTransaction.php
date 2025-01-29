<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RecurringTransaction extends Model
{
    protected $fillable = [
        'label',
        'amount',
        'status',
        'frequency',
        'start_date',
        'end_date',
        'account_id',
        'category_id'
    ];

    public static function rules(): array
    {
        return [
            'label' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:debit,credit',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:transaction_categories,id',
        ];
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function category()
    {
        return $this->belongsTo(TransactionCategory::class);
    }

    public function shouldGenerate(): bool
    {
        $today = now()->toDateString();

        if ($this->end_date && $today > $this->end_date) {
            return false;
        }

        return match ($this->frequency) {
            'daily' => true,
            'weekly' => now()->isSameDay(Carbon::parse($this->start_date)),
            'monthly' => now()->day == Carbon::parse($this->start_date)->day,
            'yearly' => now()->format('m-d') == Carbon::parse($this->start_date)->format('m-d'),
            default => false,
        };
    }

    /**
     * Génère la transaction associée
     */
    public function generateTransaction()
    {
        if (!$this->shouldGenerate()) {
            return;
        }

        DB::transaction(function () {
            Transaction::create([
                'label' => $this->label,
                'amount' => $this->amount,
                'status' => $this->status,
                'date' => now(),
                'account_id' => $this->account_id,
                'category_id' => $this->category_id,
            ]);

            $this->account->increment('balance', $this->status === 'debit' ? -$this->amount : $this->amount);
        });
    }
}
