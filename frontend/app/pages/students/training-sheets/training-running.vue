<script setup lang="ts">
import { useWorkoutLogsStore } from "~/stores/workoutLogs";
import type { TrainingSheetDivision } from "~/interfaces/training-sheet";

definePageMeta({
  middleware: ["auth"],
});

const toast = useToast();
const route = useRoute();
const sheetId = Number(route.query.sheetId);
const divisionId = Number(route.query.divisionId);

const trainingSheetStore = useTrainingSheetStore();
const workoutStore = useWorkoutLogsStore();
const { currentItem: sheet, error } = storeToRefs(trainingSheetStore);

const isLoading = ref<boolean>(true);
const isFinishing = ref<boolean>(false);
const showFinishConfirm = ref<boolean>(false);
const timerStarted = ref<boolean>(false);
const elapsedSeconds = ref<number>(0);
const selectedImage = ref<string | null>(null);
const division = ref<TrainingSheetDivision | null>(null);

const carouselSlides = ref<Record<number, number>>({});
const swipeDrag = ref<{
  exId: number;
  startX: number;
  currentX: number;
} | null>(null);
const justSwiped = ref(false);

function getSlidesTotal(ex: { exercise: { gifUrl?: string | null } }): number {
  let total = 1;
  if (ex.exercise.gifUrl) total++;
  return total;
}

function onSwipeStart(clientX: number, exId: number): void {
  swipeDrag.value = { exId, startX: clientX, currentX: clientX };
}

function onSwipeMove(clientX: number): void {
  if (!swipeDrag.value) return;
  swipeDrag.value.currentX = clientX;
}

function onSwipeEnd(totalSlides: number): void {
  if (!swipeDrag.value) return;
  const { exId, startX, currentX } = swipeDrag.value;
  const diff = startX - currentX;
  const current = carouselSlides.value[exId] ?? 0;

  swipeDrag.value = null;

  if (Math.abs(diff) < 50) return;
  justSwiped.value = true;
  setTimeout(() => {
    justSwiped.value = false;
  }, 300);

  if (diff > 0 && current < totalSlides - 1) {
    carouselSlides.value[exId] = current + 1;
  } else if (diff < 0 && current > 0) {
    carouselSlides.value[exId] = current - 1;
  }
}

function onSwipeCancel(): void {
  swipeDrag.value = null;
}

let timerInterval: ReturnType<typeof setInterval> | null = null;

const startTimer = (): void => {
  timerStarted.value = true;
  timerInterval = setInterval(() => {
    elapsedSeconds.value++;
  }, 1000);
};

const stopTimer = (): void => {
  if (timerInterval) {
    clearInterval(timerInterval);
    timerInterval = null;
  }
};

const formatElapsed = (seconds: number): string => {
  const m = Math.floor(seconds / 60);
  const s = seconds % 60;
  return `${String(m).padStart(2, "0")}:${String(s).padStart(2, "0")}`;
};

const handleStartTimer = (): void => {
  workoutStore.startWorkoutTimer();
  elapsedSeconds.value = 0;
  startTimer();
};

function handleImageClick(ex: {
  id: number;
  exercise: { imageUrl?: string | null };
}): void {
  if (justSwiped.value) return;
  const slide = carouselSlides.value[ex.id] ?? 0;
  if (slide === 0 && ex.exercise.imageUrl) {
    openImage(ex.exercise.imageUrl);
  }
}

const openImage = (imageUrl: string): void => {
  selectedImage.value = imageUrl;
};

const toggleExercise = (index: number): void => {
  if (workoutStore.exercises[index]) {
    workoutStore.exercises[index].completed =
      !workoutStore.exercises[index].completed;
  }
};

const exerciseValue = (
  index: number,
  field: string,
): number | string | null => {
  const ex = workoutStore.exercises[index];
  if (!ex) return null;
  return (
    (ex as unknown as Record<string, number | string | null>)[field] ?? null
  );
};

