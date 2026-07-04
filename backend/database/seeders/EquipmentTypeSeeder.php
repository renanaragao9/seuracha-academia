<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Barra',             'description' => 'Barra olímpica ou comum para exercícios com peso livre'],
            ['name' => 'Haltere',           'description' => 'Par de pesos livres para exercícios unilaterais ou bilaterais'],
            ['name' => 'Kettlebell',        'description' => 'Peso em formato de sino para exercícios funcionais'],
            ['name' => 'Máquina',           'description' => 'Equipamento guiado por trilhos ou cabos'],
            ['name' => 'Cabo e Polia',      'description' => 'Sistema de cabos e polias para exercícios variados'],
            ['name' => 'Elástico',          'description' => 'Faixa ou tubo elástico para resistência progressiva'],
            ['name' => 'Bola Suíça',        'description' => 'Bola de estabilidade para core e equilíbrio'],
            ['name' => 'TRX / Suspensão',   'description' => 'Treinamento em suspensão com alças'],
            ['name' => 'Banco',             'description' => 'Banco plano, inclinado ou declinado'],
            ['name' => 'Esteira',           'description' => 'Equipamento de cardio para caminhada e corrida'],
            ['name' => 'Bicicleta Ergométrica', 'description' => 'Equipamento de cardio em formato de bicicleta'],
            ['name' => 'Remo Ergométrico',  'description' => 'Equipamento de cardio que simula o remo'],
            ['name' => 'Peso Corporal',     'description' => 'Exercícios realizados apenas com o peso do próprio corpo'],
        ];

        foreach ($types as $type) {
            EquipmentType::updateOrCreate(
                ['name' => $type['name']],
                array_merge($type, ['is_active' => true])
            );
        }
    }
}
