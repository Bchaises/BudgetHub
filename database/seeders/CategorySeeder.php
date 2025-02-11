<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'title' => 'Food',
                'color' => '#A3D9A5',  // Pastel Green
                'icon' => 'fa-utensils',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Daily Life',
                'color' => '#F3A2B4',  // Pastel Pink
                'icon' => 'fa-house-user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Children & Schooling',
                'color' => '#F7D59D',  // Pastel Yellow
                'icon' => 'fa-child',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Health',
                'color' => '#B4E1F1',  // Pastel Blue
                'icon' => 'fa-heartbeat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Housing / Home',
                'color' => '#D0B9B3',  // Pastel Beige
                'icon' => 'fa-home',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Vehicle',
                'color' => '#A2C2E3',  // Pastel Blue
                'icon' => 'fa-car',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital',
                'color' => '#B8C9E0',  // Pastel Light Blue
                'icon' => 'fa-laptop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Leisure',
                'color' => '#F5C2D3',  // Pastel Light Pink
                'icon' => 'fa-gamepad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Holidays / Weekend',
                'color' => '#E0C1FF',  // Pastel Lavender
                'icon' => 'fa-sun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Animals',
                'color' => '#F0E6D6',  // Pastel Beige
                'icon' => 'fa-paw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Taxes',
                'color' => '#D5E1E4',  // Pastel Light Blue
                'icon' => 'fa-file-invoice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Other Expenses',
                'color' => '#D6C8E2',  // Pastel Lavender
                'icon' => 'fa-wallet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
