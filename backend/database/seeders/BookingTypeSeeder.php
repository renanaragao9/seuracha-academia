<?php

namespace Database\Seeders;

use App\Models\BookingType;
use Illuminate\Database\Seeder;

class BookingTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Funcional',            'description' => 'Treino funcional com exercícios variados'],
            ['name' => 'Zumba',                'description' => 'Dança fitness com coreografias latinas'],
            ['name' => 'HIIT',                 'description' => 'Treino intervalado de alta intensidade'],
            ['name' => 'Muay Thai',            'description' => 'Arte marcial tailandesa'],
            ['name' => 'Jiu-Jitsu',            'description' => 'Arte marcial japonesa de grappling e submissão'],
            ['name' => 'Judô',                 'description' => 'Arte marcial japonesa de projeções e quedas'],
            ['name' => 'Karatê',               'description' => 'Arte marcial japonesa de golpes'],
            ['name' => 'Capoeira',             'description' => 'Arte marcial brasileira que mistura dança e música'],
        ];

        foreach ($types as $type) {
            BookingType::updateOrCreate(
                ['name' => $type['name']],
                array_merge($type, ['is_active' => true])
            );
        }
    }
}
