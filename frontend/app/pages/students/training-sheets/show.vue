<script setup lang="ts">
import { formatDuration } from "~/utils/formatDuration";
import type { TrainingSheetDivision, WorkoutLog } from "~/interfaces/training-sheet";

definePageMeta({
  middleware: ["auth"],
});

const route = useRoute();
const sheetId = Number(route.query.id);

const trainingSheetStore = useTrainingSheetStore();
const { currentItem: sheet, isLoading, error, isDownloadingPdf: downloadingPdf } = storeToRefs(trainingSheetStore);

const activeDivisionId = ref<number | null>(null);

const activeDivision = computed<TrainingSheetDivision | null>(
  () =>
    sheet.value?.divisions.find((d) => d.id === activeDivisionId.value) ?? null,
);

const filteredLogs = computed<WorkoutLog[]>(() =>
  (sheet.value?.workoutLogs ?? []).filter(
    (log) => log.division?.id === activeDivisionId.value,
  ),
);

onMounted(async () => {
  const item = await trainingSheetStore.loadItem(sheetId);
  if (item) {
    activeDivisionId.value = item.divisions[0]?.id ?? null;
  }
});

const formatDate = (dateStr: string | null): string => {
  return brDate(dateStr);
};

const formatTime = (dateStr: string | null): string => {
  return brTime(dateStr);
};

const logsByDivision = (): { name: string; logs: WorkoutLog[] }[] => {
  if (filteredLogs.value.length === 0) return [];
  const grouped: Record<string, WorkoutLog[]> = {};
  for (const log of filteredLogs.value) {
    const key = log.division?.name ?? "Sem divisão";
    if (!grouped[key]) grouped[key] = [];
    grouped[key].push(log);
  }
  return Object.entries(grouped).map(([name, logs]) => ({ name, logs }));
};

const startWorkout = (): void => {
  if (!sheet.value || !activeDivision.value) return;
  navigateTo(
    `/students/training-sheets/training-running?sheetId=${sheet.value.id}&divisionId=${activeDivision.value.id}`,
  );
};

const downloadPdf = async (): Promise<void> => {
  await trainingSheetStore.downloadPdf(sheetId);
};

const completedExercises = (log: WorkoutLog): number => {
  return log.logExercises.filter((ex) => ex.completed).length;
};

