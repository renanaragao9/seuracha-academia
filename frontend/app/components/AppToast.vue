<script setup lang="ts">
import type { Toast } from "~/composables/useToast";

const { toasts, remove } = useToast();

const typeConfig: Record<Toast["type"], { icon: string; bg: string; border: string; bar: string }> = {
  success: {
    icon: "lucide:check-circle",
    bg: "bg-emerald-500/10",
    border: "border-emerald-500/30",
    bar: "bg-emerald-500",
  },
  error: {
    icon: "lucide:alert-circle",
    bg: "bg-red-500/10",
    border: "border-red-500/30",
    bar: "bg-red-500",
  },
  info: {
    icon: "lucide:info",
    bg: "bg-emerald-500/10",
    border: "border-emerald-500/30",
    bar: "bg-emerald-500",
  },
};
</script>

<template>
  <Teleport to="body">
    <div
      class="fixed top-4 right-4 z-[9999] flex flex-col gap-2 pointer-events-none"
    >
      <TransitionGroup name="toast" tag="div" class="flex flex-col gap-2">
        <div
          v-for="toast in toasts"
          :key="toast.id"
          class="pointer-events-auto w-80 rounded-xl border p-4 shadow-lg backdrop-blur-xl overflow-hidden"
          :class="[typeConfig[toast.type].bg, typeConfig[toast.type].border]"
        >
          <div class="flex items-start gap-3">
            <Icon
              :name="typeConfig[toast.type].icon"
              class="mt-0.5 h-5 w-5 shrink-0"
              :class="{
                'text-emerald-400': toast.type === 'success',
                'text-red-400': toast.type === 'error',
                'text-blue-400': toast.type === 'info',
              }"
            />
            <div class="min-w-0 flex-1">
              <p class="text-sm font-semibold text-white">{{ toast.title }}</p>
              <p v-if="toast.message" class="mt-0.5 text-xs text-zinc-400">
                {{ toast.message }}
              </p>
            </div>
            <button
              class="shrink-0 text-zinc-500 hover:text-white transition-colors"
              @click="remove(toast.id)"
            >
              <Icon name="lucide:x" class="h-4 w-4" />
            </button>
          </div>
          <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/10">
            <div
              class="h-full rounded-full toast-bar"
              :class="typeConfig[toast.type].bar"
              :style="{ animationDuration: `${toast.duration}ms` }"
            />
          </div>
        </div>
      </TransitionGroup>
    </div>
  </Teleport>
</template>

<style scoped>
.toast-enter-active {
  transition: all 0.3s ease-out;
}
.toast-leave-active {
  transition: all 0.2s ease-in;
}
.toast-enter-from {
  opacity: 0;
  transform: translateX(100%);
}
.toast-leave-to {
  opacity: 0;
  transform: translateX(100%);
}

.toast-bar {
  animation: toast-bar-shrink linear forwards;
}

@keyframes toast-bar-shrink {
  from {
    width: 100%;
  }
  to {
    width: 0%;
  }
}
</style>
