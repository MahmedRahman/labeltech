<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            ['name' => 'ورق 1/2 لميع ضهر ورق ابيض', 'price' => 17.00],
            ['name' => 'ورق 1/2 لميع ضهر ورق اصفر', 'price' => 17.00],
            ['name' => 'ورق 1/2 لميع ضهر شفاف', 'price' => 17.00],
            ['name' => 'بلاستيك ضهر ورق ابيض', 'price' => 22.00],
            ['name' => 'بلاستيك ضهر ورق اصفر', 'price' => 22.00],
            ['name' => 'بلاستيك ضهر شفاف', 'price' => 22.00],
            ['name' => 'بلاستيك حراري ضهر ورق ابيض', 'price' => 22.00],
            ['name' => 'بلاستيك حراري ضهر ورق اصفر', 'price' => 22.00],
            ['name' => 'حراري ضهر ورق ابيض', 'price' => 21.00],
            ['name' => 'حراري ضهر ورق اصفر', 'price' => 21.00],
            ['name' => 'حرارى ضهر كرتون', 'price' => 21.00],
            ['name' => 'حرارى ثلاجه', 'price' => 23.00],
            ['name' => 'شفاف ضهر ورق ابيض', 'price' => 22.00],
            ['name' => 'شفاف ضهر ورق اصفر', 'price' => 22.00],
            ['name' => 'شفاف ضهر شفاف', 'price' => 22.00],
            ['name' => 'ميتاليز ضهر ورق ابيض', 'price' => 22.00],
            ['name' => 'ميتاليز ضهر ورق اصفر', 'price' => 22.00],
            ['name' => 'ميتاليز ضهر شفاف', 'price' => 22.00],
            ['name' => 'مط خشن', 'price' => 17.00],
        ];

        foreach ($materials as $material) {
            Material::firstOrCreate(
                ['name' => $material['name']],
                [
                    'price' => $material['price'],
                    'is_active' => true,
                ]
            );
        }
    }
}




