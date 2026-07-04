<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const route = useRoute();

const itemStore = useItemStore();
const { currentItem: item, isLoading, error } = storeToRefs(itemStore);

const itemId = computed(() => Number(route.query.id));

onMounted(() => {
  itemStore.loadItem(itemId.value);
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
          id="wave-item-show"
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
      <rect width="100%" height="100%" fill="url(#wave-item-show)" />
    </svg>

    <div class="relative z-10">
      <div class="flex items-center gap-4 mb-8">
        <NuxtLink
          to="/students/items"
          class="text-zinc-400 hover:text-white transition-colors"
        >
          <Icon name="lucide:arrow-left" class="h-6 w-6" />
        </NuxtLink>
        <div>
          <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">
            {{ item?.name || "Produto" }}
          </h1>
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
        <p class="text-zinc-400">Carregando produto...</p>
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

      <div v-else-if="item" class="max-w-3xl mx-auto space-y-6">
        <div
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 overflow-hidden"
        >
          <img
            v-if="item.imageUrl"
            :src="item.imageUrl"
            :alt="item.name"
            class="w-full aspect-video object-cover"
          />
          <div
            v-else
            class="w-full aspect-video bg-zinc-700/50 flex items-center justify-center"
          >
            <Icon
              name="lucide:image"
              class="h-16 w-16 text-zinc-600"
            />
          </div>

          <div class="p-6 sm:p-8 space-y-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-white">
              {{ item.name }}
            </h2>

            <div class="flex flex-wrap items-center gap-3">
              <span
                v-if="item.itemType"
                class="inline-block text-xs font-semibold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded"
              >
                {{ item.itemType.name }}
              </span>
            </div>

            <p
              v-if="item.description"
              class="text-zinc-300 text-sm sm:text-base leading-relaxed"
            >
              {{ item.description }}
            </p>

            <div
              v-if="item.fields && item.fields.length > 0"
              class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-zinc-700/50"
            >
              <div
                v-for="field in item.fields"
                :key="field.id"
                class="bg-zinc-700/30 rounded-xl px-4 py-3"
              >
                <span
                  v-if="field.fieldType"
                  class="block text-xs text-zinc-500 uppercase tracking-wider mb-1"
                >
                  {{ field.fieldType.name }}
                </span>
                <span class="block text-sm text-white">
                  {{ field.value }}
                </span>
              </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-zinc-700/50">
              <span
                v-if="item.promotionPrice"
                class="text-3xl font-bold text-emerald-400"
              >
                R$ {{ item.promotionPrice }}
              </span>
              <span
                :class="[
                  'text-3xl font-bold',
                  item.promotionPrice ? 'text-zinc-500 line-through' : 'text-white',
                ]"
              >
                R$ {{ item.totalPrice }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
