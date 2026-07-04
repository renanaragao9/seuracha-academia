import type { Booking } from "~/interfaces/booking";
import {
  fetchBookings,
  fetchMyBookings,
  fetchBooking,
  registerBooking,
  unregisterBooking,
} from "~/services/bookingService";

export const useBookingStore = defineStore("booking", () => {
  const { public: { apiBase } } = useRuntimeConfig();
  const authStore = useAuthStore();
  const toast = useToast();

  const availableBookings = ref<Booking[]>([]);
  const myBookings = ref<Booking[]>([]);
  const currentBooking = ref<Booking | null>(null);
  const isLoading = ref<boolean>(false);
  const loadingId = ref<number | null>(null);
  const error = ref<string | null>(null);

  async function loadAll(): Promise<void> {
    const token = authStore.token;
    if (!token) {
      navigateTo("/login");
      return;
    }

    isLoading.value = true;
    error.value = null;

    try {
      const [available, my] = await Promise.all([
        fetchBookings(apiBase, token),
        fetchMyBookings(apiBase, token),
      ]);

      availableBookings.value = available;
      myBookings.value = my;
    } catch {
      error.value = "Não foi possível carregar os agendamentos.";
    } finally {
      isLoading.value = false;
    }
  }

  async function loadBooking(id: number): Promise<void> {
    const token = authStore.token;
    if (!token || !id) {
      navigateTo("/students/bookings");
      return;
    }

    isLoading.value = true;
    error.value = null;
    currentBooking.value = null;

    try {
      const data = await fetchBooking(apiBase, token, id);
      currentBooking.value = data;
    } catch {
      error.value = "Não foi possível carregar o agendamento.";
    } finally {
      isLoading.value = false;
    }
  }

  async function toggleRegistration(booking: Booking): Promise<void> {
    const token = authStore.token;
    if (!token || loadingId.value) return;

    loadingId.value = booking.id;

    try {
      const updated = booking.isRegistered
        ? await unregisterBooking(apiBase, token, booking.id)
        : await registerBooking(apiBase, token, booking.id);

      const updateList = (list: Ref<Booking[]>) => {
        const idx = list.value.findIndex((b) => b.id === booking.id);
        if (idx !== -1) {
          list.value[idx] = { ...list.value[idx], ...updated };
        }
      };

      updateList(availableBookings);
      updateList(myBookings);

      if (updated.isRegistered) {
        toast.success("Inscrição realizada", "Você foi inscrito no evento com sucesso.");
        availableBookings.value = availableBookings.value.filter((b) => b.id !== updated.id);
        if (!myBookings.value.find((b) => b.id === updated.id)) {
          myBookings.value.unshift(updated);
        }
      } else {
        toast.info("Inscrição cancelada", "Sua inscrição no evento foi cancelada.");
        myBookings.value = myBookings.value.filter((b) => b.id !== updated.id);
      }

      if (currentBooking.value?.id === updated.id) {
        currentBooking.value = { ...currentBooking.value, ...updated };
      }
    } catch (err: unknown) {
      const apiMessage = (err as { data?: { message?: string } })?.data?.message;
      toast.error("Erro", apiMessage || "Não foi possível processar sua solicitação.");
    } finally {
      loadingId.value = null;
    }
  }

  return {
    availableBookings,
    myBookings,
    currentBooking,
    isLoading,
    loadingId,
    error,
    loadAll,
    loadBooking,
    toggleRegistration,
  };
});
