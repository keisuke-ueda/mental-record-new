<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Symptom; 

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['symptom' => '不眠', 'symptom_summary' => '眠れない、または途中で目が覚める'],
            ['symptom' => '食欲低下', 'symptom_summary' => '食事量が減る状態'],
            ['symptom' => '倦怠感', 'symptom_summary' => '強い疲労感が続く'],
        ];

        foreach ($items as $item) {
            Symptom::firstOrCreate(
                ['symptom' => $item['symptom']],
                ['symptom_summary' => $item['symptom_summary']]
            );
        }
    }
}
