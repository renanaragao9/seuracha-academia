<script setup lang="ts">
import type { StatusLabel } from "~/interfaces/training-sheet";

definePageMeta({
  middleware: ["auth"],
});

const trainingSheetStore = useTrainingSheetStore();
const { items: sheets, isLoading, error } = storeToRefs(trainingSheetStore);

const formatDate = (dateStr: string | null): string => {
  return brDateShort(dateStr);
};

const daysRemaining = (endDate: string | null): number | null => {
  if (!endDate) return null;
  const parts = endDate.split("-").map(Number);
  const [year, month, day] = [parts[0] ?? 0, parts[1] ?? 0, parts[2] ?? 0];
  const end = new Date(year, month - 1, day);
  const diff = Math.ceil((end.getTime() - Date.now()) / (1000 * 60 * 60 * 24));
  return diff;
};

const statusLabel = (endDate: string | null): StatusLabel | null => {
  if (!endDate) return null;
  const days = daysRemaining(endDate);
  if (days === null) return null;
  if (days < 0) return { text: "Vencida", class: "text-red-400" };
  if (days <= 7)
    return { text: `Prazo final · ${days}d`, class: "text-amber-400" };
  return { text: "Em dia", class: "text-emerald-400" };
};

const openSheet = (id: number): void => {
  navigateTo(`/students/training-sheets/show?id=${id}`);
};

onMounted(async () => {
  await trainingSheetStore.loadItems();
});
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
          id="wave-training"
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
      <rect width="100%" height="100%" fill="url(#wave-training)" />
    </svg>

    <div class="flex items-center gap-4 mb-8 relative z-10">
      <NuxtLink
        to="/students"
        class="text-zinc-400 hover:text-white transition-colors"
      >
        <Icon name="lucide:arrow-left" class="h-6 w-6" />
      </NuxtLink>

      <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-white">
          Fichas de Treino
        </h1>

        <p class="text-sm sm:text-base text-zinc-400">
          Visualize e acompanhe seus treinos
        </p>
      </div>
    </div>

    <div
      v-if="isLoading"
      class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
    >
      <Icon
        name="lucide:loader-2"
        class="h-12 w-12 text-emerald-500 mx-auto mb-4 animate-spin"
      />
      <p class="text-zinc-400">Carregando fichas de treino...</p>
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

    <div
      v-else-if="sheets.length === 0"
      class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
    >
      <Icon
        name="lucide:dumbbell"
        class="h-16 w-16 text-emerald-500 mx-auto mb-4"
      />

      <h2 class="text-xl font-bold text-white mb-2">Nenhuma ficha ativa</h2>

      <p class="text-zinc-400">
        Você ainda não possui fichas de treino ativas.
      </p>
    </div>

    <div
      v-else
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"
    >
      <button
        v-for="sheet in sheets"
        :key="sheet.id"
        class="w-full text-left p-5 flex flex-col bg-zinc-800/80 border border-emerald-500/10 hover:border-emerald-500/30 rounded-2xl hover:shadow-xl md:hover:scale-[1.02] transition-all cursor-pointer"
        @click="openSheet(sheet.id)"
      >
        <div class="flex items-center gap-3 mb-4">
          <div
            class="h-12 w-12 rounded-xl bg-emerald-500/15 flex items-center justify-center shrink-0"
          >
            <Icon name="lucide:dumbbell" class="h-6 w-6 text-emerald-500" />
          </div>

          <div class="min-w-0 flex-1">
            <p class="text-white font-bold truncate">{{ sheet.name }}</p>

            <p class="text-sm text-zinc-400 mt-0.5">
              <template v-if="sheet.startDate">
                {{ formatDate(sheet.startDate) }}
                <template v-if="sheet.endDate">
                  — {{ formatDate(sheet.endDate) }}
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
            {{ sheet.divisionsCount ?? 0 }}
            {{ (sheet.divisionsCount ?? 0) === 1 ? "divisão" : "divisões" }}
          </span>

          <span
            v-if="sheet.endDate && daysRemaining(sheet.endDate) !== null"
            class="text-zinc-400"
          >
            {{ daysRemaining(sheet.endDate) ?? 0 }} dia{{
              (daysRemaining(sheet.endDate) ?? 0) !== 1 ? "s" : ""
            }}
            restante{{ (daysRemaining(sheet.endDate) ?? 0) !== 1 ? "s" : "" }}
          </span>

          <span
            v-if="statusLabel(sheet.endDate)"
            class="font-semibold"
            :class="statusLabel(sheet.endDate)!.class"
          >
            {{ statusLabel(sheet.endDate)!.text }}
          </span>
        </div>
      </button>
    </div>
  </div>
</template>
