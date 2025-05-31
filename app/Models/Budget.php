<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $fillable = [
        'account_id',
        'category_id',
        'amount',
    ];

    public static function rules(): array
    {
        return [
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
