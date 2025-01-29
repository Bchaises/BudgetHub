<?php

namespace App\Console\Commands;

use App\Models\RecurringTransaction;
use Illuminate\Console\Command;

class GenerateRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the day’s recurring transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        RecurringTransaction::all()->each(fn ($recurringTransaction) => $recurringTransaction->generateTransaction());
        $this->info('Transactions récurrentes générées avec succès.');
    }
}
