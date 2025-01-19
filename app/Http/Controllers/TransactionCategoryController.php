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
        return view('category.index', [
            'title' => 'Transaction Category',
            'categories' => TransactionCategory::all()
        ]);
    }

    public function show(string $id): View
    {
        return view('category.show', [
            'title' => 'Transaction Category',
            'category' => TransactionCategory::findOrFail($id)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(TransactionCategory::rules());
        $category = new TransactionCategory();
        $category->title = ucfirst($validated['title']);
        $category->description = ucfirst($validated['description']);
        $category->save();

        return redirect()->back();
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate(TransactionCategory::rules());
        $category = new TransactionCategory();
        $category->title = ucfirst($validated['title']);
        $category->description = ucfirst($validated['description']);
        $category->save();

        return redirect()->back();
    }

    public function destroy(string $id): RedirectResponse
    {
        TransactionCategory::destroy($id);
        return redirect()->back();
    }
}
