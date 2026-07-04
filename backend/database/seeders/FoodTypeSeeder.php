<?php

namespace Database\Seeders;

use App\Models\FoodType;
use Illuminate\Database\Seeder;

class FoodTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Proteína',          'description' => 'Alimentos ricos em proteína — carnes, ovos, laticínios'],
            ['name' => 'Carboidrato',        'description' => 'Alimentos ricos em carboidratos — arroz, macarrão, pão'],
            ['name' => 'Gordura Saudável',   'description' => 'Fontes de gorduras boas — azeite, abacate, castanhas'],
            ['name' => 'Vegetal',            'description' => 'Legumes e verduras em geral'],
            ['name' => 'Fruta',              'description' => 'Frutas frescas ou secas'],
            ['name' => 'Leguminosa',         'description' => 'Feijão, lentilha, grão-de-bico, ervilha'],
            ['name' => 'Laticínio',          'description' => 'Leite, queijo, iogurte e derivados'],
            ['name' => 'Suplemento',         'description' => 'Whey protein, creatina, BCAA e outros suplementos'],
            ['name' => 'Bebida',             'description' => 'Água, sucos, chás e outras bebidas'],
            ['name' => 'Cereal Integral',    'description' => 'Aveia, granola, quinoa e cereais integrais'],
            ['name' => 'Fast Food',          'description' => 'Alimentos ultraprocessados e de preparo rápido'],
        ];

        foreach ($types as $type) {
            FoodType::updateOrCreate(
                ['name' => $type['name']],
                array_merge($type, ['is_active' => true])
            );
        }
    }
}
