<script setup lang="ts">
const auth = useAuthStore();
const configuration = useConfigurationStore();

const user = computed(() => auth.user);
const logoUrl = computed(() => configuration.config?.branding?.logoUrl ?? null);

if (!configuration.config) {
  configuration.loadConfig();
}

const menuOpen = ref<boolean>(false);

const initials = computed(() => {
  const name = user.value?.name ?? "";
  return name
    .split(" ")
    .map((n) => n[0])
    .join("")
    .toUpperCase()
    .slice(0, 2);
});

function toggleMenu(): void {
  menuOpen.value = !menuOpen.value;
}

function closeMenu(): void {
  menuOpen.value = false;
}

function performLogout(): void {
  auth.performLogout();
}
</script>

<template>
  <header
    class="bg-zinc-900/80 backdrop-blur-md border-b border-zinc-800 sticky top-0 z-40"
  >
    <div
      class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between"
    >
      <NuxtLink to="/" class="flex items-center gap-3">
        <img
          v-if="logoUrl"
          :src="logoUrl"
          :alt="configuration.config?.name ?? 'Academia'"
          class="w-8 h-8 rounded-lg object-contain"
        />
        <div
          v-else
          class="w-8 h-8 rounded-lg bg-emerald-500/15 flex items-center justify-center"
        >
          <Icon name="lucide:dumbbell" class="w-4 h-4 text-emerald-500" />
        </div>
        <span class="text-lg font-bold text-white">
          <ClientOnly fallback="Academia">
            {{ configuration.config?.name ?? "Academia" }}
          </ClientOnly>
        </span>
      </NuxtLink>

      <div class="flex items-center gap-3">
        <span
          class="hidden sm:block text-sm font-medium text-zinc-300 truncate max-w-[160px]"
        >
          {{ user?.name ?? "" }}
        </span>
        <div class="relative">
          <button
            class="w-9 h-9 rounded-full overflow-hidden bg-emerald-500/15 flex items-center justify-center text-emerald-500 text-sm font-bold hover:scale-105 transition-transform"
            @click="toggleMenu"
          >
            <ClientOnly fallback="?">
              <img
                v-if="user?.imageUrl"
                :src="user.imageUrl"
                :alt="user.name"
                class="w-full h-full object-cover"
              />
              <span v-else>{{ initials }}</span>
            </ClientOnly>
          </button>

          <Transition name="dropdown">
            <div
              v-if="menuOpen"
              class="absolute right-0 top-full mt-2 w-48 rounded-xl border border-zinc-700 bg-zinc-900 shadow-xl overflow-hidden z-20"
            >
              <div class="px-4 py-3 border-b border-zinc-700">
                <p class="text-sm font-medium text-white truncate">
                  {{ user?.name ?? "" }}
                </p>
                <p class="text-xs text-zinc-400 truncate">
                  {{ user?.email ?? "" }}
                </p>
              </div>
              <button
                class="flex items-center gap-3 w-full px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 hover:text-white transition-colors"
                @click="navigateTo('/students/profile')"
              >
                <Icon name="lucide:user" class="h-4 w-4" />
                Meu Perfil
              </button>
              <button
                class="flex items-center gap-3 w-full px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 hover:text-white transition-colors"
                @click="navigateTo('/students/chat')"
              >
                <Icon name="lucide:bot" class="h-4 w-4" />
                Chat IA
              </button>
              <button
                class="flex items-center gap-3 w-full px-4 py-3 text-sm text-zinc-300 hover:bg-zinc-800 hover:text-white transition-colors"
                @click="performLogout"
              >
                <Icon name="lucide:log-out" class="h-4 w-4" />
                Sair
              </button>
            </div>
          </Transition>
        </div>
      </div>
    </div>
    <div v-if="menuOpen" class="fixed inset-0 z-10" @click="closeMenu"></div>
  </header>
</template>

<style scoped>
.dropdown-enter-active {
  transition:
    opacity 0.15s ease,
    transform 0.15s ease;
}

.dropdown-leave-active {
  transition:
    opacity 0.1s ease,
    transform 0.1s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-4px);
}
</style>
