import type { Purchase } from "~/interfaces/purchase";
import { fetchPurchases, fetchPurchase } from "~/services/purchaseService";

export const usePurchaseStore = defineStore("purchase", () => {
  const { public: { apiBase } } = useRuntimeConfig();
  const authStore = useAuthStore();

  const items = ref<Purchase[]>([]);
  const currentItem = ref<Purchase | null>(null);
  const isLoading = ref<boolean>(false);
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
      items.value = await fetchPurchases(apiBase, token);
    } catch (e: unknown) {
      error.value = "Não foi possível carregar as compras.";
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
      const data = await fetchPurchase(apiBase, token, id);

      if (!data) {
        error.value = "Compra não encontrada.";
        return;
      }

      currentItem.value = data;
    } catch (e: unknown) {
      error.value = "Não foi possível carregar a compra.";
      console.error(e);
    } finally {
      isLoading.value = false;
    }
  }

  return {
    items,
    currentItem,
    isLoading,
    error,
    loadItems,
    loadItem,
  };
});
