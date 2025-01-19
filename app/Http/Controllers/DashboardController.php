<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(): View
    {
        return view('dashboard', [
            'accounts' => Account::all(),
            'user' => Auth::user(),
        ]);
    }
}
