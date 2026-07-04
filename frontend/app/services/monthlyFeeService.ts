import type { MonthlyFee } from "~/interfaces/monthly-fee";

interface ApiResponse<T> {
  data: T;
}

export async function fetchMonthlyFees(
  apiBase: string,
  token: string,
): Promise<MonthlyFee[]> {
  const response = await $fetch<ApiResponse<MonthlyFee[]>>(
    `${apiBase}/v1/monthly_fees`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  const raw = response.data ?? [];
  return raw.map(
    (item) =>
      convertKeysToCamel(item as unknown as Record<string, unknown>) as unknown as MonthlyFee,
  );
}

export async function fetchMonthlyFee(
  apiBase: string,
  token: string,
  id: number,
): Promise<MonthlyFee | null> {
  const response = await $fetch<ApiResponse<MonthlyFee>>(
    `${apiBase}/v1/monthly_fees/${id}`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as MonthlyFee;
}

export async function downloadMonthlyFeePdf(
  apiBase: string,
  token: string,
  id: number,
): Promise<Blob> {
  const res = await fetch(`${apiBase}/v1/monthly_fees/${id}/pdf`, {
    headers: { Authorization: `Bearer ${token}` },
  });
  return res.blob();
}
