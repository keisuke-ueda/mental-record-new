<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disease;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['disease' => 'うつ病', 'disease_summary' => '気分の落ち込みや意欲低下が続く状態'],
            ['disease' => '不安障害', 'disease_summary' => '強い不安や恐怖が持続する状態'],
            ['disease' => '適応障害', 'disease_summary' => '環境変化への適応が困難になる状態'],
        ];

        foreach ($items as $item) {
            Disease::firstOrCreate(
                ['disease' => $item['disease']],
                ['disease_summary' => $item['disease_summary']]
            );
        }
    }
}
