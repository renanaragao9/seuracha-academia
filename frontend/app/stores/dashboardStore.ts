import type { Post } from "~/interfaces/post";
import { fetchPosts } from "~/services/postService";
import { fetchBookings } from "~/services/bookingService";

export const useDashboardStore = defineStore("dashboard", () => {
  const { public: { apiBase } } = useRuntimeConfig();
  const authStore = useAuthStore();

  const posts = ref<Post[]>([]);
  const bookingsCount = ref<Record<number, number>>({});
  const isLoading = ref<boolean>(true);

  async function loadAll(): Promise<boolean> {
    const token = authStore.token;

    if (!token) {
      navigateTo("/login");
      return false;
    }

    const [postsResult, bookingsResult] = await Promise.allSettled([
      fetchPosts(apiBase, token),
      fetchBookings(apiBase, token),
    ]);

    if (postsResult.status === "fulfilled") {
      const postsData = postsResult.value;
      for (const post of postsData) {
        if (post.imageUrl) {
          post.imageUrl = storageUrl(post.imageUrl) as string;
        }
      }
      posts.value = postsData;
    } else {
      console.error("Erro ao carregar posts:", postsResult.reason);
    }

    if (bookingsResult.status === "fulfilled") {
      const bookingsData = bookingsResult.value;
      const counts: Record<number, number> = {};
      for (const raw of bookingsData) {
        const startDate = raw.startDate;
        if (startDate) {
          const d = new Date(startDate.replace(" ", "T"));
          if (!isNaN(d.getTime())) {
            const day = d.getDay();
            counts[day] = (counts[day] || 0) + 1;
          }
        }
      }
      bookingsCount.value = counts;
    } else {
      console.error("Erro ao carregar bookings:", bookingsResult.reason);
    }

    isLoading.value = false;
    return true;
  }

  return {
    posts,
    bookingsCount,
    isLoading,
    loadAll,
  };
});
