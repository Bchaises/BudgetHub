<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    protected $fillable = [
        'account_id',
        'receiver_id',
        'sender_id',
        'status',
        'expired_at',
        'role',
        'token'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public static function rules(): array
    {
        return [
            'receiver_email' => ['required', 'exists:users,email'],
            'account' => ['required', 'exists:accounts,id'],
            'role' => ['required', 'in:editor,viewer'],
        ];
    }

    public static function messages(): array
    {
        return [
            'receiver_email.exists' => 'No users found with this email.',
            'account.exists' => 'The selected account does not exist.',
            'role.in' => 'The selected role should be editor or viewer.',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
