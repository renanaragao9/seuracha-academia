export interface ApiResponse<T = unknown> {
  status: "success" | "error";
  message: string;
  data: T | null;
}

export interface ChatData {
  message: string;
  training_sheet?: {
    id: number;
    name: string;
    created_at: string;
  };
  meal_plan?: {
    id: number;
    name: string;
    created_at: string;
  };
}
