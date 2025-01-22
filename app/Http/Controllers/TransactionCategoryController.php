<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\View\View;

class TransactionCategoryController extends Controller
{
    public function index(): View
    {
        return view('category.index', [
            'title' => 'Transaction Category',
            'categories' => TransactionCategory::all()
        ]);
    }

    public function show(string $id): View
    {
        return view('category.show', [
            'title' => 'Transaction Category',
            'category' => TransactionCategory::all(),
        ]);
    }
}
