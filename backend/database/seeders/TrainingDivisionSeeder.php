<?php

namespace Database\Seeders;

use App\Models\TrainingDivision;
use Illuminate\Database\Seeder;

class TrainingDivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            ['name' => 'A', 'description' => 'Treino A — Peito e Tríceps'],
            ['name' => 'B', 'description' => 'Treino B — Costas e Bíceps'],
            ['name' => 'C', 'description' => 'Treino C — Pernas e Glúteos'],
            ['name' => 'D', 'description' => 'Treino D — Ombros e Trapézio'],
            ['name' => 'E', 'description' => 'Treino E — Abdômen e Core'],
            ['name' => 'Full Body', 'description' => 'Treino de corpo inteiro'],
            ['name' => 'Upper', 'description' => 'Treino de membros superiores'],
            ['name' => 'Lower', 'description' => 'Treino de membros inferiores'],
            ['name' => 'Push', 'description' => 'Treino de empurrar — Peito, Ombro e Tríceps'],
            ['name' => 'Pull', 'description' => 'Treino de puxar — Costas e Bíceps'],
        ];

        foreach ($divisions as $division) {
            TrainingDivision::updateOrCreate(
                ['name' => $division['name']],
                array_merge($division, ['is_active' => true])
            );
        }
    }
}
