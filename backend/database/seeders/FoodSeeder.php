<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\FoodType;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            'Proteína' => [
                ['name' => 'Frango grelhado'],
                ['name' => 'Peito de frango'],
                ['name' => 'Carne bovina magra'],
                ['name' => 'Patinho moído'],
                ['name' => 'Tilápia'],
                ['name' => 'Salmão'],
                ['name' => 'Atum em lata (água)'],
                ['name' => 'Ovo inteiro'],
                ['name' => 'Clara de ovo'],
                ['name' => 'Carne suína (lombo)'],
                ['name' => 'Sardinha'],
                ['name' => 'Camarão'],
            ],

            'Carboidrato' => [
                ['name' => 'Arroz branco'],
                ['name' => 'Arroz integral'],
                ['name' => 'Macarrão'],
                ['name' => 'Pão integral'],
                ['name' => 'Pão branco'],
                ['name' => 'Batata inglesa'],
                ['name' => 'Batata doce'],
                ['name' => 'Mandioca'],
                ['name' => 'Inhame'],
                ['name' => 'Cará'],
                ['name' => 'Tapioca'],
                ['name' => 'Cuscuz de milho'],
            ],

            'Gordura Saudável' => [
                ['name' => 'Azeite de oliva'],
                ['name' => 'Abacate'],
                ['name' => 'Castanha-do-pará'],
                ['name' => 'Castanha de caju'],
                ['name' => 'Amendoim'],
                ['name' => 'Amêndoas'],
                ['name' => 'Nozes'],
                ['name' => 'Óleo de coco'],
                ['name' => 'Pasta de amendoim integral'],
                ['name' => 'Linhaça'],
                ['name' => 'Chia'],
            ],

            'Vegetal' => [
                ['name' => 'Brócolis'],
                ['name' => 'Couve-flor'],
                ['name' => 'Espinafre'],
                ['name' => 'Alface'],
                ['name' => 'Rúcula'],
                ['name' => 'Cenoura'],
                ['name' => 'Beterraba'],
                ['name' => 'Abobrinha'],
                ['name' => 'Pepino'],
                ['name' => 'Tomate'],
                ['name' => 'Couve'],
                ['name' => 'Berinjela'],
                ['name' => 'Chuchu'],
                ['name' => 'Vagem'],
                ['name' => 'Pimentão'],
            ],

            'Fruta' => [
                ['name' => 'Banana'],
                ['name' => 'Maçã'],
                ['name' => 'Pera'],
                ['name' => 'Laranja'],
                ['name' => 'Melancia'],
                ['name' => 'Melão'],
                ['name' => 'Mamão'],
                ['name' => 'Manga'],
                ['name' => 'Uva'],
                ['name' => 'Morango'],
                ['name' => 'Kiwi'],
                ['name' => 'Abacaxi'],
                ['name' => 'Goiaba'],
                ['name' => 'Maracujá'],
                ['name' => 'Tâmara'],
            ],

            'Leguminosa' => [
                ['name' => 'Feijão preto'],
                ['name' => 'Feijão carioca'],
                ['name' => 'Lentilha'],
                ['name' => 'Grão-de-bico'],
                ['name' => 'Ervilha'],
                ['name' => 'Soja'],
                ['name' => 'Edamame'],
                ['name' => 'Feijão-fradinho'],
            ],

            'Laticínio' => [
                ['name' => 'Leite integral'],
                ['name' => 'Leite desnatado'],
                ['name' => 'Iogurte natural'],
                ['name' => 'Iogurte grego'],
                ['name' => 'Queijo cottage'],
                ['name' => 'Queijo minas frescal'],
                ['name' => 'Requeijão light'],
                ['name' => 'Cream cheese'],
                ['name' => 'Ricota'],
                ['name' => 'Leite em pó desnatado'],
            ],

            'Suplemento' => [
                ['name' => 'Whey protein concentrado'],
                ['name' => 'Whey protein isolado'],
                ['name' => 'Caseína'],
                ['name' => 'Creatina'],
                ['name' => 'BCAA'],
                ['name' => 'Glutamina'],
                ['name' => 'Hipercalórico'],
                ['name' => 'Pré-treino'],
                ['name' => 'Albumina'],
                ['name' => 'Colágeno hidrolisado'],
            ],

            'Bebida' => [
                ['name' => 'Água'],
                ['name' => 'Água de coco'],
                ['name' => 'Suco de laranja natural'],
                ['name' => 'Suco de melancia'],
                ['name' => 'Chá verde'],
                ['name' => 'Chá de camomila'],
                ['name' => 'Café sem açúcar'],
                ['name' => 'Leite vegetal (aveia)'],
                ['name' => 'Leite vegetal (amêndoas)'],
                ['name' => 'Isotônico'],
            ],

            'Cereal Integral' => [
                ['name' => 'Aveia em flocos'],
                ['name' => 'Farinha de aveia'],
                ['name' => 'Granola sem açúcar'],
                ['name' => 'Quinoa'],
                ['name' => 'Amaranto'],
                ['name' => 'Farelo de trigo'],
                ['name' => 'Farelo de aveia'],
                ['name' => 'Farinha de centeio'],
                ['name' => 'Trigo-sarraceno'],
            ],

            'Fast Food' => [
                ['name' => 'Hambúrguer'],
                ['name' => 'Pizza'],
                ['name' => 'Batata frita'],
                ['name' => 'Hot dog'],
                ['name' => 'Nuggets de frango'],
                ['name' => 'Cachorro-quente'],
                ['name' => 'Salgadinho de pacote'],
                ['name' => 'Refrigerante'],
            ],
        ];

        foreach ($foods as $typeName => $items) {
            $foodType = FoodType::where('name', $typeName)->first();

            if (! $foodType) {
                continue;
            }

            foreach ($items as $item) {
                Food::updateOrCreate(
                    [
                        'name' => $item['name'],
                        'food_type_id' => $foodType->id,
                    ],
                    [
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
