<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(): View
    {
        $user = User::findOrFail(Auth::id());

        return view('dashboard', [
            'accounts' => $user->accounts,
            'user' => $user,
        ]);
    }
}
