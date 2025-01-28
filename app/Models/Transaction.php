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
    ];

    public static function rules(): array
    {
        return [
            'label' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:debit,credit',
            'date' => 'required|date',
            'account' => 'required|exists:accounts,id',
            'target_account' => 'nullable|exists:accounts,id|different:account',
            'category' => 'nullable|exists:transaction_categories,id',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function targetAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'target_account_id');
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
