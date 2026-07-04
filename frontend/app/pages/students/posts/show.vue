<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const route = useRoute();
const postId = Number(route.query.id);

const postStore = usePostStore();

onMounted(async () => {
  await postStore.loadItem(postId);
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
          id="wave-post-show"
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
      <rect width="100%" height="100%" fill="url(#wave-post-show)" />
    </svg>

    <div class="relative z-10">
      <div class="flex items-center gap-4 mb-8">
        <NuxtLink
          to="/students/posts"
          class="text-zinc-400 hover:text-white transition-colors"
        >
          <Icon name="lucide:arrow-left" class="h-6 w-6" />
        </NuxtLink>
        <div class="min-w-0">
          <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">
            {{ postStore.currentItem?.title || "Postagem" }}
          </h1>
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
        <p class="text-zinc-400">Carregando postagem...</p>
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
        v-else-if="postStore.currentItem"
        class="max-w-3xl mx-auto space-y-6"
      >
        <div
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 overflow-hidden"
        >
          <img
            v-if="postStore.currentItem.imageUrl"
            :src="postStore.currentItem.imageUrl"
            :alt="postStore.currentItem.title"
            class="w-full aspect-video object-cover"
          />

          <div class="p-6 sm:p-8 space-y-6 overflow-hidden">
            <div class="flex flex-wrap items-center gap-3">
              <span
                v-if="postStore.currentItem.postType"
                class="inline-block text-xs font-semibold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded"
              >
                {{ postStore.currentItem.postType.name }}
              </span>
              <span
                v-if="postStore.currentItem.createdAt"
                class="text-xs text-zinc-500"
              >
                {{ timeAgo(postStore.currentItem.createdAt) }}
              </span>
              <span
                v-if="postStore.currentItem.user"
                class="text-xs text-zinc-500"
              >
                Por {{ postStore.currentItem.user.name }}
              </span>
            </div>

            <h2 class="text-2xl sm:text-3xl font-bold text-white break-words">
              {{ postStore.currentItem.title }}
            </h2>

            <div
              class="text-zinc-300 text-sm sm:text-base leading-relaxed space-y-3 [&_a]:text-emerald-400 [&_a:hover]:text-emerald-300 [&_strong]:text-white [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5 [&_li]:mb-1 [&_p]:leading-relaxed"
              v-html="postStore.currentItem.description"
            />

            <div
              v-if="
                postStore.currentItem.linkSite ||
                postStore.currentItem.linkVideo
              "
              class="flex gap-4 pt-4 border-t border-zinc-700/50"
            >
              <a
                v-if="postStore.currentItem.linkSite"
                :href="postStore.currentItem.linkSite"
                target="_blank"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-500/10 text-emerald-400 font-semibold hover:bg-emerald-500/20 transition-colors text-sm"
              >
                <Icon name="lucide:external-link" class="h-4 w-4" />
                Saiba mais
              </a>
              <a
                v-if="postStore.currentItem.linkVideo"
                :href="postStore.currentItem.linkVideo"
                target="_blank"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-500/10 text-blue-400 font-semibold hover:bg-blue-500/20 transition-colors text-sm"
              >
                <Icon name="lucide:video" class="h-4 w-4" />
                Assistir vídeo
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
