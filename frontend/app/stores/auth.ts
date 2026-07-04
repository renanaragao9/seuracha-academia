import type { User } from "~/interfaces/auth";
import { fetchMe, logout as logoutService } from "~/services/auth";

export const useAuthStore = defineStore("auth", () => {
  const { public: { apiBase } } = useRuntimeConfig();

  const storedUser =
    typeof window !== "undefined" ? localStorage.getItem("user") : null;
  const storedToken =
    typeof window !== "undefined" ? localStorage.getItem("token") : null;

  const user = ref<User | null>(storedUser ? JSON.parse(storedUser) : null);
  const token = ref<string | null>(storedToken ?? null);

  const isAuthenticated = computed<boolean>(() => !!token.value && !!user.value);

  function persist(): void {
    if (typeof window !== "undefined") {
      if (token.value && user.value) {
        localStorage.setItem("user", JSON.stringify(user.value));
        localStorage.setItem("token", token.value);
      } else {
        localStorage.removeItem("user");
        localStorage.removeItem("token");
      }
    }
  }

  function setAuth(userData: User, authToken: string): void {
    if (userData.imageUrl) {
      userData.imageUrl = storageUrl(userData.imageUrl) as string;
    }
    user.value = userData;
    token.value = authToken;
    persist();
  }

  function clearAuth(): void {
    user.value = null;
    token.value = null;
    persist();
  }

  async function loadMe(): Promise<void> {
    if (!token.value) return;

    const data = await fetchMe(apiBase, token.value);

    if (data) {
      user.value = data;
      persist();
    }
  }

  async function performLogout(): Promise<void> {
    if (token.value) {
      try {
        await logoutService(apiBase, token.value);
      } catch {
        // proceed with local logout even if API fails
      }
    }
    clearAuth();
    navigateTo("/login");
  }

  return {
    user,
    token,
    isAuthenticated,
    setAuth,
    clearAuth,
    loadMe,
    performLogout,
  };
});
