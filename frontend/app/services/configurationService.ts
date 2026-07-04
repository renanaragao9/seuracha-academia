import type { AcademyConfig } from "~/interfaces/academy-config";

interface ApiResponse<T> {
  data: T;
}

export async function fetchConfiguration(
  apiBase: string,
): Promise<AcademyConfig | null> {
  const response = await $fetch<ApiResponse<AcademyConfig>>(
    `${apiBase}/v1/configuration`,
  );

  if (!response?.data) return null;

  return convertKeysToCamel(response.data) as unknown as AcademyConfig;
}
