import type { Assessment } from "~/interfaces/assessment";

interface ApiResponse<T> {
  data: T;
}

export async function fetchAssessments(
  apiBase: string,
  token: string,
): Promise<Assessment[]> {
  const response = await $fetch<ApiResponse<Assessment[]>>(
    `${apiBase}/v1/assessments`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  const raw = response.data ?? [];
  return raw.map(
    (item) =>
      convertKeysToCamel(item as unknown as Record<string, unknown>) as unknown as Assessment,
  );
}

export async function fetchAssessment(
  apiBase: string,
  token: string,
  id: number,
): Promise<Assessment | null> {
  const response = await $fetch<ApiResponse<Assessment>>(
    `${apiBase}/v1/assessments/${id}`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as Assessment;
}

export async function downloadAssessmentPdf(
  apiBase: string,
  token: string,
  id: number,
): Promise<Blob> {
  const res = await fetch(`${apiBase}/v1/assessments/${id}/pdf`, {
    headers: { Authorization: `Bearer ${token}` },
  });
  return res.blob();
}
