<?php

namespace Database\Seeders;

use App\Models\Waste;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WasteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wastes = [
            ['number_of_colors' => 0, 'waste_percentage' => 100.00, 'price' => 3.00],
            ['number_of_colors' => 1, 'waste_percentage' => 100.00, 'price' => 5.00],
            ['number_of_colors' => 2, 'waste_percentage' => 100.00, 'price' => 5.00],
            ['number_of_colors' => 3, 'waste_percentage' => 150.00, 'price' => 5.00],
            ['number_of_colors' => 4, 'waste_percentage' => 300.00, 'price' => 8.50],
            ['number_of_colors' => 5, 'waste_percentage' => 350.00, 'price' => 9.50],
            ['number_of_colors' => 6, 'waste_percentage' => 400.00, 'price' => 12.00],
        ];

        foreach ($wastes as $waste) {
            Waste::firstOrCreate(
                ['number_of_colors' => $waste['number_of_colors']],
                [
                    'waste_percentage' => $waste['waste_percentage'],
                    'price' => $waste['price'],
                    'waste_per_roll' => 0.00, // Default value since not provided in the image
                ]
            );
        }
    }
}

