<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const route = useRoute();
const purchaseId = Number(route.query.id);

const purchaseStore = usePurchaseStore();

const purchase = computed(() => purchaseStore.currentItem);
const isLoading = computed(() => purchaseStore.isLoading);
const error = computed(() => purchaseStore.error);

onMounted(() => {
  purchaseStore.loadItem(purchaseId);
});

const formatDate = (dateStr: string | null): string => {
  return brDate(dateStr);
};

function currency(value: number): string {
  return new Intl.NumberFormat("pt-BR", {
    style: "currency",
    currency: "BRL",
  }).format(Number(value));
}

function statusLabel(status: string | null): string {
  if (status === "paid") return "Pago";
  if (status === "open") return "Aberto";
  if (status === "canceled") return "Cancelado";
  return "Sem status";
}

function statusClass(status: string | null): string {
  if (status === "paid")
    return "bg-emerald-500/10 text-emerald-400 border-emerald-500/20";
  if (status === "open")
    return "bg-amber-500/10 text-amber-400 border-amber-500/20";
  if (status === "canceled")
    return "bg-red-500/10 text-red-400 border-red-500/20";
  return "bg-zinc-700/50 text-zinc-300 border-zinc-600";
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
          id="wave-purchases-show"
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
      <rect width="100%" height="100%" fill="url(#wave-purchases-show)" />
    </svg>

    <div class="relative z-10">
      <div class="flex items-center gap-4 mb-8">
        <NuxtLink
          to="/students/purchases"
          class="text-zinc-400 hover:text-white transition-colors"
        >
          <Icon name="lucide:arrow-left" class="h-6 w-6" />
        </NuxtLink>
        <div>
          <h1 class="text-2xl sm:text-3xl font-bold text-white">
            Compra #{{ purchase?.id }}
          </h1>
          <p class="text-sm sm:text-base text-zinc-400">
            {{ formatDate(purchase?.dateSale ?? null) }}
          </p>
        </div>
      </div>

      <div
        v-if="isLoading"
        class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
      >
        <Icon
          name="lucide:loader-2"
          class="h-12 w-12 text-emerald-500 mx-auto mb-4 animate-spin"
        />
        <p class="text-zinc-400">Carregando compra...</p>
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

      <div v-else-if="purchase" class="space-y-4">
        <div class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-5">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">
                Data
              </p>
              <p class="text-white font-semibold">
                {{ brDateShort(purchase.dateSale) }}
              </p>
            </div>
            <div>
              <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">
                Status
              </p>
              <span
                :class="[
                  'inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold border',
                  statusClass(purchase.status),
                ]"
              >
                {{ statusLabel(purchase.status) }}
              </span>
            </div>
          </div>
        </div>

        <div class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-5">
          <p class="text-xs text-zinc-500 uppercase tracking-wider mb-3">
            Itens
          </p>
          <div class="space-y-2">
            <div
              v-for="item in purchase.items"
              :key="item.id"
              class="bg-zinc-800/50 rounded-lg px-4 py-3"
            >
              <div
                class="flex items-center justify-between gap-2"
              >
                <p class="text-sm text-white font-medium">
                  {{ item.item.name }}
                </p>
                <p class="text-xs text-zinc-400">Qtd. {{ item.quantity }}</p>
              </div>
              <div class="flex gap-4 mt-1 text-xs text-zinc-400">
                <span>Unitário: {{ currency(item.unitPrice) }}</span>
                <span>Subtotal: {{ currency(item.subtotal) }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-5">
          <p class="text-xs text-zinc-500 uppercase tracking-wider mb-3">
            Valores
          </p>
          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <p class="text-sm text-zinc-400">Subtotal</p>
              <p class="text-sm text-white font-semibold">
                {{ currency(purchase.amountPrice) }}
              </p>
            </div>
            <div
              v-if="Number(purchase.discountAmount) > 0"
              class="flex items-center justify-between"
            >
              <p class="text-sm text-zinc-400">Desconto</p>
              <p class="text-sm text-emerald-400 font-semibold">
                -{{ currency(purchase.discountAmount) }}
              </p>
            </div>
            <div
              class="border-t border-zinc-700/40 pt-3 flex items-center justify-between"
            >
              <p class="text-base text-white font-bold">Total</p>
              <p class="text-base text-emerald-400 font-bold">
                {{ currency(purchase.totalAmount) }}
              </p>
            </div>
          </div>
        </div>

        <div
          v-if="purchase.observation"
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-5"
        >
          <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">
            Observação
          </p>
          <p class="text-sm text-zinc-300 italic">
            {{ purchase.observation }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
