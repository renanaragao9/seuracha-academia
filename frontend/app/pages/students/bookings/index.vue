<script setup lang="ts">
import type { Booking } from "~/interfaces/booking";

definePageMeta({
  middleware: ["auth"],
});

const bookingStore = useBookingStore();
const { availableBookings, myBookings, isLoading, loadingId, error } = storeToRefs(bookingStore);

const activeTab = ref<"available" | "my">("available");

const selectedBooking = ref<Booking | null>(null);
const modalType = ref<"register" | "unregister" | null>(null);

const formatDate = (dateStr: string | null): string => {
  return brDateShort(dateStr);
};

const formatTime = (dateStr: string): string => {
  return brTime(dateStr);
};

function openConfirmModal(booking: Booking): void {
  selectedBooking.value = booking;
  modalType.value = booking.isRegistered ? "unregister" : "register";
}

function closeConfirmModal(): void {
  if (loadingId.value) return;
  selectedBooking.value = null;
  modalType.value = null;
}

async function handleConfirm(): Promise<void> {
  const booking = selectedBooking.value;
  if (!booking || !modalType.value) return;
  closeConfirmModal();
  await bookingStore.toggleRegistration(booking);
}

function vacanciesLabel(booking: Booking): string {
  const available = booking.vacancies - booking.bookedCount;
  if (available <= 0) return "Lotado";
  if (available === 1) return "1 vaga";
  return `${available} vagas`;
}

function vacanciesColor(booking: Booking): string {
  const available = booking.vacancies - booking.bookedCount;
  if (available <= 0) return "text-red-400";
  if (available <= 3) return "text-amber-400";
  return "text-emerald-400";
}

