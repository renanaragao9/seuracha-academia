import type { Post } from "~/interfaces/post";
import { fetchPosts, fetchPost } from "~/services/postService";

export const usePostStore = defineStore("post", () => {
  const { public: { apiBase } } = useRuntimeConfig();
  const authStore = useAuthStore();

  const items = ref<Post[]>([]);
  const currentItem = ref<Post | null>(null);
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
      const data = await fetchPosts(apiBase, token);

      for (const post of data) {
        if (post.imageUrl) {
          post.imageUrl = storageUrl(post.imageUrl) as string;
        }
      }

      items.value = data;
    } catch (e: unknown) {
      error.value = "Não foi possível carregar as postagens.";
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
      const data = await fetchPost(apiBase, token, id);

      if (!data) {
        error.value = "Postagem não encontrada.";
        return;
      }

      if (data.imageUrl) {
        data.imageUrl = storageUrl(data.imageUrl) as string;
      }

      currentItem.value = data;
    } catch (e: unknown) {
      error.value = "Não foi possível carregar a postagem.";
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
