<?php

namespace Database\Seeders;

use App\Models\Addition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $additions = [
            ['name' => 'سلوفان', 'price' => 6.00],
            ['name' => 'سلوفان مط', 'price' => 6.00],
            ['name' => 'يوفي', 'price' => 1.50],
        ];

        foreach ($additions as $addition) {
            Addition::firstOrCreate(
                ['name' => $addition['name']],
                ['price' => $addition['price']]
            );
        }
    }
}
