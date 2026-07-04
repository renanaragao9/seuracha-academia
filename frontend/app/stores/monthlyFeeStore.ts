import type { MonthlyFee } from "~/interfaces/monthly-fee";
import { fetchMonthlyFees, fetchMonthlyFee, downloadMonthlyFeePdf } from "~/services/monthlyFeeService";

export const useMonthlyFeeStore = defineStore("monthlyFee", () => {
  const { public: { apiBase } } = useRuntimeConfig();
  const authStore = useAuthStore();

  const items = ref<MonthlyFee[]>([]);
  const currentItem = ref<MonthlyFee | null>(null);
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
      items.value = await fetchMonthlyFees(apiBase, token);
    } catch (e: unknown) {
      error.value = "Não foi possível carregar as mensalidades.";
      console.error(e);
    } finally {
      isLoading.value = false;
    }
  }

  async function loadItem(id: number): Promise<void> {
    const token = authStore.token;
    if (!token) {
      navigateTo("/login");
      return;
    }

    isLoading.value = true;
    error.value = null;
    currentItem.value = null;

    try {
      const data = await fetchMonthlyFee(apiBase, token, id);

      if (!data) {
        error.value = "Mensalidade não encontrada.";
        return;
      }

      currentItem.value = data;
    } catch (e: unknown) {
      error.value = "Não foi possível carregar a mensalidade.";
      console.error(e);
    } finally {
      isLoading.value = false;
    }
  }

  async function downloadPdf(id: number): Promise<void> {
    const token = authStore.token;
    if (!token) return;

    isDownloadingPdf.value = true;

    try {
      const blob = await downloadMonthlyFeePdf(apiBase, token, id);
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = `mensalidade-${id}.pdf`;
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
