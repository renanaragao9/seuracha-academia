<?php

namespace Database\Seeders;

use App\Models\FieldType;
use Illuminate\Database\Seeder;

class FieldTypeSeeder extends Seeder
{
    public function run(): void
    {
        $fieldTypes = [
            [
                'name' => 'Cor',
                'is_active' => true,
            ],
            [
                'name' => 'Tamanho',
                'is_active' => true,
            ],
            [
                'name' => 'Material',
                'is_active' => true,
            ],
            [
                'name' => 'Marca',
                'is_active' => true,
            ],
            [
                'name' => 'Peso',
                'is_active' => true,
            ],
            [
                'name' => 'Dimensões',
                'is_active' => true,
            ],
            [
                'name' => 'Código SKU',
                'is_active' => true,
            ],
            [
                'name' => 'Garantia',
                'is_active' => true,
            ],
            [
                'name' => 'País de Origem',
                'is_active' => true,
            ],
            [
                'name' => 'Especificações',
                'is_active' => true,
            ],
        ];

        foreach ($fieldTypes as $fieldType) {
            FieldType::updateOrCreate(
                ['name' => $fieldType['name']],
                $fieldType
            );
        }
    }
}
