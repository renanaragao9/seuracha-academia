<?php

namespace App\Prompts;

class ProfileAnalysisPrompt
{
    public static function system(): string
    {
        return <<<'PROMPT'
            Você é um personal trainer experiente avaliando o perfil de um aluno. Analise os dados abaixo
            e forneça uma avaliação completa, motivadora e profissional.

            Estruture sua resposta com as seguintes seções (use markdown para formatação):

            ## Resumo do Perfil
            Resuma em 2-3 frases o estado atual do aluno (nome, idade, objetivo aparente).

            ## Frequência e Comprometimento
            Analise quantos treinos o aluno fez, frequência semanal, consistência. Elogie os pontos fortes
            e sugira melhorias se a frequência estiver baixa.

            ## Treino Atual
            Comente sobre o plano de treino ativo (divisão, volume, adequação ao objetivo).

            ## Evolução Física
            Compare as avaliações físicas (peso, medidas, IMC) ao longo do tempo. Destaque progressos e
            pontos de atenção.

            ## Recomendações
            Sugira 2-3 ações práticas para o aluno melhorar (ex: aumentar frequência, ajustar carga,
            combinar com nutricionista, etc).

            ## Nota Geral
            Dê uma nota de 1 a 10 baseada em: consistência, evolução e aderência ao plano.

            Seja encorajador e positivo, mas honesto. Use emojis com moderação. A resposta deve ser em
            português do Brasil.
        PROMPT;
    }

    public static function userContext(array $data): string
    {
        $student = $data['student'];
        $sheets = $data['training_sheets'];
        $workouts = $data['recent_workouts'];
        $assessments = $data['assessments'];

        $context = "DADOS DO ALUNO\n\n";

        $context .= "Nome: {$student['name']}\n";
        $context .= "Data de Nascimento: {$student['birth_date']}\n";
        $context .= "Gênero: {$student['gender']}\n";
        $context .= "Peso atual: {$student['weight']} kg\n";
        $context .= "Altura: {$student['height']} cm\n";
        $context .= "Status: {$student['status']}\n";
        $context .= "Membro desde: {$student['entry_date']}\n\n";

        $context .= "FICHAS DE TREINO ({$sheets['total']} total, {$sheets['active']} ativas)\n";
        foreach ($sheets['items'] as $sheet) {
            $context .= "- {$sheet['name']} ({$sheet['status']}) — {$sheet['divisions']} divisões, {$sheet['exercises']} exercícios\n";
        }
        $context .= "\n";

        $context .= "HISTÓRICO DE TREINOS ({$workouts['total']} total, últimos {$workouts['days']} dias)\n";
        $context .= "Frequência semanal média: {$workouts['avg_per_week']} treinos/semana\n";
        $context .= "Duração média: {$workouts['avg_duration']} minutos\n";
        if (empty($workouts['items'])) {
            $context .= "Nenhum treino registrado no período.\n";
        } else {
            foreach ($workouts['items'] as $log) {
                $context .= "- {$log['date']} — {$log['division']} — {$log['duration']} min — {$log['exercises_count']} exercícios realizados\n";
            }
        }
        $context .= "\n";

        $context .= "HISTÓRICO DE AVALIAÇÕES FÍSICAS ({$assessments['total']} avaliações)\n";
        if (empty($assessments['items'])) {
            $context .= "Nenhuma avaliação física registrada.\n";
        } else {
            foreach ($assessments['items'] as $assessment) {
                $context .= "## {$assessment['name']} ({$assessment['date']})\n";
                foreach ($assessment['measurements'] as $measurement) {
                    $context .= "- {$measurement['type']}: {$measurement['value']} {$measurement['unit']}\n";
                }
                $context .= "\n";
            }
        }

        return $context;
    }
}
