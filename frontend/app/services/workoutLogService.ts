interface ApiResponse<T> {
  data: T;
}

export async function submitWorkoutLog(
  apiBase: string,
  token: string,
  body: {
    training_sheet_id: number;
    training_sheet_division_id: number;
    started_at: string;
    finished_at: string;
    duration_minutes: number | null;
    exercises: Array<{
      exercise_id: number;
      performed_series: number | null;
      performed_repetitions: string | null;
      performed_load: number | null;
      completed: boolean;
      observation: string | null;
    }>;
  },
): Promise<{ id: number; [key: string]: unknown }> {
  const response = await $fetch<ApiResponse<{ id: number; [key: string]: unknown }>>(
    `${apiBase}/v1/workout_logs`,
    {
      method: "POST",
      headers: { Authorization: `Bearer ${token}` },
      body,
    },
  );

  return response.data;
}
