<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionCategory extends Model
{
    protected $table = 'transaction_categories';

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    protected $guarded = [
        'user_id'
    ];

    public static function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'string',
            'user_id' => 'prohibited'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
