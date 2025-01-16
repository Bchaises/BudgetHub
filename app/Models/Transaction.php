<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'label',
        'amount',
        'status',
    ];

    public static array $rules = [
        'label' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'status' => 'required|in:debit,credit',
        'date' => 'required|date',
        'account' => 'required|exists:accounts,id',
        'category' => 'nullable|exists:transaction_categories,id',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TransactionCategory::class);
    }
}
