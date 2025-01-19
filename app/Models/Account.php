<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'balance',
        'title',
        'description',
    ];

    public static function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'string',
            'balance' => 'required|integer',
        ];
    }
}
