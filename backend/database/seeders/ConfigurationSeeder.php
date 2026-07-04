<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        Configuration::create([
            'name' => 'Academia SeuRacha',
            'cnpj' => '12.345.678/0001-90',
            'email' => 'contato@academiaeuarcha.com.br',
            'phone' => '(85) 3333-3333',
            'whatsapp' => '(85) 99999-9999',
            'emergency_phone' => '(85) 9999-8888',
            'zip_code' => '60115-000',
            'address' => 'Avenida Getúlio Vargas',
            'number' => '1500',
            'complement' => 'Sala 1',
            'neighborhood' => 'Aldeota',
            'city' => 'Fortaleza',
            'state' => 'CE',
            'website' => 'www.academiaeuarcha.com.br',
            'instagram' => '@academiaeuarcha',
            'facebook' => 'academiaeuarcha',
            'youtube' => '@academiaeuarcha',
            'description' => 'Academia SeuRacha - Sua melhor escolha em Fortaleza para treino e bem-estar.',
            'notes' => 'Primeira unidade em Fortaleza',
            'opening_hours' => 'Segunda a Sexta: 06:00 - 22:00, Sábado: 08:00 - 18:00, Domingo: Fechado',
            'opening_time' => '06:00',
            'closing_time' => '22:00',
        ]);
    }
}
