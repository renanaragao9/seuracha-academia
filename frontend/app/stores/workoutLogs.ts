import { submitWorkoutLog } from "~/services/workoutLogService";

interface WorkoutLogExercisePayload {
  exerciseId: number;
  exerciseName: string;
  performedSeries: number | null;
  performedRepetitions: string | null;
  performedLoad: number | null;
  completed: boolean;
  observation: string | null;
}

interface StartWorkoutLogPayload {
  trainingSheetId: number;
  trainingSheetDivisionId: number;
  exercises: Array<{
    exerciseId: number;
    exerciseName: string;
    defaultSeries: number | null;
    defaultRepetitions: string | null;
    defaultLoad: number | null;
  }>;
}

export const useWorkoutLogsStore = defineStore("workoutLogs", () => {
  const { public: { apiBase } } = useRuntimeConfig();
  const authStore = useAuthStore();

  const startedAt = ref<string | null>(null);
  const trainingSheetId = ref<number | null>(null);
  const trainingSheetDivisionId = ref<number | null>(null);
  const exercises = ref<WorkoutLogExercisePayload[]>([]);
  const isSubmitting = ref<boolean>(false);

  const hasSession = computed<boolean>(
    () =>
      !!trainingSheetId.value &&
      !!trainingSheetDivisionId.value,
  );

  const timerRunning = computed<boolean>(() => !!startedAt.value);

  function startSession(payload: StartWorkoutLogPayload): void {
    trainingSheetId.value = payload.trainingSheetId;
    trainingSheetDivisionId.value = payload.trainingSheetDivisionId;

    exercises.value = payload.exercises.map((exercise) => ({
      exerciseId: exercise.exerciseId,
      exerciseName: exercise.exerciseName,
      performedSeries: exercise.defaultSeries,
      performedRepetitions: exercise.defaultRepetitions,
      performedLoad: exercise.defaultLoad,
      completed: false,
      observation: null,
    }));
  }

  function startWorkoutTimer(): void {
    startedAt.value = new Date().toISOString().slice(0, 19).replace("T", " ");
    if (typeof window !== "undefined") {
      localStorage.setItem("workout_started_at", startedAt.value);
    }
  }

  function restoreTimer(): string | null {
    if (typeof window !== "undefined") {
      const saved = localStorage.getItem("workout_started_at");
      if (saved) {
        startedAt.value = saved;
        return saved;
      }
    }
    return null;
  }

  function clearSession(): void {
    startedAt.value = null;
    trainingSheetId.value = null;
    trainingSheetDivisionId.value = null;
    exercises.value = [];
    if (typeof window !== "undefined") {
      localStorage.removeItem("workout_started_at");
    }
  }

  async function submitSession(
    durationMinutes: number | null,
  ): Promise<Record<string, unknown>> {
    const token = authStore.token;
    if (
      !startedAt.value ||
      !trainingSheetId.value ||
      !trainingSheetDivisionId.value
    ) {
      throw new Error("Sessao de treino invalida.");
    }

    if (!token) {
      throw new Error("Token nao encontrado.");
    }

    isSubmitting.value = true;

    try {
      const finishedAt =
        new Date().toISOString().slice(0, 19).replace("T", " ");

      const data = await submitWorkoutLog(apiBase, token, {
        training_sheet_id: trainingSheetId.value,
        training_sheet_division_id: trainingSheetDivisionId.value,
        started_at: startedAt.value,
        finished_at: finishedAt,
        duration_minutes: durationMinutes ?? null,
        exercises: exercises.value.map((exercise) => ({
          exercise_id: exercise.exerciseId,
          performed_series: exercise.performedSeries,
          performed_repetitions: exercise.performedRepetitions,
          performed_load: exercise.performedLoad,
          completed: exercise.completed,
          observation: exercise.observation,
        })),
      });

      clearSession();

      return data;
    } finally {
      isSubmitting.value = false;
    }
  }

  return {
    startedAt,
    trainingSheetId,
    trainingSheetDivisionId,
    exercises,
    isSubmitting,
    hasSession,
    timerRunning,
    startSession,
    startWorkoutTimer,
    restoreTimer,
    clearSession,
    submitSession,
  };
});
