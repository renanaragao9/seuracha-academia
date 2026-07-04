<?php

namespace Database\Seeders;

use App\Models\ItemType;
use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Equipamento',       'description' => 'Aparelhos e equipamentos de musculação'],
            ['name' => 'Acessório',         'description' => 'Acessórios de treino — luvas, cinto, munhequeira'],
            ['name' => 'Vestuário',         'description' => 'Roupas e calçados esportivos'],
            ['name' => 'Suplemento',        'description' => 'Suplementos alimentares e vitaminas'],
            ['name' => 'Material de Limpeza', 'description' => 'Produtos de higiene e limpeza da academia'],
            ['name' => 'Mobiliário',        'description' => 'Móveis e itens de infraestrutura'],
            ['name' => 'Tecnologia',        'description' => 'Dispositivos eletrônicos e sistemas'],
            ['name' => 'Serviço',           'description' => 'Serviços contratados — manutenção, consultoria'],
        ];

        foreach ($types as $type) {
            ItemType::updateOrCreate(
                ['name' => $type['name']],
                array_merge($type, ['is_active' => true])
            );
        }
    }
}
