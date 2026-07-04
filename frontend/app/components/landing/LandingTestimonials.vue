<script setup lang="ts">
const testimonials = [
  {
    name: "Rafael Mendes",
    role: "Aluno há 2 anos",
    avatar: "RM",
    avatarColor: "from-emerald-500 to-emerald-700",
    rating: 5,
    text: "Perdi 18kg em 8 meses com o acompanhamento dos professores da IronFit. A estrutura é incrível e o ambiente é muito motivador. Recomendo de olhos fechados!",
  },
  {
    name: "Camila Rodrigues",
    role: "Aluna há 1 ano",
    avatar: "CR",
    avatarColor: "from-rose-500 to-pink-600",
    rating: 5,
    text: "As aulas de yoga mudaram minha vida. Professora excelente, ambiente calmo e acolhedor. O app da academia também é muito prático para acompanhar o progresso.",
  },
  {
    name: "Lucas Andrade",
    role: "Aluno há 3 anos",
    avatar: "LA",
    avatarColor: "from-emerald-400 to-emerald-600",
    rating: 5,
    text: "Comecei no plano básico e evoluí para o Elite. O personal trainer é top, os equipamentos são novos e o espaço é sempre limpo. Vale cada centavo!",
  },
  {
    name: "Fernanda Costa",
    role: "Aluna há 6 meses",
    avatar: "FC",
    avatarColor: "from-emerald-500 to-teal-600",
    rating: 5,
    text: "Estacionamento gratuito e vestiários impecáveis fazem toda a diferença. Nunca vi uma academia tão bem organizada. Os instrutores são super atenciosos.",
  },
  {
    name: "Bruno Oliveira",
    role: "Aluno há 1.5 anos",
    avatar: "BO",
    avatarColor: "from-blue-500 to-indigo-600",
    rating: 5,
    text: "O Jiu-Jitsu aqui é de outro nível! Professor campeão brasileiro, turmas organizadas e treinos intensos. Melhor investimento que já fiz na minha saúde.",
  },
  {
    name: "Mariana Silva",
    role: "Aluna há 8 meses",
    avatar: "MS",
    avatarColor: "from-violet-500 to-purple-600",
    rating: 5,
    text: "As aulas de Zumba são incríveis! É impossível não se animar. A academia tem uma energia muito positiva e os professores são extremamente dedicados.",
  },
];
</script>

<template>
  <section id="depoimentos" class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gray-950" />
    <div
      class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,_rgba(16,185,129,0.07),_transparent_60%)]"
    />

    <div class="relative z-10 max-w-7xl mx-auto px-6">
      <div class="text-center mb-16">
        <div
          class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium mb-6"
        >
          <Icon name="lucide:star" class="w-4 h-4" />
          Depoimentos
        </div>
        <h2 class="text-4xl lg:text-5xl font-black text-white mb-4">
          Quem já transformou
          <span
            class="bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent"
          >
            sua vida</span
          >
        </h2>
        <p class="text-zinc-400 text-xl max-w-2xl mx-auto">
          Mais de 2.500 alunos já escolheram a IronFit para alcançar seus
          objetivos. Veja o que eles falam.
        </p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="testimonial in testimonials"
          :key="testimonial.name"
          class="group rounded-2xl border border-white/5 bg-zinc-900/60 backdrop-blur-sm p-6 hover:border-emerald-500/20 hover:bg-zinc-800/60 transition-all duration-300 hover:-translate-y-1"
        >
          <div class="flex items-center gap-1 mb-4">
            <Icon
              v-for="i in 5"
              :key="i"
              name="lucide:star"
              class="w-4 h-4 text-amber-400 fill-amber-400"
            />
          </div>

          <p class="text-zinc-300 text-sm leading-relaxed mb-6">
            "{{ testimonial.text }}"
          </p>

          <div class="flex items-center gap-3">
            <div
              class="w-10 h-10 rounded-full bg-gradient-to-br flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
              :class="testimonial.avatarColor"
            >
              {{ testimonial.avatar }}
            </div>
            <div>
              <div class="text-sm font-bold text-white">
                {{ testimonial.name }}
              </div>
              <div class="text-xs text-zinc-500">{{ testimonial.role }}</div>
            </div>
          </div>
        </div>
      </div>

      <div
        class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-8 text-center"
      >
        <div>
          <div class="text-5xl font-black text-white">4.9</div>
          <div class="flex justify-center gap-0.5 my-1">
            <Icon
              v-for="i in 5"
              :key="i"
              name="lucide:star"
              class="w-4 h-4 text-amber-400 fill-amber-400"
            />
          </div>
          <div class="text-sm text-zinc-500">Google Reviews</div>
        </div>
        <div class="w-px h-16 bg-zinc-800 hidden sm:block" />
        <div>
          <div class="text-5xl font-black text-white">2.5K+</div>
          <div class="text-sm text-zinc-500 mt-1">Alunos satisfeitos</div>
        </div>
        <div class="w-px h-16 bg-zinc-800 hidden sm:block" />
        <div>
          <div class="text-5xl font-black text-white">98%</div>
          <div class="text-sm text-zinc-500 mt-1">Taxa de retenção</div>
        </div>
      </div>
    </div>
  </section>
</template>
