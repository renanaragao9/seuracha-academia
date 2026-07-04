<script setup lang="ts">
const configuration = useConfigurationStore();

if (!configuration.config) {
  configuration.loadConfig();
}

const academyName = computed(() => configuration.config?.name ?? "Academia");
const logoUrl = computed(() => configuration.config?.branding?.logoUrl ?? null);
</script>

<template>
  <footer class="border-t border-zinc-800 bg-zinc-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
      <div class="flex items-center justify-center gap-2 mb-2">
        <img
          v-if="logoUrl"
          :src="logoUrl"
          :alt="academyName"
          class="w-6 h-6 rounded object-contain"
        />
        <div
          v-else
          class="w-6 h-6 rounded-lg bg-emerald-500/15 flex items-center justify-center"
        >
          <Icon name="lucide:dumbbell" class="w-3.5 h-3.5 text-emerald-500" />
        </div>
        <span class="text-sm text-zinc-400 font-semibold">{{ academyName }}</span>
      </div>
      <p class="text-center text-sm text-zinc-600">
        &copy; {{ new Date().getFullYear() }} {{ academyName }}. Todos os direitos reservados.
      </p>
      <p class="text-center text-xs text-zinc-600 mt-2">
        Desenvolvido por <span class="text-emerald-400 font-semibold">SeuRacha</span> — Renan da Silva Aragão
      </p>
    </div>
  </footer>
</template>
