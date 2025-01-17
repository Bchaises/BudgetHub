<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(): View
    {
        return view('dashboard', [
            'accounts' => Account::all(),
        ]);
    }
}
