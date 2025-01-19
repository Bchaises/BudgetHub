<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionCategory extends Model
{
    protected $table = 'transaction_categories';

    protected $fillable = [
        'title',
        'description',
    ];

    public static function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'string',
        ];
    }
}
