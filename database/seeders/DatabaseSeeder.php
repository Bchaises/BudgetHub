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
                'id' => 5,
                'title' => 'Groceries',
                'color' => '#E8BCA7',
                'icon' => 'fa-cart-shopping',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 13,
                'title' => 'Dining Out',
                'color' => '#E8DCA7',
                'icon' => 'fa-utensils',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'title' => 'Leisure',
                'color' => '#EAEF95',
                'icon' => 'fa-gamepad',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'title' => 'Transports',
                'color' => '#A3CDE3',
                'icon' => 'fa-car',
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'title' => 'Housing',
                'color' => '#99BDA2',
                'icon' => 'fa-home',
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'title' => 'Daily Life',
                'color' => '#B2A3E3',
                'icon' => 'fa-house-user',
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'title' => 'Holidays / Weekend',
                'color' => '#F57F7F',
                'icon' => 'fa-sun',
                'order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 1,
                'title' => 'Animals',
                'color' => '#B38340',
                'icon' => 'fa-paw',
                'order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'title' => 'Health',
                'color' => '#DE6FB0',
                'icon' => 'fa-heartbeat',
                'order' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'title' => 'Savings',
                'color' => '#BBEDC5',
                'icon' => 'fa-piggy-bank',
                'order' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'title' => 'Other',
                'color' => '#D5BBED',
                'icon' => 'fa-wallet',
                'order' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 14,
                'title' => 'Renovation',
                'color' => '#FA989A',
                'icon' => 'fa-brush',
                'order' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ], ['id'], ['title', 'color', 'icon', 'order', 'updated_at']);
    }
}