const updateExercise = (
  index: number,
  field: string,
  value: number | string | null,
): void => {
  const ex = workoutStore.exercises[index];
  if (ex) {
    (ex as unknown as Record<string, number | string | null>)[field] = value;
  }
};

const completedCount = (): number => {
  return workoutStore.exercises.filter((ex) => ex.completed).length;
};

const totalExercises = (): number => {
  return workoutStore.exercises.length;
};

const finishWorkout = async (): Promise<void> => {
  stopTimer();
  isFinishing.value = true;

  const durationMinutes = Math.max(1, Math.round(elapsedSeconds.value / 60));

  try {
    await workoutStore.submitSession(durationMinutes);

    toast.success("Treino finalizado com sucesso!");
    navigateTo(`/students/training-sheets/show?id=${sheetId}`);
  } catch (e: unknown) {
    toast.error("Erro ao finalizar treino", "Tente novamente.");
    console.error(e);
    isFinishing.value = false;
  }
};

onMounted(async () => {
  const item = await trainingSheetStore.loadItem(sheetId);

  if (item) {
    division.value = item.divisions.find((d) => d.id === divisionId) ?? null;

    if (!division.value) {
      error.value = "Ficha ou divisão não encontrada.";
      isLoading.value = false;
      return;
    }

    workoutStore.startSession({
      trainingSheetId: item.id,
      trainingSheetDivisionId: division.value.id,
      exercises: division.value.exercises.map((ex) => ({
        exerciseId: ex.exercise.id,
        exerciseName: ex.exercise.name,
        defaultSeries: ex.series,
        defaultRepetitions: ex.repetitions,
        defaultLoad: ex.load ? Number(ex.load) : null,
      })),
    });

    const savedTimer = workoutStore.restoreTimer();
    if (savedTimer) {
      const elapsed = Math.floor(
        (Date.now() - new Date(savedTimer.replace(" ", "T")).getTime()) / 1000,
      );
      elapsedSeconds.value = Math.max(0, elapsed);
      startTimer();
    }
  }

  isLoading.value = false;
});

onUnmounted(() => {
  stopTimer();
});
</script>

