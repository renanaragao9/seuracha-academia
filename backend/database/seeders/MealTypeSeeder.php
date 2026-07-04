<?php

namespace Database\Seeders;

use App\Models\MealType;
use Illuminate\Database\Seeder;

class MealTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Café da Manhã',     'description' => 'Primeira refeição do dia'],
            ['name' => 'Lanche da Manhã',   'description' => 'Refeição leve entre o café e o almoço'],
            ['name' => 'Almoço',            'description' => 'Refeição principal do meio-dia'],
            ['name' => 'Lanche da Tarde',   'description' => 'Refeição leve entre o almoço e o jantar'],
            ['name' => 'Jantar',            'description' => 'Refeição principal da noite'],
            ['name' => 'Ceia',              'description' => 'Refeição leve antes de dormir'],
            ['name' => 'Pré-Treino',        'description' => 'Refeição consumida antes do treino'],
            ['name' => 'Pós-Treino',        'description' => 'Refeição consumida após o treino para recuperação'],
            ['name' => 'Intra-Treino',      'description' => 'Alimentação consumida durante o treino'],
        ];

        foreach ($types as $type) {
            MealType::updateOrCreate(
                ['name' => $type['name']],
                array_merge($type, ['is_active' => true])
            );
        }
    }
}
