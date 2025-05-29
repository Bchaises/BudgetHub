<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Invitation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransferController extends Controller
{
    public function index(): View
    {
        $user = User::findOrFail(Auth::id());
        $accounts = $user->accounts->sortByDesc('id');
        $notifications = Invitation::where('receiver_id', Auth::id())->where('status', 'LIKE', 'pending')->get();
        $categories = Category::query()
            ->orderBy('order')
            ->get()
            ->mapWithKeys(fn ($cat) => [
                $cat->id => [
                    'icon' => $cat->icon,
                    'label' => $cat->title,
                ]
            ])
            ->toArray();
        $categories[null] = ['icon' => 'fa-ban', 'label' => 'None'];

        return view('transfer.index', [
            'accounts' => $accounts,
            'categories' => $categories,
            'notifications' => $notifications,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'label' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'from_account_id' => 'nullable|exists:accounts,id|different:to_account_id',
            'to_account_id' => 'nullable|exists:accounts,id|different:from_account_id',
        ]);

        $fromAccount = Account::findOrFail($validate['from_account_id']);
        $toAccount = Account::findOrFail($validate['to_account_id']);

        DB::transaction(function () use ($validate, $fromAccount, $toAccount) {

            $this->createTransaction([
                'label' => $validate['label'],
                'amount' => $validate['amount'],
                'status' => 'debit',
                'date' => $validate['date'],
                'account_id' => $validate['from_account_id'],
                'category_id' => $validate['category_id'],
            ], $fromAccount);

            $this->createTransaction([
                'label' => $validate['label'],
                'amount' => $validate['amount'],
                'status' => 'credit',
                'date' => $validate['date'],
                'account_id' => $validate['to_account_id'],
                'category_id' => $validate['category_id'],
            ], $toAccount);
        });

        return redirect()->back()->with('success', 'Transfer created!');
    }

    private function createTransaction(array $data, Account $account): Transaction
    {
        $transaction = Transaction::create($data);

        switch ($data['status']) {
            case 'debit':
                $account->decrement('balance', $transaction->amount);
                break;
            case 'credit':
                $account->increment('balance', $transaction->amount);
                break;
        }

        $transaction->users()->attach(Auth::id(), [
            'is_initiator' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $transaction;
    }
}
