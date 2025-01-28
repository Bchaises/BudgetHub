<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = [
        'title',
        'description',
        'balance',
        'user_id',
    ];

    protected $guarded = [
        'balance',
        'user_id'
    ];

    public static function rules(bool $isUpdate = false): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'balance' => 'prohibited',
            'user_id' => 'prohibited',
        ];

        if (!$isUpdate) {
            $rules['balance'] = 'required|integer';
        }

        return $rules;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_account');
    }

    public function transactionsInitiated(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    public function transactionsReceived(): HasMany
    {
        return $this->hasMany(Transaction::class, 'target_account_id');
    }

    public function allTransactions()
    {
        return Transaction::where('account_id', $this->id)
            ->orWhere('target_account_id', $this->id)
            ->get();
    }
}
