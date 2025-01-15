<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionCategoryController extends Controller
{
    public function index(): View
    {
        return view('transaction.category.index', [
            'title' => 'Transaction Category',
            'categories' => TransactionCategory::all()
        ]);
    }

    public function show(string $id): View
    {
        return view('transaction.category.show', [
            'title' => 'Transaction Category',
            'category' => TransactionCategory::find($id)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $category = new TransactionCategory();
        $category->title = $request->title;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('transaction.category.index');
    }

    public function update(Request $request): RedirectResponse
    {
        $category = new TransactionCategory();
        $category->title = $request->title;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('transaction.category.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        TransactionCategory::destroy($id);
        return redirect()->route('transaction.category.index');
    }
}
