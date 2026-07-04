<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const postStore = usePostStore();

onMounted(async () => {
  await postStore.loadItems();
});

function openPost(id: number): void {
  navigateTo(`/students/posts/show?id=${id}`);
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
          id="wave-posts"
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
      <rect width="100%" height="100%" fill="url(#wave-posts)" />
    </svg>

    <div class="flex items-center gap-4 mb-8 relative z-10">
      <NuxtLink
        to="/students"
        class="text-zinc-400 hover:text-white transition-colors"
      >
        <Icon name="lucide:arrow-left" class="h-6 w-6" />
      </NuxtLink>
      <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-white">Postagens</h1>
        <p class="text-sm sm:text-base text-zinc-400">
          Fique por dentro das novidades da academia
        </p>
      </div>
    </div>

    <div
      v-if="postStore.isLoading"
      class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
    >
      <Icon
        name="lucide:loader-2"
        class="h-12 w-12 text-emerald-500 mx-auto mb-4 animate-spin"
      />
      <p class="text-zinc-400">Carregando postagens...</p>
    </div>

    <div
      v-else-if="postStore.error"
      class="bg-zinc-800/80 rounded-2xl border border-red-500/20 text-center py-20"
    >
      <Icon
        name="lucide:alert-circle"
        class="h-12 w-12 text-red-500 mx-auto mb-4"
      />
      <h2 class="text-xl font-bold text-white mb-2">Erro ao carregar</h2>
      <p class="text-zinc-400">{{ postStore.error }}</p>
    </div>

    <div
      v-else-if="postStore.items.length === 0"
      class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
    >
      <Icon
        name="lucide:newspaper"
        class="h-16 w-16 text-emerald-500 mx-auto mb-4"
      />
      <h2 class="text-xl font-bold text-white mb-2">
        Nenhuma postagem encontrada
      </h2>
      <p class="text-zinc-400">
        Ainda não há postagens disponíveis no momento.
      </p>
    </div>

    <div
      v-else
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"
    >
      <button
        v-for="post in postStore.items"
        :key="post.id"
        class="w-full text-left bg-zinc-800/80 border border-emerald-500/10 hover:border-emerald-500/30 rounded-2xl overflow-hidden hover:shadow-xl md:hover:scale-[1.02] transition-all cursor-pointer"
        @click="openPost(post.id)"
      >
        <div class="aspect-video bg-zinc-700/50 relative overflow-hidden">
          <img
            v-if="post.imageUrl"
            :src="post.imageUrl"
            :alt="post.title"
            class="w-full h-full object-cover"
          />
          <Icon
            v-else
            name="lucide:image"
            class="h-12 w-12 text-zinc-600 absolute inset-0 m-auto"
          />
        </div>
        <div class="p-5">
          <div v-if="post.postType" class="mb-2">
            <span
              class="inline-block text-[10px] font-semibold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded"
            >
              {{ post.postType.name }}
            </span>
          </div>
          <h3 class="text-lg font-bold text-white mb-1 line-clamp-2">
            {{ post.title }}
          </h3>
          <p class="text-sm text-zinc-400 line-clamp-2 [&_p]:inline [&_br]:hidden" v-html="post.description" />
          <div class="flex items-center justify-between mt-4">
            <span class="text-xs text-zinc-500">
              {{ post.createdAt ? timeAgo(post.createdAt) : "" }}
            </span>
            <Icon
              name="lucide:chevron-right"
              class="h-5 w-5 text-zinc-600 shrink-0"
            />
          </div>
        </div>
      </button>
    </div>
  </div>
</template>
