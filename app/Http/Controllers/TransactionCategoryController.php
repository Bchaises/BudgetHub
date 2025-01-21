<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionCategoryController extends Controller
{
    public function index(): View
    {
        return view('category.index', [
            'title' => 'Transaction Category',
            'categories' => TransactionCategory::where('user_id', Auth::id())->get()
        ]);
    }

    public function show(string $id): View
    {
        return view('category.show', [
            'title' => 'Transaction Category',
            'category' => TransactionCategory::where('user_id', Auth::id())->findOrFail($id),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(TransactionCategory::rules());

        $validate['user_id'] = Auth::id();

        TransactionCategory::create($validate);

        return redirect()->back()->with('success', 'Transaction category created successfully!');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validate = $request->validate(TransactionCategory::rules());

        $category = TransactionCategory::findOrFail($id);

        $category->fill($validate)->save();

        return redirect()->back()->with('success', 'Transaction category updated successfully!');
    }

    public function destroy(string $id): RedirectResponse
    {
        TransactionCategory::destroy($id);
        return redirect()->back()->with('success', 'Transaction category deleted successfully!');
    }
}
