import type { MealPlan } from "~/interfaces/meal-plan";

interface ApiResponse<T> {
  data: T;
}

export async function fetchMealPlans(
  apiBase: string,
  token: string,
): Promise<MealPlan[]> {
  const response = await $fetch<ApiResponse<MealPlan[]>>(
    `${apiBase}/v1/meal_plans`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  const raw = response.data ?? [];
  return raw.map(
    (item) =>
      convertKeysToCamel(item as unknown as Record<string, unknown>) as unknown as MealPlan,
  );
}

export async function fetchMealPlan(
  apiBase: string,
  token: string,
  id: number,
): Promise<MealPlan | null> {
  const response = await $fetch<ApiResponse<MealPlan>>(
    `${apiBase}/v1/meal_plans/${id}`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as MealPlan;
}

export async function downloadMealPlanPdf(
  apiBase: string,
  token: string,
  id: number,
): Promise<Blob> {
  const res = await fetch(`${apiBase}/v1/meal_plans/${id}/pdf`, {
    headers: { Authorization: `Bearer ${token}` },
  });
  return res.blob();
}
