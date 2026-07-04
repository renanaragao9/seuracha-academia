<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Dinheiro',          'description' => 'Pagamento em espécie'],
            ['name' => 'Cartão de Crédito', 'description' => 'Pagamento via cartão de crédito'],
            ['name' => 'Cartão de Débito',  'description' => 'Pagamento via cartão de débito'],
            ['name' => 'PIX',               'description' => 'Pagamento instantâneo via PIX'],
            ['name' => 'Boleto Bancário',   'description' => 'Pagamento via boleto bancário'],
            ['name' => 'Transferência Bancária', 'description' => 'TED ou DOC entre contas'],
            ['name' => 'Cheque',            'description' => 'Pagamento via cheque'],
            ['name' => 'Convênio',          'description' => 'Pagamento via convênio empresarial'],
        ];

        foreach ($types as $type) {
            PaymentType::updateOrCreate(
                ['name' => $type['name']],
                array_merge($type, ['is_active' => true])
            );
        }
    }
}
