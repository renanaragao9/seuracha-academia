import type { TrainingSheet } from "~/interfaces/training-sheet";

interface ApiResponse<T> {
  data: T;
}

export async function fetchTrainingSheets(
  apiBase: string,
  token: string,
): Promise<TrainingSheet[]> {
  const response = await $fetch<ApiResponse<TrainingSheet[]>>(
    `${apiBase}/v1/training_sheets`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  const raw = response.data ?? [];
  return raw.map(
    (item) =>
      convertKeysToCamel(item as unknown as Record<string, unknown>) as unknown as TrainingSheet,
  );
}

export async function fetchTrainingSheet(
  apiBase: string,
  token: string,
  id: number,
): Promise<TrainingSheet | null> {
  const response = await $fetch<ApiResponse<TrainingSheet>>(
    `${apiBase}/v1/training_sheets/${id}`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as TrainingSheet;
}

export async function downloadTrainingSheetPdf(
  apiBase: string,
  token: string,
  id: number,
): Promise<Blob> {
  const res = await fetch(`${apiBase}/v1/training_sheets/${id}/pdf`, {
    headers: { Authorization: `Bearer ${token}` },
  });
  return res.blob();
}
