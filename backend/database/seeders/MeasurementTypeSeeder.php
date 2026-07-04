<?php

namespace Database\Seeders;

use App\Models\MeasurementType;
use Illuminate\Database\Seeder;

class MeasurementTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Peso',              'description' => 'Peso corporal total em kg'],
            ['name' => 'Altura',            'description' => 'Estatura em cm'],
            ['name' => 'IMC',               'description' => 'Índice de Massa Corporal'],
            ['name' => 'Percentual de Gordura', 'description' => 'Percentual de gordura corporal'],
            ['name' => 'Massa Muscular',    'description' => 'Massa muscular esquelética em kg'],
            ['name' => 'Circunferência Abdominal', 'description' => 'Medida da cintura em cm'],
            ['name' => 'Circunferência do Peito',  'description' => 'Medida do tórax em cm'],
            ['name' => 'Circunferência do Braço',  'description' => 'Medida do bíceps em cm'],
            ['name' => 'Circunferência da Coxa',   'description' => 'Medida da coxa em cm'],
            ['name' => 'Circunferência do Quadril', 'description' => 'Medida do quadril em cm'],
            ['name' => 'Dobra Cutânea',     'description' => 'Medida de dobras cutâneas em mm'],
            ['name' => 'Água Corporal',     'description' => 'Percentual de água no corpo'],
        ];

        foreach ($types as $type) {
            MeasurementType::updateOrCreate(
                ['name' => $type['name']],
                array_merge($type, ['is_active' => true])
            );
        }
    }
}
