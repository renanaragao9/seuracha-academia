import type { MealPlan } from "~/interfaces/meal-plan";
import { fetchMealPlans, fetchMealPlan, downloadMealPlanPdf } from "~/services/mealPlanService";

export const useMealPlanStore = defineStore("mealPlan", () => {
  const { public: { apiBase } } = useRuntimeConfig();
  const authStore = useAuthStore();

  const items = ref<MealPlan[]>([]);
  const currentItem = ref<MealPlan | null>(null);
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
      items.value = await fetchMealPlans(apiBase, token);
    } catch (e: unknown) {
      error.value = "Não foi possível carregar os planos alimentares.";
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
      const data = await fetchMealPlan(apiBase, token, id);

      if (!data) {
        error.value = "Plano alimentar não encontrado.";
        return;
      }

      currentItem.value = data;
    } catch (e: unknown) {
      error.value = "Não foi possível carregar o plano alimentar.";
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
      const blob = await downloadMealPlanPdf(apiBase, token, id);
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = `plano-alimentar-${id}.pdf`;
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
