import type { TrainingSheet } from "~/interfaces/training-sheet";
import { fetchTrainingSheets, fetchTrainingSheet, downloadTrainingSheetPdf } from "~/services/trainingSheetService";

export const useTrainingSheetStore = defineStore("trainingSheet", () => {
  const { public: { apiBase } } = useRuntimeConfig();
  const authStore = useAuthStore();

  const items = ref<TrainingSheet[]>([]);
  const currentItem = ref<TrainingSheet | null>(null);
  const isLoading = ref<boolean>(false);
  const isDownloadingPdf = ref<boolean>(false);
  const error = ref<string | null>(null);

  async function loadItems(): Promise<void> {
    const token = authStore.token;
    if (!token) {
      navigateTo("/login");
      return;
    }

    isLoading.value = true;
    error.value = null;

    try {
      items.value = await fetchTrainingSheets(apiBase, token);
    } catch (e: unknown) {
      error.value = "Não foi possível carregar as fichas de treino.";
      console.error(e);
    } finally {
      isLoading.value = false;
    }
  }

  async function loadItem(id: number): Promise<TrainingSheet | null> {
    const token = authStore.token;
    if (!token) {
      navigateTo("/login");
      return null;
    }

    isLoading.value = true;
    error.value = null;
    currentItem.value = null;

    try {
      const data = await fetchTrainingSheet(apiBase, token, id);

      if (!data) {
        error.value = "Ficha não encontrada.";
        return null;
      }

      rewriteSheetStorageUrls(data);
      currentItem.value = data;
      return data;
    } catch (e: unknown) {
      error.value = "Não foi possível carregar a ficha de treino.";
      console.error(e);
      return null;
    } finally {
      isLoading.value = false;
    }
  }

  async function downloadPdf(id: number): Promise<void> {
    const token = authStore.token;
    if (!token) return;

    isDownloadingPdf.value = true;

    try {
      const blob = await downloadTrainingSheetPdf(apiBase, token, id);
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = `ficha-${id}.pdf`;
      a.click();
      URL.revokeObjectURL(url);
    } finally {
      isDownloadingPdf.value = false;
    }
  }

  return {
    items,
    currentItem,
    isLoading,
    isDownloadingPdf,
    error,
    loadItems,
    loadItem,
    downloadPdf,
  };
});
