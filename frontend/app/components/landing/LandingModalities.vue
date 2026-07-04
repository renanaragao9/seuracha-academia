<script setup lang="ts">
const modalities = [
  {
    icon: "lucide:dumbbell",
    title: "Musculação",
    description:
      "Equipamentos de última geração para hipertrofia, força e definição muscular. Acompanhamento personalizado com fichas de treino.",
    badge: "Mais popular",
    color: "emerald",
  },
  {
    icon: "lucide:heart-pulse",
    title: "Cardio & HIIT",
    description:
      "Esteiras, bicicletas e elípticos de alto desempenho. Aulas de HIIT para queimar gordura de forma eficiente.",
    badge: null,
    color: "red",
  },
  {
    icon: "lucide:person-standing",
    title: "Yoga & Pilates",
    description:
      "Melhore flexibilidade, postura e equilíbrio mental. Aulas conduzidas por instrutores certificados internacionalmente.",
    badge: null,
    color: "amber",
  },
  {
    icon: "lucide:swords",
    title: "Artes Marciais",
    description:
      "Muay Thai, Jiu-Jitsu e boxe para todos os níveis. Desenvolva disciplina, autodefesa e condicionamento físico.",
    badge: "Novo",
    color: "emerald",
  },
  {
    icon: "lucide:waves",
    title: "Natação",
    description:
      "Piscina semiolímpica aquecida com raia livre e aulas para todas as idades e níveis de habilidade.",
    badge: null,
    color: "red",
  },
  {
    icon: "lucide:music",
    title: "Aulas em Grupo",
    description:
      "Zumba, spinning, step e muito mais. Aulas energizantes que tornam o treino uma experiência incrível.",
    badge: null,
    color: "amber",
  },
];

const iconBgMap: Record<string, string> = {
  emerald: "bg-emerald-500/15",
  red: "bg-red-500/15",
  amber: "bg-amber-500/15",
};

const iconColorMap: Record<string, string> = {
  emerald: "text-emerald-500",
  red: "text-red-500",
  amber: "text-amber-500",
};

const bgColorMap: Record<string, string> = {
  emerald:
    "bg-emerald-500/10 border-emerald-500/20 group-hover:border-emerald-500/40",
  red: "bg-red-500/10 border-red-500/20 group-hover:border-red-500/40",
  amber: "bg-amber-500/10 border-amber-500/20 group-hover:border-amber-500/40",
};


</script>

<template>
  <section id="modalidades" class="relative py-24 overflow-hidden">
    <div
      class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(16,185,129,0.05),_transparent_70%)]"
    />

    <div class="relative z-10 max-w-7xl mx-auto px-6">
      <div class="text-center mb-16">
        <div
          class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium mb-6"
        >
          <Icon name="lucide:layers" class="w-4 h-4" />
          Modalidades
        </div>
        <h2 class="text-4xl lg:text-5xl font-black text-white mb-4">
          Encontre a atividade
          <span
            class="bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent"
            >perfeita para você</span
          >
        </h2>
        <p class="text-zinc-400 text-xl max-w-2xl mx-auto">
          Oferecemos diversas modalidades para que você encontre a que mais se
          identifica e alcance seus objetivos.
        </p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="modality in modalities"
          :key="modality.title"
          class="group relative rounded-2xl border bg-zinc-900/60 backdrop-blur-sm p-6 hover:bg-zinc-800/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-black/40 cursor-default"
          :class="bgColorMap[modality.color]"
        >
          <div v-if="modality.badge" class="absolute top-4 right-4">
            <span
              class="px-3 py-1 rounded-full text-xs font-bold"
              :class="
                modality.badge === 'Novo'
                  ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30'
                  : 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30'
              "
            >
              {{ modality.badge }}
            </span>
          </div>

          <div
            class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4"
            :class="iconBgMap[modality.color]"
          >
            <Icon :name="modality.icon" class="w-7 h-7" :class="iconColorMap[modality.color]" />
          </div>

          <h3 class="text-xl font-bold text-white mb-2">
            {{ modality.title }}
          </h3>
          <p class="text-zinc-400 text-sm leading-relaxed">
            {{ modality.description }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>
