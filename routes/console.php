<?php

use App\Console\Commands\GenerateRecurringTransactions;
use Illuminate\Support\Facades\Schedule;

Schedule::command(GenerateRecurringTransactions::class)->daily();
