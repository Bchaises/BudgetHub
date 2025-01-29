<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    protected $fillable = [
        'label',
        'amount',
        'status',
        'date',
        'account_id',
        'category_id',
    ];

    public static function rules(): array
    {
        return [
            'label' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:debit,credit',
            'date' => 'required|date',
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:transaction_categories,id',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TransactionCategory::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_transaction');
    }
}
