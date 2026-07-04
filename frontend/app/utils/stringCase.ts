export function snakeToCamel(str: string): string {
  return str.replace(/_([a-z])/g, (_, letter) => letter.toUpperCase());
}

export function convertKeysToCamel<
  T extends Record<string, unknown> = Record<string, unknown>,
>(obj: unknown): T {
  if (obj === null || typeof obj !== "object") {
    return obj as T;
  }

  if (Array.isArray(obj)) {
    return obj.map((item) => convertKeysToCamel(item)) as unknown as T;
  }

  const converted: Record<string, unknown> = {};
  for (const key in obj) {
    if (Object.prototype.hasOwnProperty.call(obj, key)) {
      const camelKey = snakeToCamel(key);
      converted[camelKey] = convertKeysToCamel(
        (obj as Record<string, unknown>)[key],
      );
    }
  }

  return converted as T;
}

export async function useConfigurationConverter() {
  const {
    public: { apiBase },
  } = useRuntimeConfig();

  interface ConfigResponse {
    data: Record<string, unknown>;
  }

  try {
    const response = await $fetch<ConfigResponse>(
      `${apiBase}/v1/configuration`,
    );

    return {
      data: convertKeysToCamel<Record<string, unknown>>(response.data),
      raw: response.data,
    };
  } catch (error) {
    console.error("Erro ao buscar configuração da academia:", error);
    throw error;
  }
}
