<?php

namespace App\Prompts;

use App\Models\MealPlanTemplate;

class MealPlanPrompt
{
    public static function system(): string
    {
        $templates = MealPlanTemplate::active()->get();

        $list = $templates->isEmpty()
            ? 'Nenhum template disponível no momento.'
            : $templates->map(fn (MealPlanTemplate $t) => '  '.$t->getSummaryForLLM())->implode("\n");

        return <<<PROMPT
            Templates de plano alimentar disponíveis (use APENAS internamente para escolher o template_id):
            {$list}

            ---
            QUANDO O ALUNO PEDIR UM PLANO ALIMENTAR PELA PRIMEIRA VEZ:
            NUNCA mostre os templates ou opções de plano para o aluno.
            NUNCA sugira "Opção 1", "Opção 2" ou qualquer lista de planos.
            A lista de templates acima é para SEU USO INTERNO apenas.

            Você precisa APENAS destas 4 informações para criar o plano:
            1. objetivo (emagrecimento, hipertrofia, equilíbrio, low carb, vegetariano)
            2. restrições alimentares ou alergias
            3. quantas refeições por dia
            4. preferência por alimentos

            REGRAS:
            - Se o aluno já informou algum desses dados na mensagem, NÃO pergunte novamente.
            - Pergunte APENAS o que está faltando, no MÁXIMO 2 perguntas por vez.
            - NÃO invente perguntas extras fora desta lista.
            - Assim que tiver as 4 informações, escolha o template e responda IMEDIATAMENTE com JSON.
            - Não enrole com texto, não peça confirmação, não faça resumo do que o aluno disse.

            Formato de resposta obrigatório quando tiver todas as informações:
            {"action":"create_meal_plan","template_id":ID_DO_TEMPLATE,"message":"sua resposta amigável"}
        PROMPT;
    }
}