<template>
  <div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 relative">
      <svg
        class="absolute inset-0 w-full h-full opacity-[0.04] pointer-events-none"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
      >
        <defs>
          <pattern
            id="wave-running"
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
        <rect width="100%" height="100%" fill="url(#wave-running)" />
      </svg>

      <div class="relative z-10">
        <div class="flex items-center gap-4 mb-4">
          <NuxtLink
            :to="`/students/training-sheets/show?id=${sheetId}`"
            class="text-zinc-400 hover:text-white transition-colors"
          >
            <Icon name="lucide:arrow-left" class="h-6 w-6" />
          </NuxtLink>
          <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white">
              {{ sheet?.name ?? "Treino em Andamento" }}
            </h1>
            <p class="text-sm sm:text-base text-zinc-400">
              Treino {{ division?.division?.name ?? "" }} &mdash;
              {{ totalExercises() }}
              {{ totalExercises() === 1 ? "exercício" : "exercícios" }}
            </p>
          </div>
        </div>
        <div
          v-if="timerStarted"
          class="flex items-center justify-between sm:justify-start gap-6 mb-8"
        >
          <div>
            <p class="text-xs text-zinc-500 uppercase tracking-wider">Tempo</p>
            <p
              class="text-xl sm:text-2xl font-black text-emerald-400 tabular-nums"
            >
              {{ formatElapsed(elapsedSeconds) }}
            </p>
          </div>
          <div>
            <p class="text-xs text-zinc-500 uppercase tracking-wider">
              Progresso
            </p>
            <p class="text-xl sm:text-2xl font-black text-white tabular-nums">
              {{ completedCount() }}/{{ totalExercises() }}
            </p>
          </div>
        </div>
        <div
          v-else
          class="flex items-center justify-between sm:justify-start gap-6 mb-8"
        >
          <button
            class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white font-bold hover:shadow-lg hover:shadow-emerald-500/30 transition-all flex items-center gap-2"
            @click="handleStartTimer"
          >
            <Icon name="lucide:play" class="h-5 w-5" />
            Iniciar Treino
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
          <p class="text-zinc-400">Carregando treino...</p>
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

        <div v-else-if="division" class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div
            v-for="(ex, index) in division.exercises"
            :key="ex.id"
            class="bg-zinc-800/80 rounded-2xl border overflow-hidden transition-all"
            :class="[
              workoutStore.exercises[index]?.completed
                ? 'border-emerald-500/40 shadow-lg shadow-emerald-500/10'
                : 'border-emerald-500/10 hover:border-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/5',
            ]"
          >
            <div class="h-1 bg-gradient-to-r from-emerald-500 to-emerald-700" />

            <div
              class="relative bg-zinc-800/60 aspect-video overflow-hidden border-b border-zinc-700/30 select-none"
            >
              <div
                class="flex h-full transition-transform duration-300 ease-out"
                :class="swipeDrag ? 'cursor-grabbing' : 'cursor-grab'"
                :style="{
                  transform: `translateX(-${(carouselSlides[ex.id] ?? 0) * 100}%)`,
                }"
                @touchstart="
                  onSwipeStart($event.touches[0]?.clientX ?? 0, ex.id)
                "
                @touchmove="onSwipeMove($event.touches[0]?.clientX ?? 0)"
                @touchend="onSwipeEnd(getSlidesTotal(ex))"
                @mousedown="onSwipeStart($event.clientX, ex.id)"
                @mousemove="onSwipeMove($event.clientX)"
                @mouseup="onSwipeEnd(getSlidesTotal(ex))"
                @mouseleave="onSwipeCancel"
              >
                <div
                  class="w-full h-full shrink-0 flex items-center justify-center"
                  @click="handleImageClick(ex)"
                >
                  <img
                    v-if="ex.exercise.imageUrl"
                    :src="ex.exercise.imageUrl"
                    :alt="ex.exercise.name"
                    class="w-full h-full object-contain p-4 pointer-events-none"
                    draggable="false"
                  />
                  <Icon
                    v-else
                    name="lucide:image-off"
                    class="h-16 w-16 text-zinc-600"
                  />
                </div>
                <div
                  v-if="ex.exercise.gifUrl"
                  class="w-full h-full shrink-0 flex items-center justify-center"
                >
                  <img
                    :src="ex.exercise.gifUrl"
                    :alt="ex.exercise.name"
                    class="w-full h-full object-contain p-4 pointer-events-none"
                    draggable="false"
                  />
                </div>
              </div>

              <div
                v-if="getSlidesTotal(ex) > 1"
                class="absolute bottom-2 left-1/2 -translate-x-1/2 flex items-center gap-1.5"
              >
                <button
                  v-for="dot in getSlidesTotal(ex)"
                  :key="dot"
                  class="w-1.5 h-1.5 rounded-full transition-all"
                  :class="
                    (carouselSlides[ex.id] ?? 0) === dot - 1
                      ? 'bg-emerald-400'
                      : 'bg-zinc-500/50'
                  "
                  @click="carouselSlides[ex.id] = dot - 1"
                />
              </div>

              <button
                v-if="
                  (carouselSlides[ex.id] ?? 0) === 0 && ex.exercise.imageUrl
                "
                class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 rounded-lg p-1.5 transition-colors"
                @click="openImage(ex.exercise.imageUrl!)"
              >
                <Icon name="lucide:zoom-in" class="h-4 w-4 text-white" />
              </button>
            </div>

            <div class="p-5 sm:p-6">
              <div class="flex items-center gap-3 mb-5">
                <span
                  class="h-9 w-9 rounded-xl flex items-center justify-center text-sm font-bold shrink-0"
                  :class="
                    workoutStore.exercises[index]?.completed
                      ? 'bg-emerald-500 text-white'
                      : 'bg-emerald-500/15 text-emerald-400'
                  "
                >
                  <Icon
                    v-if="workoutStore.exercises[index]?.completed"
                    name="lucide:check"
                    class="h-5 w-5"
                  />
                  <span v-else>{{ ex.order }}</span>
                </span>
                <h3 class="text-lg sm:text-xl font-bold text-white flex-1">
                  {{ ex.exercise.name }}
                </h3>
                <button
                  class="h-9 w-9 rounded-xl flex items-center justify-center transition-all"
                  :class="
                    workoutStore.exercises[index]?.completed
                      ? 'bg-emerald-500/20 text-emerald-400'
                      : 'bg-zinc-700/50 text-zinc-400 hover:bg-zinc-600/50 hover:text-white'
                  "
                  :title="
                    workoutStore.exercises[index]?.completed
                      ? 'Marcar como não concluído'
                      : 'Marcar como concluído'
                  "
                  @click="toggleExercise(index)"
                >
                  <Icon name="lucide:circle-check" class="h-5 w-5" />
                </button>
              </div>

              <a
                v-if="ex.exercise.videoUrl"
                :href="ex.exercise.videoUrl"
                target="_blank"
                class="flex items-center justify-center gap-2 w-full mb-4 px-5 py-2.5 rounded-xl bg-blue-500/10 text-blue-400 font-semibold hover:bg-blue-500/20 transition-colors text-sm"
              >
                <Icon name="lucide:video" class="h-4 w-4" />
                Assistir vídeo
              </a>

              <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="bg-zinc-700/50 rounded-xl px-4 py-3">
                  <p
                    class="text-[11px] text-emerald-400/70 uppercase tracking-wider mb-1 font-semibold"
                  >
                    Séries
                  </p>
                  <input
                    :value="
                      exerciseValue(index, 'performedSeries') ?? ex.series
                    "
                    type="number"
                    min="1"
                    class="w-full bg-transparent text-lg text-white font-black outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                    @input="
                      updateExercise(
                        index,
                        'performedSeries',
                        Number(($event.target as HTMLInputElement).value),
                      )
                    "
                  />
                </div>
                <div class="bg-zinc-700/50 rounded-xl px-4 py-3">
                  <p
                    class="text-[11px] text-emerald-400/70 uppercase tracking-wider mb-1 font-semibold"
                  >
                    Repetições
                  </p>
                  <input
                    :value="
                      exerciseValue(index, 'performedRepetitions') ??
                      ex.repetitions
                    "
                    type="text"
                    class="w-full bg-transparent text-lg text-white font-black outline-none"
                    @input="
                      updateExercise(
                        index,
                        'performedRepetitions',
                        ($event.target as HTMLInputElement).value,
                      )
                    "
                  />
                </div>
                <div class="bg-zinc-700/50 rounded-xl px-4 py-3">
                  <p
                    class="text-[11px] text-blue-400/70 uppercase tracking-wider mb-1 font-semibold"
                  >
                    Descanso
                  </p>
                  <p class="text-lg text-white font-black">
                    {{ ex.restSeconds ?? 30 }}s
                  </p>
                </div>
                <div class="bg-zinc-700/50 rounded-xl px-4 py-3">
                  <p
                    class="text-[11px] text-amber-400/70 uppercase tracking-wider mb-1 font-semibold"
                  >
                    Carga
                  </p>
                  <div class="flex items-center gap-1">
                    <input
                      :value="
                        exerciseValue(index, 'performedLoad') ?? ex.load ?? '5'
                      "
                      type="number"
                      step="0.5"
                      min="0"
                      class="w-full min-w-0 bg-transparent text-lg text-white font-black outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                      @input="
                        updateExercise(
                          index,
                          'performedLoad',
                          Number(($event.target as HTMLInputElement).value),
                        )
                      "
                    />
                    <span class="text-lg text-white font-black shrink-0"
                      >kg</span
                    >
                  </div>
                </div>
              </div>

              <div class="bg-zinc-700/30 rounded-xl px-4 py-3">
                <p
                  class="text-[11px] text-zinc-500 uppercase tracking-wider mb-1 font-semibold"
                >
                  Observação
                </p>
                <p class="text-sm text-zinc-300 italic">
                  {{ ex.observation ?? "-" }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <div v-if="timerStarted" class="mt-8 flex flex-col items-center gap-4">
          <button
            class="px-8 py-4 rounded-2xl text-lg font-bold text-white transition-all shadow-lg flex items-center gap-3"
            :class="[
              completedCount() === 0
                ? 'bg-zinc-700 text-zinc-400 cursor-not-allowed'
                : 'bg-gradient-to-r from-emerald-500 to-emerald-700 hover:shadow-emerald-500/30 hover:shadow-xl',
            ]"
            :disabled="completedCount() === 0 || isFinishing"
            @click="showFinishConfirm = true"
          >
            <Icon
              v-if="isFinishing"
              name="lucide:loader-2"
              class="h-6 w-6 animate-spin"
            />
            <Icon v-else name="lucide:flag" class="h-6 w-6" />
            {{ isFinishing ? "Finalizando..." : "Finalizar Treino" }}
          </button>
          <p class="text-xs text-zinc-500 text-center max-w-md leading-relaxed">
            Clique no
            <Icon
              name="lucide:circle-check"
              class="h-3.5 w-3.5 inline-block -mt-0.5"
            />
            ao lado do exercício para marcá-lo como concluído. O cronômetro
            continua mesmo se você atualizar a página.
            <strong class="text-zinc-400">Não saia ou feche a aba</strong>
            durante o treino para não perder o progresso.
          </p>
        </div>
      </div>
    </div>

    <Teleport to="body">
      <Transition name="fade">
        <div
          v-if="showFinishConfirm"
          class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4"
          @click="showFinishConfirm = false"
        >
          <div
            class="bg-zinc-800 rounded-2xl border border-emerald-500/10 p-6 sm:p-8 max-w-sm w-full shadow-2xl"
            @click.stop
          >
            <div
              class="w-14 h-14 rounded-2xl bg-emerald-500/15 flex items-center justify-center mx-auto mb-4"
            >
              <Icon name="lucide:flag" class="h-7 w-7 text-emerald-500" />
            </div>
            <h2 class="text-xl font-bold text-white text-center mb-2">
              Finalizar Treino?
            </h2>
            <p class="text-zinc-400 text-center text-sm mb-6">
              Você concluiu {{ completedCount() }} de
              {{ totalExercises() }} exercícios em
              {{ formatElapsed(elapsedSeconds) }}.
            </p>
            <p
              v-if="completedCount() < totalExercises()"
              class="text-amber-400 text-center text-xs mb-6"
            >
              <Icon
                name="lucide:alert-triangle"
                class="h-4 w-4 inline-block -mt-0.5"
              />
              Ainda há exercícios não concluídos.
            </p>
            <div class="flex gap-3">
              <button
                class="flex-1 px-4 py-2.5 rounded-xl bg-zinc-700 text-zinc-300 font-semibold hover:bg-zinc-600 transition-all"
                @click="showFinishConfirm = false"
              >
                Continuar
              </button>
              <button
                class="flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white font-semibold hover:shadow-lg hover:shadow-emerald-500/30 transition-all flex items-center justify-center gap-2"
                :disabled="isFinishing"
                @click="finishWorkout"
              >
                <Icon
                  v-if="isFinishing"
                  name="lucide:loader-2"
                  class="h-5 w-5 animate-spin"
                />
                <span v-else>Finalizar</span>
              </button>
            </div>
          </div>
        </div>
      </Transition>

      <div
        v-if="selectedImage"
        class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-4"
        @click="selectedImage = null"
      >
        <button
          class="absolute top-4 right-4 text-white hover:text-zinc-300 transition-colors"
          @click="selectedImage = null"
        >
          <Icon name="lucide:x" class="h-8 w-8" />
        </button>
        <img
          :src="selectedImage"
          alt="Exercício"
          class="max-w-full max-h-full object-contain rounded-lg"
          @click.stop
        />
      </div>
    </Teleport>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
