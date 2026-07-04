<?php

namespace Database\Seeders;

use App\Models\MuscleGroup;
use Illuminate\Database\Seeder;

class MuscleGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['name' => 'Peito',       'description' => 'Músculo peitoral maior e menor'],
            ['name' => 'Costas',      'description' => 'Latíssimo do dorso, romboides e trapézio'],
            ['name' => 'Ombros',      'description' => 'Deltoides anterior, medial e posterior'],
            ['name' => 'Bíceps',      'description' => 'Bíceps braquial e braquiorradial'],
            ['name' => 'Tríceps',     'description' => 'Tríceps braquial — cabeças longa, lateral e medial'],
            ['name' => 'Antebraço',   'description' => 'Flexores e extensores do antebraço'],
            ['name' => 'Abdômen',     'description' => 'Reto abdominal, oblíquos e transverso'],
            ['name' => 'Quadríceps',  'description' => 'Quatro cabeças da parte anterior da coxa'],
            ['name' => 'Posterior de Coxa', 'description' => 'Isquiotibiais — bíceps femoral, semitendíneo e semimembranoso'],
            ['name' => 'Glúteos',     'description' => 'Glúteo máximo, médio e mínimo'],
            ['name' => 'Panturrilha', 'description' => 'Gastrocnêmio e sóleo'],
            ['name' => 'Lombar',      'description' => 'Eretores da espinha e multífidos'],
            ['name' => 'Trapézio',    'description' => 'Trapézio superior, médio e inferior'],
            ['name' => 'Core',        'description' => 'Musculatura estabilizadora do tronco'],
        ];

        foreach ($groups as $group) {
            MuscleGroup::updateOrCreate(
                ['name' => $group['name']],
                array_merge($group, ['is_active' => true])
            );
        }
    }
}
