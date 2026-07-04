<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const route = useRoute();
const feeId = Number(route.query.id);

const monthlyFeeStore = useMonthlyFeeStore();

const fee = computed(() => monthlyFeeStore.currentItem);
const isLoading = computed(() => monthlyFeeStore.isLoading);
const error = computed(() => monthlyFeeStore.error);
const downloadingPdf = computed(() => monthlyFeeStore.isDownloadingPdf);

onMounted(() => {
  monthlyFeeStore.loadItem(feeId);
});

const formatDate = (dateStr: string | null): string => {
  return brDateShort(dateStr);
};

const downloadPdf = (): void => {
  if (monthlyFeeStore.currentItem) {
    monthlyFeeStore.downloadPdf(monthlyFeeStore.currentItem.id);
  }
};

function currency(value: number | string | null): string {
  const numeric = Number(value ?? 0);
  return new Intl.NumberFormat("pt-BR", {
    style: "currency",
    currency: "BRL",
  }).format(numeric);
}
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
          id="wave-fees-show"
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
      <rect width="100%" height="100%" fill="url(#wave-fees-show)" />
    </svg>

    <div class="relative z-10">
      <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8">
        <div class="flex items-center gap-4 flex-1 min-w-0">
          <NuxtLink
            to="/students/monthly-fees"
            class="text-zinc-400 hover:text-white transition-colors shrink-0"
          >
            <Icon name="lucide:arrow-left" class="h-6 w-6" />
          </NuxtLink>
          <div class="flex-1 min-w-0">
            <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">
              {{ fee?.planType?.name || "Mensalidade" }}
            </h1>
            <p class="text-sm sm:text-base text-zinc-400">
              <template v-if="fee">
                De {{ brDate(fee.startDate) }} <br />Até
                {{ brDate(fee.endDate) }}
              </template>
            </p>
          </div>
        </div>
        <button
          v-if="fee"
          class="w-full sm:w-auto px-4 py-2 rounded-lg text-sm font-semibold bg-red-600 hover:bg-red-700 text-white transition-colors flex items-center justify-center gap-2"
          @click="downloadPdf"
          :disabled="downloadingPdf"
        >
          <Icon
            :name="downloadingPdf ? 'lucide:loader-2' : 'lucide:file-down'"
            :class="downloadingPdf ? 'animate-spin' : ''"
            class="h-4 w-4"
          />
          Recibo em PDF
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
        <p class="text-zinc-400">Carregando mensalidade...</p>
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

      <div v-else-if="fee" class="space-y-4">
        <div
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-5 sm:p-6"
        >
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">
                Plano
              </p>
              <p class="text-white font-semibold">{{ fee.planType.name }}</p>
            </div>
            <div>
              <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">
                Forma de Pagamento
              </p>
              <p class="text-white font-semibold">{{ fee.paymentType?.name }}</p>
            </div>
            <div>
              <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">
                Período
              </p>
              <p class="text-white font-semibold">
                {{ formatDate(fee.startDate) }} — {{ formatDate(fee.endDate) }}
              </p>
            </div>
            <div>
              <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">
                Pagamento
              </p>
              <p class="text-white font-semibold">
                <template v-if="fee.datePayment">
                  {{ formatDate(fee.datePayment) }}
                </template>
                <template v-else>
                  <span class="text-amber-400">Pendente</span>
                </template>
              </p>
            </div>
          </div>

          <hr class="border-zinc-700/40 my-5" />

          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <p class="text-sm text-zinc-400">Valor Integral</p>
              <p class="text-sm text-white font-semibold">
                {{ currency(fee.fullPayment ?? null) }}
              </p>
            </div>
            <div
              v-if="Number(fee.discountPayment) > 0"
              class="flex items-center justify-between"
            >
              <p class="text-sm text-zinc-400">Desconto</p>
              <p class="text-sm text-emerald-400 font-semibold">
                -{{ currency(fee.discountPayment ?? null) }}
              </p>
            </div>
            <div
              class="border-t border-zinc-700/40 pt-3 flex items-center justify-between"
            >
              <p class="text-sm text-zinc-400">Valor Final</p>
              <p class="text-sm text-white font-semibold">
                {{ currency(fee.finalPayment) }}
              </p>
            </div>
            <div class="flex items-center justify-between">
              <p class="text-base text-white font-bold">Valor Pago</p>
              <p class="text-base text-emerald-400 font-bold">
                {{ currency(fee.amountPaid ?? fee.finalPayment) }}
              </p>
            </div>
            <div class="flex items-center justify-between pt-1">
              <span
                :class="[
                  'inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold border',
                  fee.datePayment
                    ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
                    : 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                ]"
              >
                {{ fee.datePayment ? "Pago" : "Pendente" }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
