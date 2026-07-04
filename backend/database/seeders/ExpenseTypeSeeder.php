<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Aluguel',           'description' => 'Aluguel do espaço físico da academia'],
            ['name' => 'Energia Elétrica',  'description' => 'Conta de energia elétrica'],
            ['name' => 'Água e Esgoto',     'description' => 'Conta de água e saneamento'],
            ['name' => 'Internet',          'description' => 'Serviço de internet e telefonia'],
            ['name' => 'Folha de Pagamento', 'description' => 'Salários, encargos e benefícios dos funcionários'],
            ['name' => 'Manutenção',        'description' => 'Manutenção e reparo de equipamentos e instalações'],
            ['name' => 'Marketing',         'description' => 'Publicidade, redes sociais e materiais promocionais'],
            ['name' => 'Equipamentos',      'description' => 'Compra ou locação de equipamentos de musculação'],
            ['name' => 'Material de Limpeza', 'description' => 'Produtos de higiene e limpeza'],
            ['name' => 'Contabilidade',     'description' => 'Honorários de contador e serviços contábeis'],
            ['name' => 'Impostos e Taxas',  'description' => 'Tributos municipais, estaduais e federais'],
            ['name' => 'Software / Sistema', 'description' => 'Licenças de software e assinaturas de sistemas'],
            ['name' => 'Seguros',           'description' => 'Seguros do imóvel, equipamentos e responsabilidade civil'],
        ];

        foreach ($types as $type) {
            ExpenseType::updateOrCreate(
                ['name' => $type['name']],
                array_merge($type, ['is_active' => true])
            );
        }
    }
}
