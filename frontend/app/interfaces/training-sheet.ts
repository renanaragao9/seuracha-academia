export interface Exercise {
  id: number;
  name: string;
  imageUrl?: string | null;
  gifUrl?: string | null;
  videoUrl?: string | null;
}

export interface TrainingExercise {
  id: number;
  order: number;
  series: number;
  repetitions: string;
  restSeconds?: number | null;
  load?: string | null;
  observation?: string | null;
  exercise: Exercise;
}

export interface Division {
  id: number;
  name: string;
}

export interface TrainingSheetDivision {
  id: number;
  order: number;
  division: { id: number; name: string };
  exercises: TrainingExercise[];
}

export interface WorkoutLogExercise {
  id: number;
  performedSeries?: number | null;
  performedRepetitions?: string | null;
  performedLoad?: string | null;
  completed: boolean;
  observation?: string | null;
  exercise: Exercise;
}

export interface WorkoutLog {
  id: number;
  startedAt: string | null;
  finishedAt: string | null;
  durationMinutes: number | null;
  division: { id: number; name: string };
  validator: { id: number | null; name: string | null };
  logExercises: WorkoutLogExercise[];
}

export interface TrainingSheet {
  id: number;
  name: string;
  startDate: string | null;
  endDate: string | null;
  isActive: boolean;
  divisionsCount?: number;
  divisions: TrainingSheetDivision[];
  workoutLogs: WorkoutLog[];
}

export interface ApiResponse {
  data: Record<string, unknown>[];
}

export interface StatusLabel {
  text: string;
  class: string;
}
