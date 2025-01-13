<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function show(): View
    {
        return view('transaction', [
            'title' => 'Transaction',
            'transactions' => Transaction::all()
        ]);
    }
}
