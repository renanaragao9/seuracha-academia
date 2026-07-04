import type { Item, ItemType } from "~/interfaces/item";
import { fetchItems, fetchItem, fetchItemTypes } from "~/services/itemService";

export const useItemStore = defineStore("item", () => {
  const { public: { apiBase } } = useRuntimeConfig();
  const authStore = useAuthStore();

  const items = ref<Item[]>([]);
  const itemTypes = ref<ItemType[]>([]);
  const currentItem = ref<Item | null>(null);
  const isLoading = ref<boolean>(false);
  const error = ref<string | null>(null);

  async function loadItemsAndTypes(): Promise<void> {
    const token = authStore.token;
    if (!token) {
      navigateTo("/login");
      return;
    }

    isLoading.value = true;
    error.value = null;

    try {
      const [itemsData, typesData] = await Promise.all([
        fetchItems(apiBase, token),
        fetchItemTypes(apiBase, token),
      ]);

      for (const item of itemsData) {
        if (item.imageUrl) {
          item.imageUrl = storageUrl(item.imageUrl) as string;
        }
      }

      items.value = itemsData;
      itemTypes.value = typesData;
    } catch (e: unknown) {
      error.value = "Não foi possível carregar os produtos.";
      console.error(e);
    } finally {
      isLoading.value = false;
    }
  }

  async function loadFilteredItems(params: Record<string, string>): Promise<void> {
    const token = authStore.token;
    if (!token) return;

    isLoading.value = true;
    error.value = null;

    try {
      const data = await fetchItems(apiBase, token, params);

      for (const item of data) {
        if (item.imageUrl) {
          item.imageUrl = storageUrl(item.imageUrl) as string;
        }
      }

      items.value = data;
    } catch (e: unknown) {
      error.value = "Não foi possível carregar os produtos.";
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
      const data = await fetchItem(apiBase, token, id);

      if (!data) {
        error.value = "Produto não encontrado.";
        return;
      }

      if (data.imageUrl) {
        data.imageUrl = storageUrl(data.imageUrl) as string;
      }

      currentItem.value = data;
    } catch (e: unknown) {
      error.value = "Não foi possível carregar o produto.";
      console.error(e);
    } finally {
      isLoading.value = false;
    }
  }

  return {
    items,
    itemTypes,
    currentItem,
    isLoading,
    error,
    loadItemsAndTypes,
    loadFilteredItems,
    loadItem,
  };
});
