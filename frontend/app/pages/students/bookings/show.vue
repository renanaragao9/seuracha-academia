<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const route = useRoute();

const bookingStore = useBookingStore();
const { isLoading, error, currentBooking: booking } = storeToRefs(bookingStore);

const loadingAction = computed(() => bookingStore.loadingId !== null);

const bookingId = computed(() => Number(route.query.id));

const showModal = ref<boolean>(false);

const formatDate = (dateStr: string | null): string => {
  return brDate(dateStr);
};

const formatTime = (dateStr: string): string => {
  return brTime(dateStr);
};

function openConfirmModal(): void {
  showModal.value = true;
}

function closeConfirmModal(): void {
  if (loadingAction.value) return;
  showModal.value = false;
}

async function handleConfirm(): Promise<void> {
  if (!booking.value) return;
  showModal.value = false;
  await bookingStore.toggleRegistration(booking.value);
}

onMounted(() => {
  bookingStore.loadBooking(bookingId.value);
});
</script>

<template>
  <div class="max-w-3xl mx-auto px-4 sm:px-6 py-6 sm:py-8 relative">
    <svg
      class="absolute inset-0 w-full h-full opacity-[0.04] pointer-events-none"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <pattern
          id="wave-bookings-show"
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
      <rect width="100%" height="100%" fill="url(#wave-bookings-show)" />
    </svg>

    <div class="relative z-10">
      <div class="flex items-center gap-4 mb-8">
        <NuxtLink
          to="/students/bookings"
          class="text-zinc-400 hover:text-white transition-colors"
        >
          <Icon name="lucide:arrow-left" class="h-6 w-6" />
        </NuxtLink>
        <div>
          <h1 class="text-2xl sm:text-3xl font-bold text-white">
            {{ booking?.bookingType?.name || "Agendamento" }}
          </h1>
        </div>
      </div>

      <div
        v-if="isLoading"
        class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
      >
        <Icon name="lucide:loader-2" class="h-12 w-12 text-emerald-500 mx-auto mb-4 animate-spin" />
        <p class="text-zinc-400">Carregando...</p>
      </div>

      <div
        v-else-if="error"
        class="bg-zinc-800/80 rounded-2xl border border-red-500/20 text-center py-20"
      >
        <Icon name="lucide:alert-circle" class="h-12 w-12 text-red-500 mx-auto mb-4" />
        <h2 class="text-xl font-bold text-white mb-2">Erro ao carregar</h2>
        <p class="text-zinc-400">{{ error }}</p>
      </div>

      <div v-else-if="booking" class="space-y-4">
        <div class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-5 sm:p-6 space-y-5 relative">
          <div
            v-if="loadingAction"
            class="absolute inset-0 z-10 flex items-center justify-center rounded-2xl bg-zinc-900/80 backdrop-blur-sm"
          >
            <div class="text-center">
              <Icon name="lucide:loader-2" class="h-8 w-8 text-emerald-500 mx-auto mb-2 animate-spin" />
              <p class="text-sm text-zinc-400">Processando...</p>
            </div>
          </div>

          <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
              <div class="h-12 w-12 rounded-xl bg-emerald-500/15 flex items-center justify-center shrink-0">
                <Icon name="lucide:calendar-days" class="h-6 w-6 text-emerald-500" />
              </div>
              <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">
                  {{ booking.bookingType?.name || "Evento" }}
                </h2>
                <span
                  class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border"
                  :class="booking.isRegistered
                    ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30'
                    : 'bg-zinc-700/50 text-zinc-300 border-zinc-600'"
                >
                  {{ booking.isRegistered ? "Inscrito" : "Disponível" }}
                </span>
              </div>
            </div>
            <button
              class="shrink-0 px-4 py-2 text-sm font-semibold rounded-lg transition-colors"
              :class="booking.isRegistered
                ? 'bg-red-500/10 text-red-400 border border-red-500/30 hover:bg-red-500/20'
                : 'bg-emerald-500 text-white hover:bg-emerald-600'"
              :disabled="loadingAction"
              @click="openConfirmModal"
            >
              <Icon v-if="loadingAction" name="lucide:loader-2" class="h-4 w-4 animate-spin mx-auto" />
              <span v-else>{{ booking.isRegistered ? "Cancelar Inscrição" : "Inscrever-se" }}</span>
            </button>
          </div>

          <hr class="border-zinc-700/40" />

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Data</p>
              <p class="text-sm text-white">{{ formatDate(booking.startDate) }}</p>
            </div>
            <div>
              <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Horário</p>
              <p class="text-sm text-white">{{ formatTime(booking.startDate) }} às {{ formatTime(booking.endDate) }}</p>
            </div>
            <div>
              <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Local</p>
              <p class="text-sm text-white">{{ booking.fullAddresses || "Não informado" }}</p>
            </div>
            <div>
              <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Vagas</p>
              <p class="text-sm text-white">{{ booking.bookedCount }} / {{ booking.vacancies }}</p>
            </div>
          </div>

          <div v-if="booking.description">
            <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Descrição</p>
            <p class="text-sm text-zinc-300">{{ booking.description }}</p>
          </div>
        </div>

        <div v-if="booking.bookingStudents?.length" class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-5 sm:p-6">
          <h3 class="text-sm font-semibold text-white mb-3">Participantes ({{ booking.bookingStudents.length }})</h3>
          <div class="space-y-2">
            <div
              v-for="bs in booking.bookingStudents"
              :key="bs.id"
              class="flex items-center gap-3 py-2 border-b border-zinc-700/40 last:border-0"
            >
              <div class="h-8 w-8 rounded-full bg-zinc-700/60 flex items-center justify-center text-xs font-bold text-zinc-400">
                {{ bs.student?.name?.charAt(0) || "?" }}
              </div>
              <p class="text-sm text-zinc-300">{{ bs.student?.name || "Aluno" }}</p>
            </div>
          </div>
        </div>
      </div>

      <AppModal
        :open="showModal"
        :title="booking?.isRegistered ? 'Cancelar Inscrição' : 'Confirmar Inscrição'"
        :description="booking?.isRegistered
          ? `Deseja cancelar sua inscrição no evento ${booking?.bookingType?.name || ''}?`
          : `Deseja se inscrever no evento ${booking?.bookingType?.name || ''}?`"
        :confirm-label="booking?.isRegistered ? 'Cancelar Inscrição' : 'Inscrever-se'"
        :variant="booking?.isRegistered ? 'danger' : 'primary'"
        :loading="loadingAction"
        @confirm="handleConfirm"
        @cancel="closeConfirmModal"
      />
    </div>
  </div>
</template>
