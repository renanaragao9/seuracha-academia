<?php

namespace Database\Seeders;

use App\Models\MealPlanTemplate;
use Illuminate\Database\Seeder;

class MealPlanTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Emagrecimento 1500kcal',
                'description' => 'Plano de emagrecimento com déficit calórico moderado. 5 refeições diárias equilibradas com foco em proteínas magras e vegetais.',
                'goal' => 'emagrecimento',
                'template_data' => [
                    'guidelines' => 'Beber 2L de água por dia. Evitar frituras e açúcares. Priorizar alimentos integrais.',
                    'meals' => [
                        [
                            'meal_type_name' => 'Café da Manhã',
                            'order' => 1,
                            'foods' => [
                                ['food_name' => 'Ovo inteiro', 'quantity' => 2, 'unit' => 'unidades', 'observation' => 'mexidos ou cozidos'],
                                ['food_name' => 'Pão integral', 'quantity' => 2, 'unit' => 'fatias', 'observation' => 'com requeijão light'],
                                ['food_name' => 'Café sem açúcar', 'quantity' => 1, 'unit' => 'xícara', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Lanche da Manhã',
                            'order' => 2,
                            'foods' => [
                                ['food_name' => 'Iogurte natural', 'quantity' => 1, 'unit' => 'unidade', 'observation' => '170g'],
                                ['food_name' => 'Aveia em flocos', 'quantity' => 2, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Morango', 'quantity' => 5, 'unit' => 'unidades', 'observation' => 'picados'],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Almoço',
                            'order' => 3,
                            'foods' => [
                                ['food_name' => 'Frango grelhado', 'quantity' => 120, 'unit' => 'g', 'observation' => null],
                                ['food_name' => 'Arroz integral', 'quantity' => 3, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Feijão preto', 'quantity' => 1, 'unit' => 'concha', 'observation' => null],
                                ['food_name' => 'Brócolis', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'no vapor'],
                                ['food_name' => 'Azeite de oliva', 'quantity' => 1, 'unit' => 'colher', 'observation' => 'sobre a salada'],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Lanche da Tarde',
                            'order' => 4,
                            'foods' => [
                                ['food_name' => 'Banana', 'quantity' => 1, 'unit' => 'unidade', 'observation' => null],
                                ['food_name' => 'Castanha-do-pará', 'quantity' => 3, 'unit' => 'unidades', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Jantar',
                            'order' => 5,
                            'foods' => [
                                ['food_name' => 'Tilápia', 'quantity' => 120, 'unit' => 'g', 'observation' => 'grelhada'],
                                ['food_name' => 'Batata doce', 'quantity' => 100, 'unit' => 'g', 'observation' => 'cozida'],
                                ['food_name' => 'Rúcula', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'salada com tomate'],
                                ['food_name' => 'Abobrinha', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'refogada'],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Hipertrofia 2500kcal',
                'description' => 'Plano para ganho de massa muscular com superávit calórico. 6 refeições diárias ricas em proteína e carboidratos de qualidade.',
                'goal' => 'hipertrofia',
                'template_data' => [
                    'guidelines' => 'Consumir ao menos 2g de proteína por kg corporal. Beber 3L de água. Dormir 7-8h por noite.',
                    'meals' => [
                        [
                            'meal_type_name' => 'Café da Manhã',
                            'order' => 1,
                            'foods' => [
                                ['food_name' => 'Ovo inteiro', 'quantity' => 3, 'unit' => 'unidades', 'observation' => 'mexidos'],
                                ['food_name' => 'Pão integral', 'quantity' => 3, 'unit' => 'fatias', 'observation' => null],
                                ['food_name' => 'Banana', 'quantity' => 1, 'unit' => 'unidade', 'observation' => null],
                                ['food_name' => 'Leite integral', 'quantity' => 200, 'unit' => 'ml', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Lanche da Manhã',
                            'order' => 2,
                            'foods' => [
                                ['food_name' => 'Iogurte grego', 'quantity' => 1, 'unit' => 'unidade', 'observation' => null],
                                ['food_name' => 'Granola sem açúcar', 'quantity' => 3, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Melancia', 'quantity' => 2, 'unit' => 'fatias', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Almoço',
                            'order' => 3,
                            'foods' => [
                                ['food_name' => 'Peito de frango', 'quantity' => 180, 'unit' => 'g', 'observation' => 'grelhado'],
                                ['food_name' => 'Arroz branco', 'quantity' => 5, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Feijão carioca', 'quantity' => 1, 'unit' => 'concha', 'observation' => null],
                                ['food_name' => 'Couve', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'refogada'],
                                ['food_name' => 'Vagem', 'quantity' => 1, 'unit' => 'xícara', 'observation' => null],
                                ['food_name' => 'Azeite de oliva', 'quantity' => 1, 'unit' => 'colher', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Pré-Treino',
                            'order' => 4,
                            'foods' => [
                                ['food_name' => 'Batata doce', 'quantity' => 150, 'unit' => 'g', 'observation' => 'cozida'],
                                ['food_name' => 'Frango grelhado', 'quantity' => 80, 'unit' => 'g', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Pós-Treino',
                            'order' => 5,
                            'foods' => [
                                ['food_name' => 'Whey protein concentrado', 'quantity' => 30, 'unit' => 'g', 'observation' => 'com água ou leite'],
                                ['food_name' => 'Banana', 'quantity' => 1, 'unit' => 'unidade', 'observation' => null],
                                ['food_name' => 'Aveia em flocos', 'quantity' => 2, 'unit' => 'colheres', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Jantar',
                            'order' => 6,
                            'foods' => [
                                ['food_name' => 'Salmão', 'quantity' => 150, 'unit' => 'g', 'observation' => 'grelhado'],
                                ['food_name' => 'Arroz integral', 'quantity' => 4, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Brócolis', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'no vapor'],
                                ['food_name' => 'Abacate', 'quantity' => 0.5, 'unit' => 'unidade', 'observation' => null],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Equilibrado 2000kcal',
                'description' => 'Plano balanceado para manutenção de peso. 5 refeições variadas com todos os grupos alimentares.',
                'goal' => 'equilibrado',
                'template_data' => [
                    'guidelines' => 'Manter hidratação adequada. Variar os vegetais diariamente. Evitar alimentos ultraprocessados.',
                    'meals' => [
                        [
                            'meal_type_name' => 'Café da Manhã',
                            'order' => 1,
                            'foods' => [
                                ['food_name' => 'Pão integral', 'quantity' => 2, 'unit' => 'fatias', 'observation' => 'com queijo minas frescal'],
                                ['food_name' => 'Ovo inteiro', 'quantity' => 2, 'unit' => 'unidades', 'observation' => 'mexidos'],
                                ['food_name' => 'Mamão', 'quantity' => 1, 'unit' => 'fatia', 'observation' => null],
                                ['food_name' => 'Café sem açúcar', 'quantity' => 1, 'unit' => 'xícara', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Lanche da Manhã',
                            'order' => 2,
                            'foods' => [
                                ['food_name' => 'Banana', 'quantity' => 1, 'unit' => 'unidade', 'observation' => null],
                                ['food_name' => 'Castanha de caju', 'quantity' => 5, 'unit' => 'unidades', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Almoço',
                            'order' => 3,
                            'foods' => [
                                ['food_name' => 'Carne bovina magra', 'quantity' => 120, 'unit' => 'g', 'observation' => 'grelhada'],
                                ['food_name' => 'Arroz branco', 'quantity' => 4, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Feijão preto', 'quantity' => 1, 'unit' => 'concha', 'observation' => null],
                                ['food_name' => 'Cenoura', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'ralada'],
                                ['food_name' => 'Alface', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'salada'],
                                ['food_name' => 'Azeite de oliva', 'quantity' => 1, 'unit' => 'colher', 'observation' => 'tempero'],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Lanche da Tarde',
                            'order' => 4,
                            'foods' => [
                                ['food_name' => 'Iogurte natural', 'quantity' => 1, 'unit' => 'unidade', 'observation' => null],
                                ['food_name' => 'Aveia em flocos', 'quantity' => 2, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Maçã', 'quantity' => 1, 'unit' => 'unidade', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Jantar',
                            'order' => 5,
                            'foods' => [
                                ['food_name' => 'Atum em lata (água)', 'quantity' => 1, 'unit' => 'lata', 'observation' => null],
                                ['food_name' => 'Mandioca', 'quantity' => 100, 'unit' => 'g', 'observation' => 'cozida'],
                                ['food_name' => 'Couve-flor', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'refogada'],
                                ['food_name' => 'Tomate', 'quantity' => 4, 'unit' => 'fatias', 'observation' => null],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Low Carb',
                'description' => 'Plano com redução de carboidratos. 5 refeições priorizando proteínas, gorduras saudáveis e vegetais de baixo índice glicêmico.',
                'goal' => 'lowcarb',
                'template_data' => [
                    'guidelines' => 'Evitar pães, arroz e massas. Priorizar vegetais folhosos. Consumir gorduras boas.',
                    'meals' => [
                        [
                            'meal_type_name' => 'Café da Manhã',
                            'order' => 1,
                            'foods' => [
                                ['food_name' => 'Ovo inteiro', 'quantity' => 3, 'unit' => 'unidades', 'observation' => 'omelete'],
                                ['food_name' => 'Queijo minas frescal', 'quantity' => 2, 'unit' => 'fatias', 'observation' => null],
                                ['food_name' => 'Abacate', 'quantity' => 0.5, 'unit' => 'unidade', 'observation' => 'amassado'],
                                ['food_name' => 'Café sem açúcar', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'com óleo de coco'],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Lanche da Manhã',
                            'order' => 2,
                            'foods' => [
                                ['food_name' => 'Castanha-do-pará', 'quantity' => 4, 'unit' => 'unidades', 'observation' => null],
                                ['food_name' => 'Morango', 'quantity' => 6, 'unit' => 'unidades', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Almoço',
                            'order' => 3,
                            'foods' => [
                                ['food_name' => 'Salmão', 'quantity' => 150, 'unit' => 'g', 'observation' => 'grelhado'],
                                ['food_name' => 'Brócolis', 'quantity' => 2, 'unit' => 'xícaras', 'observation' => 'no vapor'],
                                ['food_name' => 'Couve', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'refogada no alho'],
                                ['food_name' => 'Azeite de oliva', 'quantity' => 2, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Nozes', 'quantity' => 3, 'unit' => 'unidades', 'observation' => 'picadas na salada'],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Lanche da Tarde',
                            'order' => 4,
                            'foods' => [
                                ['food_name' => 'Iogurte grego', 'quantity' => 1, 'unit' => 'unidade', 'observation' => null],
                                ['food_name' => 'Chia', 'quantity' => 1, 'unit' => 'colher', 'observation' => 'hidratada'],
                                ['food_name' => 'Amêndoas', 'quantity' => 6, 'unit' => 'unidades', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Jantar',
                            'order' => 5,
                            'foods' => [
                                ['food_name' => 'Peito de frango', 'quantity' => 150, 'unit' => 'g', 'observation' => 'grelhado'],
                                ['food_name' => 'Rúcula', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'salada'],
                                ['food_name' => 'Pepino', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'em rodelas'],
                                ['food_name' => 'Abobrinha', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'grelhada'],
                                ['food_name' => 'Azeite de oliva', 'quantity' => 1, 'unit' => 'colher', 'observation' => null],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Vegetariano',
                'description' => 'Plano sem carnes. 5 refeições com proteínas vegetais (ovos, laticínios, leguminosas) e variedade de vegetais.',
                'goal' => 'vegetariano',
                'template_data' => [
                    'guidelines' => 'Combinar cereais com leguminosas para proteína completa. Incluir fontes de B12 e ferro.',
                    'meals' => [
                        [
                            'meal_type_name' => 'Café da Manhã',
                            'order' => 1,
                            'foods' => [
                                ['food_name' => 'Pão integral', 'quantity' => 2, 'unit' => 'fatias', 'observation' => 'com pasta de amendoim integral'],
                                ['food_name' => 'Banana', 'quantity' => 1, 'unit' => 'unidade', 'observation' => null],
                                ['food_name' => 'Leite integral', 'quantity' => 200, 'unit' => 'ml', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Lanche da Manhã',
                            'order' => 2,
                            'foods' => [
                                ['food_name' => 'Iogurte grego', 'quantity' => 1, 'unit' => 'unidade', 'observation' => null],
                                ['food_name' => 'Granola sem açúcar', 'quantity' => 2, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Mamão', 'quantity' => 1, 'unit' => 'fatia', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Almoço',
                            'order' => 3,
                            'foods' => [
                                ['food_name' => 'Ovo inteiro', 'quantity' => 3, 'unit' => 'unidades', 'observation' => 'cozidos'],
                                ['food_name' => 'Arroz integral', 'quantity' => 4, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Lentilha', 'quantity' => 1, 'unit' => 'concha', 'observation' => null],
                                ['food_name' => 'Brócolis', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'no vapor'],
                                ['food_name' => 'Beterraba', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'ralada'],
                                ['food_name' => 'Azeite de oliva', 'quantity' => 1, 'unit' => 'colher', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Lanche da Tarde',
                            'order' => 4,
                            'foods' => [
                                ['food_name' => 'Tapioca', 'quantity' => 3, 'unit' => 'colheres', 'observation' => 'com queijo cottage'],
                                ['food_name' => 'Água de coco', 'quantity' => 200, 'unit' => 'ml', 'observation' => null],
                            ],
                        ],
                        [
                            'meal_type_name' => 'Jantar',
                            'order' => 5,
                            'foods' => [
                                ['food_name' => 'Grão-de-bico', 'quantity' => 1, 'unit' => 'concha', 'observation' => 'cozido'],
                                ['food_name' => 'Quinoa', 'quantity' => 3, 'unit' => 'colheres', 'observation' => null],
                                ['food_name' => 'Berinjela', 'quantity' => 1, 'unit' => 'xícara', 'observation' => 'grelhada'],
                                ['food_name' => 'Tomate', 'quantity' => 4, 'unit' => 'fatias', 'observation' => null],
                                ['food_name' => 'Azeite de oliva', 'quantity' => 1, 'unit' => 'colher', 'observation' => null],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($templates as $template) {
            MealPlanTemplate::updateOrCreate(
                [
                    'name' => $template['name'],
                    'goal' => $template['goal'],
                ],
                [
                    'description' => $template['description'],
                    'template_data' => $template['template_data'],
                    'is_active' => true,
                ]
            );
        }
    }
}