onMounted(() => {
  bookingStore.loadAll();
});
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 relative">
    <svg
      class="absolute inset-0 w-full h-full opacity-[0.04] pointer-events-none"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <pattern
          id="wave-bookings"
          x="0"
          y="0"
          width="40"
          height="20"
          patternUnits="userSpaceOnUse"
        >
          <path
            d="M0 15 Q10 5 20 15 Q30 25 40 15"
            stroke="#10b981"
            fill="none"
            stroke-width="1"
          />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#wave-bookings)" />
    </svg>

    <div class="relative z-10">
      <div class="flex items-center gap-4 mb-8">
        <NuxtLink
          to="/students"
          class="text-zinc-400 hover:text-white transition-colors"
        >
          <Icon name="lucide:arrow-left" class="h-6 w-6" />
        </NuxtLink>
        <div>
          <h1 class="text-2xl sm:text-3xl font-bold text-white">Agendamentos</h1>
          <p class="text-sm sm:text-base text-zinc-400">
            Eventos e aulas disponíveis na academia
          </p>
        </div>
      </div>

      <div class="flex gap-1 mb-6 bg-zinc-800/50 rounded-lg p-1 w-fit">
        <button
          class="px-4 py-2 text-sm font-medium rounded-md transition-colors"
          :class="
            activeTab === 'available'
              ? 'bg-emerald-500 text-white'
              : 'text-zinc-400 hover:text-white'
          "
          @click="activeTab = 'available'"
        >
          Disponíveis
        </button>
        <button
          class="px-4 py-2 text-sm font-medium rounded-md transition-colors"
          :class="
            activeTab === 'my'
              ? 'bg-emerald-500 text-white'
              : 'text-zinc-400 hover:text-white'
          "
          @click="activeTab = 'my'"
        >
          Meus Agendamentos
        </button>
      </div>

      <div
        v-if="isLoading"
        class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
      >
        <Icon
          name="lucide:loader-2"
          class="h-12 w-12 text-emerald-500 mx-auto mb-4 animate-spin"
        />
        <p class="text-zinc-400">Carregando agendamentos...</p>
      </div>

      <div
        v-else-if="error"
        class="bg-zinc-800/80 rounded-2xl border border-red-500/20 text-center py-20"
      >
        <Icon
          name="lucide:alert-circle"
          class="h-12 w-12 text-red-500 mx-auto mb-4"
        />
        <h2 class="text-xl font-bold text-white mb-2">Erro ao carregar</h2>
        <p class="text-zinc-400">{{ error }}</p>
      </div>

      <template v-else-if="activeTab === 'available'">
        <div
          v-if="availableBookings.length === 0"
          class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
        >
          <Icon
            name="lucide:calendar"
            class="h-16 w-16 text-emerald-500 mx-auto mb-4"
          />
          <h2 class="text-xl font-bold text-white mb-2">
            Nenhum evento disponível
          </h2>
          <p class="text-zinc-400">
            No momento não há eventos com vagas disponíveis.
          </p>
        </div>

        <div
          v-else
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"
        >
          <div
            v-for="booking in availableBookings"
            :key="booking.id"
            class="bg-zinc-800/80 border border-emerald-500/10 hover:border-emerald-500/30 rounded-2xl hover:shadow-xl md:hover:scale-[1.02] transition-all p-5 flex flex-col cursor-pointer"
            @click="navigateTo(`/students/bookings/show?id=${booking.id}`)"
          >
            <div class="flex items-center gap-3 mb-4">
              <div
                class="h-12 w-12 rounded-xl bg-emerald-500/15 flex items-center justify-center shrink-0"
              >
                <Icon name="lucide:calendar-days" class="h-6 w-6 text-emerald-500" />
              </div>
              <div class="min-w-0 flex-1">
                <p class="text-white font-bold truncate">
                  {{ booking.bookingType?.name || "Evento" }}
                </p>
                <p class="text-sm text-zinc-400 mt-0.5">
                  {{ formatDate(booking.startDate) }} às {{ formatTime(booking.startDate) }}
                </p>
              </div>
            </div>

            <div
              v-if="booking.fullAddresses"
              class="text-xs text-zinc-500 truncate mb-4"
            >
              {{ booking.fullAddresses }}
            </div>

            <div class="flex items-center justify-between text-sm mt-auto">
              <span class="font-medium" :class="vacanciesColor(booking)">
                {{ vacanciesLabel(booking) }}
              </span>

              <button
                class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors"
                :class="
                  booking.isRegistered
                    ? 'bg-red-500/10 text-red-400 border border-red-500/30 hover:bg-red-500/20'
                    : 'bg-emerald-500 text-white hover:bg-emerald-600'
                "
                :disabled="loadingId !== null"
                @click.stop="openConfirmModal(booking)"
              >
                <Icon
                  v-if="loadingId === booking.id"
                  name="lucide:loader-2"
                  class="h-3.5 w-3.5 animate-spin mx-auto"
                />
                <span v-else>{{
                  booking.isRegistered ? "Cancelar" : "Inscrever-se"
                }}</span>
              </button>
            </div>
          </div>
        </div>
      </template>

      <template v-else>
        <div
          v-if="myBookings.length === 0"
          class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
        >
          <Icon
            name="lucide:calendar-check"
            class="h-16 w-16 text-emerald-500 mx-auto mb-4"
          />
          <h2 class="text-xl font-bold text-white mb-2">Nenhum agendamento</h2>
          <p class="text-zinc-400">
            Você ainda não está inscrito em nenhum evento.
          </p>
        </div>

        <div
          v-else
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"
        >
          <div
            v-for="booking in myBookings"
            :key="booking.id"
            class="bg-zinc-800/80 border border-emerald-500/10 hover:border-emerald-500/30 rounded-2xl hover:shadow-xl md:hover:scale-[1.02] transition-all p-5 flex flex-col cursor-pointer"
            @click="navigateTo(`/students/bookings/show?id=${booking.id}`)"
          >
            <div class="flex items-center gap-3 mb-4">
              <div
                class="h-12 w-12 rounded-xl bg-emerald-500/15 flex items-center justify-center shrink-0"
              >
                <Icon name="lucide:calendar-check" class="h-6 w-6 text-emerald-500" />
              </div>
              <div class="min-w-0 flex-1">
                <p class="text-white font-bold truncate">
                  {{ booking.bookingType?.name || "Evento" }}
                </p>
                <p class="text-sm text-zinc-400 mt-0.5">
                  {{ formatDate(booking.startDate) }} às {{ formatTime(booking.startDate) }}
                </p>
              </div>
            </div>

            <div
              v-if="booking.description"
              class="text-xs text-zinc-500 truncate mb-4"
            >
              {{ booking.description }}
            </div>

            <div class="flex items-center justify-end text-sm mt-auto">
              <button
                class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-500/10 text-red-400 border border-red-500/30 hover:bg-red-500/20 transition-colors"
                :disabled="loadingId !== null"
                @click.stop="openConfirmModal(booking)"
              >
                <Icon
                  v-if="loadingId === booking.id"
                  name="lucide:loader-2"
                  class="h-3.5 w-3.5 animate-spin mx-auto"
                />
                <span v-else>Cancelar</span>
              </button>
            </div>
          </div>
        </div>
      </template>

      <AppModal
        :open="modalType !== null"
        :title="
          modalType === 'register' ? 'Confirmar Inscrição' : 'Cancelar Inscrição'
        "
        :description="
          modalType === 'register'
            ? `Deseja se inscrever no evento ${selectedBooking?.bookingType?.name || ''}?`
            : `Deseja cancelar sua inscrição no evento ${selectedBooking?.bookingType?.name || ''}?`
        "
        :confirm-label="
          modalType === 'register' ? 'Inscrever-se' : 'Cancelar Inscrição'
        "
        :variant="modalType === 'unregister' ? 'danger' : 'primary'"
        :loading="loadingId !== null"
        @confirm="handleConfirm"
        @cancel="closeConfirmModal"
      />
    </div>
  </div>
</template>
