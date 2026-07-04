<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const route = useRoute();

const itemStore = useItemStore();
const { items, itemTypes, isLoading, error } = storeToRefs(itemStore);

const selectedTypeId = ref<number | null>(null);
const selectedSort = ref<string | null>(null);
const selectedPromotion = ref<boolean>(false);

function openItem(id: number): void {
  navigateTo(`/students/items/show?id=${id}`);
}

async function fetchItems(): Promise<void> {
  const params: Record<string, string> = {};
  if (selectedTypeId.value) params.item_type_id = String(selectedTypeId.value);
  if (selectedSort.value) params.sort = selectedSort.value;
  if (selectedPromotion.value) params.promotion = "1";
  await itemStore.loadFilteredItems(params);
}

onMounted(() => {
  itemStore.loadItemsAndTypes();
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
          id="wave-items"
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
      <rect width="100%" height="100%" fill="url(#wave-items)" />
    </svg>

    <div class="flex items-center gap-4 mb-8 relative z-10">
      <NuxtLink
        to="/students"
        class="text-zinc-400 hover:text-white transition-colors"
      >
        <Icon name="lucide:arrow-left" class="h-6 w-6" />
      </NuxtLink>
      <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-white">Vitrine</h1>
        <p class="text-sm sm:text-base text-zinc-400">
          Produtos e serviços disponíveis na academia
        </p>
      </div>
    </div>

    <div
      class="relative z-10 flex flex-col sm:flex-row gap-3 mb-6"
    >
      <select
        v-model="selectedTypeId"
        class="bg-zinc-800/80 border border-zinc-700/50 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-500/50 transition-colors appearance-none cursor-pointer"
        @change="fetchItems"
      >
        <option :value="null">Todos os tipos</option>
        <option
          v-for="type in itemTypes"
          :key="type.id"
          :value="type.id"
        >
          {{ type.name }}
        </option>
      </select>

      <select
        v-model="selectedSort"
        class="bg-zinc-800/80 border border-zinc-700/50 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-500/50 transition-colors appearance-none cursor-pointer"
        @change="fetchItems"
      >
        <option :value="null">Mais recentes</option>
        <option value="price_asc">Menor preço</option>
        <option value="price_desc">Maior preço</option>
      </select>

      <button
        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all border"
        :class="selectedPromotion ? 'bg-emerald-500/15 border-emerald-500/50 text-emerald-400' : 'bg-zinc-800/80 border-zinc-700/50 text-zinc-400 hover:text-white'"
        @click="selectedPromotion = !selectedPromotion; fetchItems()"
      >
        <Icon name="lucide:tag" class="h-4 w-4" />
        Promoção
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
      <p class="text-zinc-400">Carregando produtos...</p>
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
      v-else-if="items.length === 0"
      class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
    >
      <Icon
        name="lucide:store"
        class="h-16 w-16 text-emerald-500 mx-auto mb-4"
      />
      <h2 class="text-xl font-bold text-white mb-2">
        Nenhum produto encontrado
      </h2>
      <p class="text-zinc-400">
        Ainda não há produtos disponíveis no momento.
      </p>
    </div>

    <div
      v-else
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"
    >
      <button
        v-for="item in items"
        :key="item.id"
        class="w-full text-left bg-zinc-800/80 border border-emerald-500/10 hover:border-emerald-500/30 rounded-2xl overflow-hidden hover:shadow-xl md:hover:scale-[1.02] transition-all cursor-pointer"
        @click="openItem(item.id)"
      >
        <div class="aspect-video bg-zinc-700/50 relative overflow-hidden">
          <img
            v-if="item.imageUrl"
            :src="item.imageUrl"
            :alt="item.name"
            class="w-full h-full object-cover"
          />
          <Icon
            v-else
            name="lucide:image"
            class="h-12 w-12 text-zinc-600 absolute inset-0 m-auto"
          />
        </div>
        <div class="p-5">
          <h3 class="text-lg font-bold text-white mb-1 line-clamp-2">
            {{ item.name }}
          </h3>
          <div v-if="item.itemType" class="mb-2">
            <span
              class="inline-block text-[10px] font-semibold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded"
            >
              {{ item.itemType.name }}
            </span>
          </div>
          <p v-if="item.description" class="text-sm text-zinc-400 line-clamp-2 mb-3">
            {{ item.description }}
          </p>
          <div class="flex items-center gap-2">
            <span
              v-if="item.promotionPrice"
              class="text-lg font-bold text-emerald-400"
            >
              R$ {{ item.promotionPrice }}
            </span>
            <span
              :class="[
                'text-lg font-bold',
                item.promotionPrice ? 'text-zinc-500 line-through text-sm' : 'text-white',
              ]"
            >
              R$ {{ item.totalPrice }}
            </span>
          </div>
        </div>
      </button>
    </div>
  </div>
</template>
