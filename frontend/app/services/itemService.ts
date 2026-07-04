import type { Item, ItemType } from "~/interfaces/item";

interface ApiResponse<T> {
  data: T;
}

export async function fetchItems(
  apiBase: string,
  token: string,
  params: Record<string, string> = {},
): Promise<Item[]> {
  const response = await $fetch<ApiResponse<Item[]>>(
    `${apiBase}/v1/items`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
      params: Object.keys(params).length > 0 ? params : undefined,
    },
  );

  const raw = response.data ?? [];
  return raw.map(
    (item) =>
      convertKeysToCamel(item as unknown as Record<string, unknown>) as unknown as Item,
  );
}

export async function fetchItem(
  apiBase: string,
  token: string,
  id: number,
): Promise<Item | null> {
  const response = await $fetch<ApiResponse<Item>>(
    `${apiBase}/v1/items/${id}`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as Item;
}

export async function fetchItemTypes(
  apiBase: string,
  token: string,
): Promise<ItemType[]> {
  const response = await $fetch<ApiResponse<ItemType[]>>(
    `${apiBase}/v1/item_types`,
    {
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  const raw = response.data ?? [];
  return raw.map(
    (t) =>
      convertKeysToCamel(t as unknown as Record<string, unknown>) as unknown as ItemType,
  );
}
