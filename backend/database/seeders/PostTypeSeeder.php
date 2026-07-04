<?php

namespace Database\Seeders;

use App\Models\PostType;
use Illuminate\Database\Seeder;

class PostTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Aviso', 'description' => 'Comunicados importantes da academia'],
            ['name' => 'Marketing', 'description' => 'Postagens de divulgação e promoções'],
            ['name' => 'Evento', 'description' => 'Eventos, aulões e competições'],
            ['name' => 'Dica', 'description' => 'Dicas de treino, nutrição e bem-estar'],
            ['name' => 'Informativo', 'description' => 'Informações gerais sobre a academia'],
        ];

        foreach ($types as $type) {
            PostType::updateOrCreate(
                ['name' => $type['name']],
                array_merge($type, ['is_active' => true])
            );
        }
    }
}
