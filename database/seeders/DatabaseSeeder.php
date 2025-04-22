<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('categories')->upsert([
            [
                'id' => 1,
                'title' => 'Animals',
                'color' => '#C4B49D',  // Darker pastel beige
                'icon' => 'fa-paw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'title' => 'Children & Schooling',
                'color' => '#D4A744',  // Darker pastel yellow/orange
                'icon' => 'fa-child',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'title' => 'Daily Life',
                'color' => '#C45E70',  // Darker pastel pink
                'icon' => 'fa-house-user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'title' => 'Digital',
                'color' => '#7B8FAA',  // Darker pastel light blue
                'icon' => 'fa-laptop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'title' => 'Food',
                'color' => '#5BAA63',  // Darker pastel green
                'icon' => 'fa-utensils',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'title' => 'Health',
                'color' => '#6FB7DA',  // Darker pastel blue
                'icon' => 'fa-heartbeat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'title' => 'Holidays / Weekend',
                'color' => '#A985D4',  // Darker pastel lavender
                'icon' => 'fa-sun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'title' => 'Housing',
                'color' => '#9E847B',  // Darker pastel beige
                'icon' => 'fa-home',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'title' => 'Leisure',
                'color' => '#CC7F96',  // Darker pastel pink
                'icon' => 'fa-gamepad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'title' => 'Other Expenses',
                'color' => '#9E8FB3',  // Darker pastel lavender
                'icon' => 'fa-wallet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'title' => 'Taxes',
                'color' => '#A0B8C1',  // Darker pastel light blue
                'icon' => 'fa-file-invoice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'title' => 'Transports',
                'color' => '#6D9BC4',  // Darker pastel blue
                'icon' => 'fa-car',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['id'], ['title', 'color', 'icon', 'updated_at']);
    }
}
