<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(Budget::rules());

        $budget = Budget::where('account_id', $validated['account_id'])
            ->where('category_id', $validated['category_id']);

        if ($budget->exists()) {
            $budget->update(['amount' => $validated['amount']]);
            return redirect()->back()->with('success', 'Budget updated successfully');
        }

        Budget::create($validated);

        return redirect()->back()->with('success', 'Budget created successfully');
    }

    public function destroy(string $id): RedirectResponse
    {
        $budget = Budget::find($id);

        if (null === $budget) {
            return redirect()->back()->withErrors(['not-found' => 'Budget not found.']);
        }

        if (!$budget->account->users->contains(auth()->user())) {
            return redirect()->back()->withErrors(['not-allowed' => 'You are not allowed to delete this budget.']);
        }

        $budget->delete();
        return redirect()->back()->with('success', 'Budget deleted successfully.');
    }
}
