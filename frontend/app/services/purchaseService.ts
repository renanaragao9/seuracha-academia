import type { Purchase } from "~/interfaces/purchase";

interface ApiResponse<T> {
  data: T;
}

export async function fetchPurchases(
  apiBase: string,
  token: string,
): Promise<Purchase[]> {
  const response = await $fetch<ApiResponse<Purchase[]>>(
    `${apiBase}/v1/purchases`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  const raw = response.data ?? [];
  return raw.map(
    (item) =>
      convertKeysToCamel(item as unknown as Record<string, unknown>) as unknown as Purchase,
  );
}

export async function fetchPurchase(
  apiBase: string,
  token: string,
  id: number,
): Promise<Purchase | null> {
  const response = await $fetch<ApiResponse<Purchase>>(
    `${apiBase}/v1/purchases/${id}`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as Purchase;
}
