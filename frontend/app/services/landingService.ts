import type { LandingData } from "~/interfaces/landing-data";

interface ApiResponse<T> {
  data: T;
}

export async function fetchLandingData(
  apiBase: string,
): Promise<LandingData | null> {
  const response = await $fetch<ApiResponse<LandingData>>(
    `${apiBase}/v1/landing`,
  );

  if (!response?.data) return null;

  return convertKeysToCamel(response.data) as unknown as LandingData;
}
