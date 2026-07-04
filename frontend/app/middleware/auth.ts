export default defineNuxtRouteMiddleware((_to, _from) => {
  if (import.meta.client) {
    const token = localStorage.getItem("token");

    if (!token) {
      return navigateTo("/login");
    }
  }
});