const logProgress = (log: WorkoutLog): number => {
  const total = log.logExercises.length;
  return total === 0 ? 0 : Math.round((completedExercises(log) / total) * 100);
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
          id="wave-show"
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
      <rect width="100%" height="100%" fill="url(#wave-show)" />
    </svg>

    <div class="relative z-10">
      <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8">
        <div class="flex items-center gap-4 flex-1 min-w-0">
          <NuxtLink
            to="/students/training-sheets"
            class="text-zinc-400 hover:text-white transition-colors shrink-0"
          >
            <Icon name="lucide:arrow-left" class="h-6 w-6" />
          </NuxtLink>

          <div class="flex-1 min-w-0">
            <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">
              {{ sheet?.name || "Ficha de Treino" }}
            </h1>

            <p class="text-sm sm:text-base text-zinc-400">
              <template v-if="sheet?.startDate">
                {{ formatDate(sheet.startDate) }}
                <template v-if="sheet.endDate">
                  — {{ formatDate(sheet.endDate) }}
                </template>
              </template>
            </p>
          </div>
        </div>
        <button
          v-if="sheet"
          class="w-full sm:w-auto px-4 py-2 rounded-lg text-sm font-semibold bg-red-600 hover:bg-red-700 text-white transition-colors flex items-center justify-center gap-2"
          @click="downloadPdf"
          :disabled="downloadingPdf"
        >
          <Icon
            :name="downloadingPdf ? 'lucide:loader-2' : 'lucide:file-down'"
            :class="downloadingPdf ? 'animate-spin' : ''"
            class="h-4 w-4"
          />
          Ficha em PDF
        </button>
      </div>

      <div
        v-if="isLoading"
        class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
      >
        <Icon
          name="lucide:loader-2"
          class="h-12 w-12 text-emerald-500 mx-auto mb-4 animate-spin"
        />
        <p class="text-zinc-400">Carregando ficha de treino...</p>
      </div>

      <div
        v-else-if="error"
        class="bg-zinc-800/80 rounded-2xl border border-red-500/20 text-center py-20"
      >
        <Icon
          name="lucide:alert-circle"
          class="h-12 w-12 text-red-500 mx-auto mb-4"
        />
        <h2 class="text-xl font-bold text-white mb-2">Erro ao carregar</h2>
        <p class="text-zinc-400">{{ error }}</p>
      </div>

      <div v-else-if="sheet" class="space-y-6">
        <div
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
        >
          <div class="flex gap-2 overflow-x-auto pb-1">
            <button
              v-for="div in sheet.divisions"
              :key="div.id"
              :class="[
                'flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-all border',
                activeDivisionId === div.id
                  ? 'bg-emerald-500 border-emerald-500 text-white shadow-lg shadow-emerald-500/30'
                  : 'bg-zinc-800 border-zinc-700 text-zinc-300 hover:border-emerald-500/40 hover:text-white',
              ]"
              @click="activeDivisionId = div.id"
            >
              Treino {{ div.division.name }}
            </button>
          </div>

          <button
            v-if="activeDivision"
            class="px-5 py-2.5 rounded-lg text-sm font-semibold bg-gradient-to-r from-emerald-500 to-emerald-700 hover:shadow-lg hover:shadow-emerald-500/30 text-white transition-all flex items-center gap-2 shrink-0"
            @click="startWorkout"
          >
            <Icon name="lucide:play" class="h-4 w-4" />
            Iniciar treino
          </button>
        </div>

        <div
          v-if="activeDivision"
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 overflow-hidden"
        >
          <div
            class="px-4 sm:px-6 py-4 border-b border-zinc-700/50 flex items-center justify-between"
          >
            <div>
              <h3 class="text-base sm:text-lg font-bold text-white">
                Treino {{ activeDivision.division.name }}
              </h3>
              <p class="text-sm text-zinc-400">
                {{ activeDivision.exercises.length }}
                {{
                  activeDivision.exercises.length === 1
                    ? "exercício"
                    : "exercícios"
                }}
              </p>
            </div>
            <div
              class="w-12 h-12 rounded-xl bg-emerald-500/15 flex items-center justify-center"
            >
              <Icon name="lucide:dumbbell" class="h-6 w-6 text-emerald-500" />
            </div>
          </div>

          <div class="divide-y divide-zinc-700/50">
            <div
              v-for="ex in activeDivision.exercises"
              :key="ex.id"
              class="px-4 sm:px-6 py-4 flex flex-col sm:flex-row sm:items-center gap-3 hover:bg-white/[0.02] transition-colors"
            >
              <div
                class="flex-shrink-0 h-8 w-8 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm font-bold flex items-center justify-center"
              >
                {{ ex.order }}
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-white font-semibold truncate">
                  {{ ex.exercise.name }}
                </p>
                <p v-if="ex.observation" class="text-sm text-zinc-400 mt-0.5">
                  {{ ex.observation }}
                </p>
              </div>
              <div class="flex flex-wrap gap-2">
                <span
                  class="inline-flex items-center gap-1 bg-zinc-700/80 text-zinc-200 text-sm font-medium px-3 py-1.5 rounded-md"
                >
                  <Icon
                    name="lucide:repeat-2"
                    class="h-4 w-4 text-emerald-400"
                  />
                  {{ ex.series }}x{{ ex.repetitions }}
                </span>
                <span
                  v-if="ex.restSeconds"
                  class="inline-flex items-center gap-1 bg-zinc-700/80 text-zinc-200 text-sm font-medium px-3 py-1.5 rounded-md"
                >
                  <Icon name="lucide:timer" class="h-4 w-4 text-blue-400" />
                  {{ ex.restSeconds }}s
                </span>
                <span
                  v-if="ex.load"
                  class="inline-flex items-center gap-1 bg-zinc-700/80 text-zinc-200 text-sm font-medium px-3 py-1.5 rounded-md"
                >
                  <Icon name="lucide:weight" class="h-4 w-4 text-green-400" />
                  {{ ex.load }}kg
                </span>
              </div>
            </div>
          </div>
        </div>

        <div
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 overflow-hidden"
        >
          <div
            class="px-4 sm:px-6 py-4 border-b border-zinc-700/50 flex items-center justify-between"
          >
            <div>
              <h3 class="text-base sm:text-lg font-bold text-white">
                Histórico de Treinos
              </h3>
              <p class="text-sm text-zinc-400">
                {{ filteredLogs.length }}
                {{ filteredLogs.length === 1 ? "sessão" : "sessões" }}
              </p>
            </div>
            <div
              class="w-12 h-12 rounded-xl bg-emerald-500/15 flex items-center justify-center"
            >
              <Icon name="lucide:history" class="h-6 w-6 text-emerald-500" />
            </div>
          </div>

          <div
            v-if="filteredLogs.length === 0"
            class="px-4 sm:px-6 py-8 text-center text-zinc-400"
          >
            Nenhum treino registrado para esta divisão.
          </div>

          <div v-else class="divide-y divide-zinc-700/50">
            <div
              v-for="group in logsByDivision()"
              :key="group.name"
              class="divide-y divide-zinc-700/30"
            >
              <div class="px-4 sm:px-6 py-3 bg-zinc-800/40">
                <p
                  class="text-sm font-semibold text-zinc-500 uppercase tracking-wider"
                >
                  Treino {{ group.name }}
                </p>
              </div>
              <div
                v-for="log in group.logs"
                :key="log.id"
                class="px-4 sm:px-6 py-5 hover:bg-white/[0.02] transition-colors"
              >
                <div
                  class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3"
                >
                  <div>
                    <p class="text-white font-semibold text-base">
                      {{ formatDate(log.startedAt) }}
                    </p>
                    <p class="text-sm text-zinc-400 mt-1">
                      <template v-if="log.finishedAt">
                        {{ formatTime(log.startedAt) }} &mdash;
                        {{ formatTime(log.finishedAt) }}
                      </template>
                      <template v-else>
                        {{ formatTime(log.startedAt) }}
                      </template>
                      <span v-if="log.durationMinutes">
                        &mdash; {{ formatDuration(log.durationMinutes) }}
                      </span>
                    </p>
                  </div>
                  <div class="flex items-center gap-3 self-end sm:self-auto">
                    <span
                      :class="[
                        'inline-flex items-center justify-center px-4 py-1.5 rounded-full text-sm font-semibold border',
                        log.finishedAt
                          ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
                          : log.startedAt
                            ? 'bg-amber-500/10 text-amber-400 border-amber-500/20'
                            : 'bg-zinc-700/40 text-zinc-300 border-zinc-600',
                      ]"
                    >
                      {{
                        log.finishedAt
                          ? "Finalizado"
                          : log.startedAt
                            ? "Em andamento"
                            : "Não iniciado"
                      }}
                    </span>
                  </div>
                </div>

                <div
                  class="mt-4 h-2 bg-zinc-700/70 rounded-full overflow-hidden"
                >
                  <div
                    class="h-full bg-emerald-500 rounded-full transition-all"
                    :style="{ width: `${logProgress(log)}%` }"
                  />
                </div>
                <p class="mt-1.5 text-sm text-zinc-500">
                  Progresso: {{ logProgress(log) }}%
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
