<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const route = useRoute();
const assessmentId = Number(route.query.id);

const assessmentStore = useAssessmentStore();

onMounted(async () => {
  await assessmentStore.loadItem(assessmentId);
});

const formatDate = (dateStr: string | null): string => {
  return brDate(dateStr);
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
          id="wave-assessment-show"
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
      <rect width="100%" height="100%" fill="url(#wave-assessment-show)" />
    </svg>

    <div class="relative z-10">
      <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8">
        <div class="flex items-center gap-4 flex-1 min-w-0">
          <NuxtLink
            to="/students/assessments"
            class="text-zinc-400 hover:text-white transition-colors shrink-0"
          >
            <Icon name="lucide:arrow-left" class="h-6 w-6" />
          </NuxtLink>
          <div class="flex-1 min-w-0">
            <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">
              {{ assessmentStore.currentItem?.name || "Avaliação" }}
            </h1>
            <p class="text-sm sm:text-base text-zinc-400">
              <template v-if="assessmentStore.currentItem?.startDate">
                De {{ formatDate(assessmentStore.currentItem.startDate) }}
                <template v-if="assessmentStore.currentItem.endDate">
                  <br />Até {{ formatDate(assessmentStore.currentItem.endDate) }}
                </template>
              </template>
              <template v-else>
                {{ assessmentStore.currentItem?.items?.length ?? 0 }}
                {{ assessmentStore.currentItem?.items?.length === 1 ? "medição" : "medições" }}
              </template>
            </p>
          </div>
        </div>
        <button
          v-if="assessmentStore.currentItem"
          class="w-full sm:w-auto px-4 py-2 rounded-lg text-sm font-semibold bg-red-600 hover:bg-red-700 text-white transition-colors flex items-center justify-center gap-2"
          @click="assessmentStore.downloadPdf(assessmentId)"
          :disabled="assessmentStore.isDownloadingPdf"
        >
          <Icon
            :name="assessmentStore.isDownloadingPdf ? 'lucide:loader-2' : 'lucide:file-down'"
            :class="assessmentStore.isDownloadingPdf ? 'animate-spin' : ''"
            class="h-4 w-4"
          />
          Avaliação em PDF
        </button>
      </div>

      <div
        v-if="assessmentStore.isLoading"
        class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
      >
        <Icon
          name="lucide:loader-2"
          class="h-12 w-12 text-emerald-500 mx-auto mb-4 animate-spin"
        />
        <p class="text-zinc-400">Carregando avaliação...</p>
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

      <div v-else-if="assessmentStore.currentItem" class="space-y-6">
        <div
          v-if="assessmentStore.currentItem.observations"
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-4 sm:p-6"
        >
          <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">
            Observações
          </p>
          <p class="text-sm text-zinc-300 italic">
            {{ assessmentStore.currentItem.observations }}
          </p>
        </div>

        <div
          v-if="(assessmentStore.currentItem?.items?.length ?? 0) > 0"
          class="grid grid-cols-1 sm:grid-cols-2 gap-4"
        >
          <div
            v-for="item in assessmentStore.currentItem.items"
            :key="item.id"
            class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-4 sm:p-5"
          >
            <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">
              {{ item.measurementType.name }}
            </p>
            <p class="text-2xl font-bold text-white">
              {{ item.value }}
              <span v-if="item.unit" class="text-sm text-zinc-400 font-normal">
                {{ item.unit }}
              </span>
            </p>
            <p
              v-if="item.notes"
              class="text-xs text-zinc-500 italic mt-3 border-t border-zinc-700/40 pt-3"
            >
              {{ item.notes }}
            </p>
          </div>
        </div>

        <div
          v-if="(assessmentStore.currentItem?.items?.length ?? 0) === 0"
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 text-center py-12"
        >
          <Icon
            name="lucide:activity"
            class="h-12 w-12 text-zinc-600 mx-auto mb-3"
          />
          <p class="text-zinc-400">
            Nenhuma medida registrada nesta avaliação.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
