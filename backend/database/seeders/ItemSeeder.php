<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Suplemento' => [
                [
                    'name' => 'Whey Protein Concentrado 1kg',
                    'description' => 'Proteína do soro do leite concentrada, 1kg.',
                    'total_price' => 89.90,
                    'promotion_price' => 79.90,
                ],
                [
                    'name' => 'Whey Protein Isolado 900g',
                    'description' => 'Proteína isolada de alta absorção, 900g.',
                    'total_price' => 149.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Creatina Monohidratada 300g',
                    'description' => 'Creatina pura para ganho de força e volume.',
                    'total_price' => 59.90,
                    'promotion_price' => 49.90,
                ],
                [
                    'name' => 'BCAA 2:1:1 200 cápsulas',
                    'description' => 'Aminoácidos de cadeia ramificada para recuperação.',
                    'total_price' => 49.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Pré-Treino 300g',
                    'description' => 'Fórmula energética para treinos intensos.',
                    'total_price' => 79.90,
                    'promotion_price' => 69.90,
                ],
                [
                    'name' => 'Hipercalórico 3kg',
                    'description' => 'Ganho de massa muscular e calórico.',
                    'total_price' => 119.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Glutamina 300g',
                    'description' => 'Recuperação muscular pós-treino.',
                    'total_price' => 44.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Colágeno Hidrolisado 300g',
                    'description' => 'Suporte para articulações e pele.',
                    'total_price' => 39.90,
                    'promotion_price' => 34.90,
                ],
                [
                    'name' => 'Albumina 500g',
                    'description' => 'Proteína de ovo de lenta absorção.',
                    'total_price' => 34.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Termogênico 60 cápsulas',
                    'description' => 'Auxílio na queima de gordura corporal.',
                    'total_price' => 69.90,
                    'promotion_price' => 59.90,
                ],
            ],

            'Acessório' => [
                [
                    'name' => 'Luva de Treino',
                    'description' => 'Luva antiderrapante para musculação.',
                    'total_price' => 49.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Cinto Abdominal Couro',
                    'description' => 'Cinto de couro para suporte lombar.',
                    'total_price' => 89.90,
                    'promotion_price' => 79.90,
                ],
                [
                    'name' => 'Munhequeira Par',
                    'description' => 'Munhequeira elástica para proteção do pulso.',
                    'total_price' => 29.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Joelheira Par',
                    'description' => 'Joelheira compressiva para treinos pesados.',
                    'total_price' => 39.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Straps de Pulso Par',
                    'description' => 'Straps para puxadas e remadas.',
                    'total_price' => 24.90,
                    'promotion_price' => 19.90,
                ],
                [
                    'name' => 'Squeeze 700ml',
                    'description' => 'Garrafa esportiva com bico.',
                    'total_price' => 19.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Toalha de Academia',
                    'description' => 'Toalha microfibra de secagem rápida.',
                    'total_price' => 29.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Coqueteleira 600ml',
                    'description' => 'Coqueteleira com mola misturadora.',
                    'total_price' => 34.90,
                    'promotion_price' => 29.90,
                ],
                [
                    'name' => 'Elástico de Resistência Kit',
                    'description' => 'Kit com 5 elásticos de resistências variadas.',
                    'total_price' => 59.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Rolo de Foam Roller',
                    'description' => 'Rolo de liberação miofascial.',
                    'total_price' => 79.90,
                    'promotion_price' => 69.90,
                ],
            ],

            'Vestuário' => [
                [
                    'name' => 'Camiseta Dry Fit M',
                    'description' => 'Camiseta de treino masculina, tecido dry fit.',
                    'total_price' => 59.90,
                    'promotion_price' => 49.90,
                ],
                [
                    'name' => 'Camiseta Dry Fit F',
                    'description' => 'Camiseta de treino feminina, tecido dry fit.',
                    'total_price' => 59.90,
                    'promotion_price' => 49.90,
                ],
                [
                    'name' => 'Shorts de Treino M',
                    'description' => 'Shorts masculino com bolso e elástico.',
                    'total_price' => 69.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Legging Feminina',
                    'description' => 'Legging de compressão com cintura alta.',
                    'total_price' => 89.90,
                    'promotion_price' => 79.90,
                ],
                [
                    'name' => 'Top Esportivo',
                    'description' => 'Top feminino com suporte médio.',
                    'total_price' => 59.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Meia Esportiva Par',
                    'description' => 'Meia cano médio para treino.',
                    'total_price' => 19.90,
                    'promotion_price' => null,
                ],
                [
                    'name' => 'Tênis de Treino M',
                    'description' => 'Tênis masculino para musculação e funcional.',
                    'total_price' => 199.90,
                    'promotion_price' => 179.90,
                ],
                [
                    'name' => 'Tênis de Treino F',
                    'description' => 'Tênis feminino para musculação e funcional.',
                    'total_price' => 199.90,
                    'promotion_price' => 179.90,
                ],
            ],
        ];

        foreach ($items as $typeName => $typeItems) {
            $itemType = ItemType::where('name', $typeName)->first();

            if (! $itemType) {
                continue;
            }

            foreach ($typeItems as $item) {
                Item::updateOrCreate(
                    ['name' => $item['name']],
                    [
                        'description' => $item['description'],
                        'total_price' => $item['total_price'],
                        'promotion_price' => $item['promotion_price'],
                        'item_type_id' => $itemType->id,
                    ]
                );
            }
        }
    }
}
