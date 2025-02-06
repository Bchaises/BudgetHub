<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class TransactionCategoryController extends Controller
{
    public function index(): View
    {
        return view('category.index', [
            'title' => 'Transaction Category',
            'categories' => Category::all()
        ]);
    }

    public function show(string $id): View
    {
        return view('category.show', [
            'title' => 'Transaction Category',
            'category' => Category::all(),
        ]);
    }
}
