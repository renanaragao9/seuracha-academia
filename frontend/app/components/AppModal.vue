<script setup lang="ts">
defineProps<{
  open: boolean;
  title: string;
  description?: string;
  confirmLabel?: string;
  cancelLabel?: string;
  variant?: "primary" | "danger";
  loading?: boolean;
}>();

const emit = defineEmits<{
  confirm: [];
  cancel: [];
}>();
</script>

<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="open"
        class="fixed inset-0 z-[9998] flex items-center justify-center p-4"
        @click.self="emit('cancel')"
      >
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" />

        <div
          class="relative w-full max-w-sm rounded-xl border border-zinc-700/50 bg-zinc-900 p-6 shadow-2xl"
        >
          <div class="flex items-start gap-4">
            <div
              class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full"
              :class="variant === 'danger' ? 'bg-red-500/10' : 'bg-emerald-500/10'"
            >
              <Icon
                :name="variant === 'danger' ? 'lucide:alert-triangle' : 'lucide:info'"
                class="h-5 w-5"
                :class="variant === 'danger' ? 'text-red-400' : 'text-emerald-400'"
              />
            </div>
            <div class="min-w-0 flex-1">
              <h3 class="text-base font-bold text-white">{{ title }}</h3>
              <p v-if="description" class="mt-1 text-sm text-zinc-400">
                {{ description }}
              </p>
            </div>
          </div>

          <div class="mt-6 flex items-center justify-end gap-2">
            <button
              class="rounded-lg border border-zinc-700 px-4 py-2 text-sm font-medium text-zinc-300 transition-colors hover:bg-zinc-800"
              @click="emit('cancel')"
            >
              {{ cancelLabel || "Voltar" }}
            </button>
            <button
              class="rounded-lg px-4 py-2 text-sm font-semibold text-white transition-colors"
              :class="variant === 'danger'
                ? 'bg-red-500 hover:bg-red-600'
                : 'bg-emerald-500 hover:bg-emerald-600'"
              :disabled="loading"
              @click="emit('confirm')"
            >
              <Icon
                v-if="loading"
                name="lucide:loader-2"
                class="h-4 w-4 animate-spin mx-auto"
              />
              <span v-else>{{ confirmLabel || "Confirmar" }}</span>
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.modal-enter-active {
  transition: all 0.2s ease-out;
}
.modal-leave-active {
  transition: all 0.15s ease-in;
}
.modal-enter-from {
  opacity: 0;
}
.modal-enter-from > div:last-child {
  transform: scale(0.95) translateY(10px);
}
.modal-leave-to {
  opacity: 0;
}
.modal-leave-to > div:last-child {
  transform: scale(0.95) translateY(10px);
}
</style>
