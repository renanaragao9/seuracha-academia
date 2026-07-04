export default defineNuxtPlugin(() => {
  const storedUser =
    typeof window !== "undefined" ? localStorage.getItem("user") : null;
  const storedToken =
    typeof window !== "undefined" ? localStorage.getItem("token") : null;
  const storedConfig =
    typeof window !== "undefined"
      ? localStorage.getItem("configuration")
      : null;

  if (storedUser && storedToken) {
    const auth = useAuthStore();
    auth.$patch({
      user: JSON.parse(storedUser),
      token: storedToken,
    });
  }

  if (storedConfig) {
    const configuration = useConfigurationStore();
    configuration.$patch({
      config: JSON.parse(storedConfig),
    });
  }
});
