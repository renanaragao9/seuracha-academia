import type { AcademyConfig } from "~/interfaces/academy-config";
import { fetchConfiguration } from "~/services/configurationService";

export const useConfigurationStore = defineStore("configuration", () => {
  const { public: { apiBase } } = useRuntimeConfig();

  const storedConfig =
    typeof window !== "undefined" ? localStorage.getItem("configuration") : null;

  const config = ref<AcademyConfig | null>(
    storedConfig ? JSON.parse(storedConfig) : null,
  );

  function persist(): void {
    if (typeof window !== "undefined") {
      if (config.value) {
        localStorage.setItem("configuration", JSON.stringify(config.value));
      } else {
        localStorage.removeItem("configuration");
      }
    }
  }

  async function loadConfig(): Promise<void> {
    try {
      const data = await fetchConfiguration(apiBase);
      if (data) {
        config.value = data;
        persist();
      }
    } catch (error) {
      console.error("Erro ao buscar configuração:", error);
    }
  }

  return {
    config,
    loadConfig,
  };
});
