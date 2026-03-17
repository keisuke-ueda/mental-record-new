<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;   

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['medicine' => 'セルトラリン', 'efficacy' => '抗うつ作用'],
            ['medicine' => 'ロラゼパム', 'efficacy' => '抗不安作用'],
            ['medicine' => 'アルプラゾラム', 'efficacy' => '抗不安作用'],
        ];

        foreach ($items as $item) {
            Medicine::firstOrCreate(
                ['medicine' => $item['medicine']],
                ['efficacy' => $item['efficacy']]
            );
        }
    }
}
