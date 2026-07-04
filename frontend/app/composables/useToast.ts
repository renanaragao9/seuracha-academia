import type { Ref } from "vue";

export interface Toast {
  id: string;
  type: "success" | "error" | "info";
  title: string;
  message?: string;
  duration: number;
}

const toasts: Ref<Toast[]> = ref([]);

let counter = 0;

export function useToast() {
  function add(toast: Omit<Toast, "id">) {
    const id = `toast-${++counter}`;
    const entry: Toast = { ...toast, id, duration: toast.duration ?? 4000 };
    toasts.value.push(entry);

    setTimeout(() => remove(id), entry.duration);
  }

  function remove(id: string) {
    const idx = toasts.value.findIndex((t) => t.id === id);
    if (idx !== -1) toasts.value.splice(idx, 1);
  }

  function success(title: string, message?: string) {
    add({ type: "success", title, message, duration: 4000 });
  }

  function error(title: string, message?: string) {
    add({ type: "error", title, message, duration: 5000 });
  }

  function info(title: string, message?: string) {
    add({ type: "info", title, message, duration: 4000 });
  }

  return { toasts, add, remove, success, error, info };
}
