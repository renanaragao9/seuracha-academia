<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $marketing = PostType::where('name', 'Marketing')->first();
        $aviso = PostType::where('name', 'Aviso')->first();
        $evento = PostType::where('name', 'Evento')->first();
        $dica = PostType::where('name', 'Dica')->first();

        $posts = [
            [
                'title' => 'Promoção de Verão - 30% OFF',
                'description' => '<p>Aproveite nossa <strong>promoção de verão</strong> com 30% de desconto na primeira mensalidade! Válido para novos alunos até o final do mês.</p>',
                'post_type_id' => $marketing?->id,
                'user_id' => $user?->id,
                'status' => 'published',
                'link_video' => null,
                'link_site' => 'https://academia.com/promocao',
                'start_date' => now()->subDays(5)->format('Y-m-d'),
                'end_date' => now()->addDays(25)->format('Y-m-d'),
            ],
            [
                'title' => 'Aulão de Muay Thai - Sábado Especial',
                'description' => '<p>Neste sábado teremos um <strong>aulão especial de Muay Thai</strong> aberto para todos os alunos. Venha experimentar essa arte marcial tailandesa!</p><p>Horário: 10h às 12h</p><p>Inscrição gratuita na recepção.</p>',
                'post_type_id' => $evento?->id,
                'user_id' => $user?->id,
                'status' => 'published',
                'link_video' => 'https://youtube.com/watch?v=example1',
                'link_site' => null,
                'start_date' => now()->addDays(3)->format('Y-m-d'),
                'end_date' => now()->addDays(4)->format('Y-m-d'),
            ],
            [
                'title' => 'Novos Horários de Funcionamento',
                'description' => '<p>Informamos que a partir do dia 01/07 nossa academia passará a funcionar em <strong>novo horário</strong>:</p><ul><li>Segunda a Sexta: 5h às 23h</li><li>Sábado: 7h às 18h</li><li>Domingo: 8h às 14h</li></ul>',
                'post_type_id' => $aviso?->id,
                'user_id' => $user?->id,
                'status' => 'published',
                'link_video' => null,
                'link_site' => null,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => now()->addDays(15)->format('Y-m-d'),
            ],
            [
                'title' => '5 Dicas para Potencializar seu Treino',
                'description' => '<p>Confira <strong>5 dicas essenciais</strong> para melhorar seu rendimento nos treinos:</p><ol><li>Mantenha-se hidratado durante todo o treino</li><li>Respeite o tempo de descanso entre as séries</li><li>Varie os exercícios a cada 4 semanas</li><li>Priorize a execução correta antes de aumentar a carga</li><li>Não pule o aquecimento e alongamento final</li></ol>',
                'post_type_id' => $dica?->id,
                'user_id' => $user?->id,
                'status' => 'published',
                'link_video' => 'https://youtube.com/watch?v=example2',
                'link_site' => 'https://academia.com/blog/5-dicas',
                'start_date' => now()->format('Y-m-d'),
                'end_date' => null,
            ],
            [
                'title' => 'Próximo Conteúdo - Em Breve',
                'description' => '<p>Estamos preparando um conteúdo especial sobre <strong>nutrição esportiva</strong>. Fique ligado!</p>',
                'post_type_id' => $dica?->id,
                'user_id' => $user?->id,
                'status' => 'draft',
                'link_video' => null,
                'link_site' => null,
                'start_date' => now()->addDays(7)->format('Y-m-d'),
                'end_date' => null,
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['title' => $post['title']],
                $post
            );
        }
    }
}
