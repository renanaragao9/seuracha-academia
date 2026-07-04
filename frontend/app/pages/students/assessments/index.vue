<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const assessmentStore = useAssessmentStore();

onMounted(async () => {
  await assessmentStore.loadItems();
});

const formatDate = (dateStr: string | null): string => {
  return brDateShort(dateStr);
};

const openAssessment = (id: number): void => {
  navigateTo(`/students/assessments/show?id=${id}`);
};
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 relative">
    <svg
      class="absolute inset-0 w-full h-full opacity-[0.04] pointer-events-none"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <pattern
          id="wave-assessment"
          x="0"
          y="0"
          width="40"
          height="20"
          patternUnits="userSpaceOnUse"
        >
          <path
            d="M0 15 Q10 5 20 15 Q30 25 40 15"
            stroke="#10b981"
            fill="none"
            stroke-width="1"
          />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#wave-assessment)" />
    </svg>

    <div class="flex items-center gap-4 mb-8 relative z-10">
      <NuxtLink
        to="/students"
        class="text-zinc-400 hover:text-white transition-colors"
      >
        <Icon name="lucide:arrow-left" class="h-6 w-6" />
      </NuxtLink>
      <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-white">Avaliações</h1>
        <p class="text-sm sm:text-base text-zinc-400">
          Acompanhe seu progresso e evolução
        </p>
      </div>
    </div>

    <div
      v-if="assessmentStore.isLoading"
      class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
    >
      <Icon
        name="lucide:loader-2"
        class="h-12 w-12 text-emerald-500 mx-auto mb-4 animate-spin"
      />
      <p class="text-zinc-400">Carregando avaliações...</p>
    </div>

    <div
      v-else-if="assessmentStore.error"
      class="bg-zinc-800/80 rounded-2xl border border-red-500/20 text-center py-20"
    >
      <Icon
        name="lucide:alert-circle"
        class="h-12 w-12 text-red-500 mx-auto mb-4"
      />
      <h2 class="text-xl font-bold text-white mb-2">Erro ao carregar</h2>
      <p class="text-zinc-400">{{ assessmentStore.error }}</p>
    </div>

    <div
      v-else-if="assessmentStore.items.length === 0"
      class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
    >
      <Icon
        name="lucide:activity"
        class="h-16 w-16 text-emerald-500 mx-auto mb-4"
      />
      <h2 class="text-xl font-bold text-white mb-2">
        Nenhuma avaliação encontrada
      </h2>
      <p class="text-zinc-400">Você ainda não possui avaliações registradas.</p>
    </div>

    <div
      v-else
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"
    >
      <button
        v-for="assessment in assessmentStore.items"
        :key="assessment.id"
        class="w-full text-left p-5 flex flex-col bg-zinc-800/80 border border-emerald-500/10 hover:border-emerald-500/30 rounded-2xl hover:shadow-xl md:hover:scale-[1.02] transition-all cursor-pointer"
        @click="openAssessment(assessment.id)"
      >
        <div class="flex items-center gap-3 mb-4">
          <div
            class="h-12 w-12 rounded-xl bg-emerald-500/15 flex items-center justify-center shrink-0"
          >
            <Icon name="lucide:activity" class="h-6 w-6 text-emerald-500" />
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-white font-bold truncate">
              {{ assessment.name || "Avaliação" }}
            </p>
            <p class="text-sm text-zinc-400 mt-0.5">
              <template v-if="assessment.startDate">
                De {{ formatDate(assessment.startDate) }}
                <template v-if="assessment.endDate">
                  <br />Até {{ formatDate(assessment.endDate) }}
                </template>
              </template>
              <span v-else>Sem data definida</span>
            </p>
          </div>
          <Icon
            name="lucide:chevron-right"
            class="h-5 w-5 text-zinc-500 shrink-0 sm:hidden"
          />
        </div>

        <div class="flex items-center justify-between text-sm">
          <span class="text-zinc-400">
            {{ assessment.itemsCount }}
            {{ assessment.itemsCount === 1 ? "medição" : "medições" }}
          </span>
        </div>
      </button>
    </div>
  </div>
</template>
