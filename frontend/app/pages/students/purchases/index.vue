<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const purchaseStore = usePurchaseStore();

const purchases = computed(() => purchaseStore.items);
const isLoading = computed(() => purchaseStore.isLoading);
const error = computed(() => purchaseStore.error);

onMounted(() => {
  purchaseStore.loadItems();
});

const formatDate = (dateStr: string | null): string => {
  return brDateShort(dateStr);
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

function openPurchase(id: number): void {
  navigateTo(`/students/purchases/show?id=${id}`);
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
          id="wave-purchases"
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
      <rect width="100%" height="100%" fill="url(#wave-purchases)" />
    </svg>

    <div class="flex items-center gap-4 mb-8 relative z-10">
      <NuxtLink
        to="/students"
        class="text-zinc-400 hover:text-white transition-colors"
      >
        <Icon name="lucide:arrow-left" class="h-6 w-6" />
      </NuxtLink>
      <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-white">Compras</h1>
        <p class="text-sm sm:text-base text-zinc-400">
          Histórico de compras na academia
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
      <p class="text-zinc-400">Carregando compras...</p>
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

    <div
      v-else-if="purchases.length === 0"
      class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
    >
      <Icon
        name="lucide:shopping-bag"
        class="h-16 w-16 text-emerald-500 mx-auto mb-4"
      />
      <h2 class="text-xl font-bold text-white mb-2">
        Nenhuma compra encontrada
      </h2>
      <p class="text-zinc-400">
        Você ainda não possui compras registradas.
      </p>
    </div>

    <div
      v-else
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"
    >
      <button
        v-for="purchase in purchases"
        :key="purchase.id"
        class="w-full text-left p-5 flex flex-col bg-zinc-800/80 border border-emerald-500/10 hover:border-emerald-500/30 rounded-2xl hover:shadow-xl md:hover:scale-[1.02] transition-all cursor-pointer"
        @click="openPurchase(purchase.id)"
      >
        <div class="flex items-center gap-3 mb-4">
          <div
            class="h-12 w-12 rounded-xl bg-emerald-500/15 flex items-center justify-center shrink-0"
          >
            <Icon name="lucide:shopping-bag" class="h-6 w-6 text-emerald-500" />
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-white font-bold truncate">Compra #{{ purchase.id }}</p>
            <p class="text-sm text-zinc-400 mt-0.5">
              {{ formatDate(purchase.dateSale) }}
            </p>
          </div>
          <Icon
            name="lucide:chevron-right"
            class="h-5 w-5 text-zinc-500 shrink-0 sm:hidden"
          />
        </div>

        <div class="flex items-center justify-between text-sm">
          <span class="text-white font-bold">
            {{ currency(purchase.totalAmount) }}
          </span>

          <span
            :class="[
              'inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold border',
              statusClass(purchase.status),
            ]"
          >
            {{ statusLabel(purchase.status) }}
          </span>
        </div>
      </button>
    </div>
  </div>
</template>
