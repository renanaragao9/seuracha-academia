<script setup lang="ts">
import { login } from "~/services/auth";
import { fetchLandingData } from "~/services/landingService";
import type { LoginPayload } from "~/interfaces/auth";

type ContactMethod = "email" | "phone";

definePageMeta({
  layout: false,
  middleware: ["guest"],
});

const {
  public: { apiBase },
} = useRuntimeConfig();

const auth = useAuthStore();

const { data: academyName } = await useAsyncData("login-academy-name", () =>
  fetchLandingData(apiBase)
    .then((res) => res?.configuration?.name ?? "Academia")
    .catch(() => "Academia"),
);

useSeoMeta({
  title: () => `${academyName.value} — Entrar`,
  description: () => `Acesse sua conta na ${academyName.value}.`,
  robots: "noindex, nofollow",
});

const formData = reactive({
  contactMethod: "email" as ContactMethod,
  email: "",
  phone: "",
  password: "",
});

const showPassword = ref<boolean>(false);
const isLoading = ref<boolean>(false);
const errorMessage = ref<string>("");

async function handleSubmit(): Promise<void> {
  try {
    isLoading.value = true;
    errorMessage.value = "";

    const payload: LoginPayload = { password: formData.password };
    if (formData.contactMethod === "email") {
      payload.email = formData.email;
    } else {
      payload.phone = formData.phone;
    }

    const data = await login(apiBase, payload);

    if (data) {
      auth.setAuth(data.user, data.token);
      navigateTo("/students");
    } else {
      errorMessage.value = "Email ou senha inválidos.";
    }
  } catch {
    errorMessage.value =
      "Não foi possível autenticar. Verifique seus dados e senha.";
  } finally {
    isLoading.value = false;
  }
}
</script>

<template>
  <div
    class="min-h-screen flex items-start sm:items-center justify-center bg-gray-950 pt-16 sm:pt-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden"
  >
    <svg
      class="absolute inset-0 w-full h-full opacity-[0.04] pointer-events-none"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <pattern
          id="wave-pattern"
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
      <rect width="100%" height="100%" fill="url(#wave-pattern)" />
    </svg>
    <div class="w-full max-w-md space-y-8 relative z-10">
      <div class="text-center">
        <div
          class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-500/15"
        >
          <Icon name="lucide:dumbbell" class="h-8 w-8 text-emerald-500" />
        </div>
        <h1 class="text-2xl font-black text-white">{{ academyName }}</h1>
        <p class="mt-1 text-sm text-zinc-500">Acesse sua conta</p>
        <p class="mt-4 text-sm text-zinc-400">
          Ou
          <NuxtLink
            to="/"
            class="font-medium text-emerald-500 hover:text-emerald-400 transition-colors"
          >
            volte para a página inicial
          </NuxtLink>
        </p>
      </div>

      <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0 -translate-y-1"
        leave-active-class="transition duration-150 ease-in"
        leave-to-class="opacity-0 -translate-y-1"
      >
        <div
          v-if="errorMessage"
          class="flex items-start gap-3 rounded-xl border border-red-500/30 bg-red-500/10 p-4"
        >
          <Icon
            name="lucide:alert-circle"
            class="mt-0.5 h-4 w-4 shrink-0 text-red-400"
          />
          <p class="text-sm text-red-400">{{ errorMessage }}</p>
        </div>
      </Transition>

      <form
        class="rounded-2xl border border-white/10 bg-zinc-800/50 p-4 sm:p-8 space-y-6"
        @submit.prevent="handleSubmit"
      >
        <div>
          <p class="block text-sm font-medium text-zinc-300 mb-2">
            Identificar via
          </p>
          <div class="flex rounded-xl border border-zinc-700 bg-zinc-900 p-1">
            <button
              type="button"
              :class="[
                'flex-1 rounded-lg py-2 text-sm font-medium transition-all',
                formData.contactMethod === 'email'
                  ? 'bg-gradient-to-r from-emerald-500 to-emerald-700 text-white shadow'
                  : 'text-zinc-400 hover:text-white',
              ]"
              @click="formData.contactMethod = 'email'"
            >
              E-mail
            </button>
            <button
              type="button"
              :class="[
                'flex-1 rounded-lg py-2 text-sm font-medium transition-all',
                formData.contactMethod === 'phone'
                  ? 'bg-gradient-to-r from-emerald-500 to-emerald-700 text-white shadow'
                  : 'text-zinc-400 hover:text-white',
              ]"
              @click="formData.contactMethod = 'phone'"
            >
              Telefone
            </button>
          </div>
        </div>

        <div v-if="formData.contactMethod === 'email'">
          <label
            for="email"
            class="block text-sm font-medium text-zinc-300 mb-1.5"
          >
            E-mail
          </label>
          <input
            id="email"
            v-model="formData.email"
            type="email"
            autocomplete="email"
            required
            class="w-full rounded-xl border border-zinc-700 bg-zinc-900 px-4 py-3 text-white placeholder-zinc-600 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500/50 transition-colors"
            placeholder="seu@email.com"
          />
        </div>

        <div v-else>
          <label
            for="phone"
            class="block text-sm font-medium text-zinc-300 mb-1.5"
          >
            Telefone
          </label>
          <input
            id="phone"
            :value="formData.phone"
            type="tel"
            autocomplete="tel"
            required
            class="w-full rounded-xl border border-zinc-700 bg-zinc-900 px-4 py-3 text-white placeholder-zinc-600 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500/50 transition-colors"
            placeholder="(11) 98765-4321"
            @input="formData.phone = phoneMask($event)"
            @keydown="preventNonDigit"
          />
        </div>

        <div>
          <label
            for="password"
            class="block text-sm font-medium text-zinc-300 mb-1.5"
          >
            Senha
          </label>
          <div class="relative">
            <input
              id="password"
              v-model="formData.password"
              :type="showPassword ? 'text' : 'password'"
              autocomplete="current-password"
              required
              class="w-full rounded-xl border border-zinc-700 bg-zinc-900 pr-12 pl-4 py-3 text-white placeholder-zinc-600 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500/50 transition-colors"
              placeholder="Sua senha"
            />
            <button
              type="button"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-200 transition-colors"
              @click="showPassword = !showPassword"
            >
              <Icon
                :name="showPassword ? 'lucide:eye-off' : 'lucide:eye'"
                class="h-5 w-5"
              />
            </button>
          </div>
        </div>

        <button
          type="submit"
          :disabled="isLoading"
          class="group w-full flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-emerald-700 py-3 px-4 text-sm font-semibold text-white hover:shadow-xl hover:shadow-emerald-500/30 hover:scale-[1.02] transition-all duration-300 disabled:opacity-60 disabled:scale-100 disabled:cursor-not-allowed"
        >
          <Icon
            v-if="isLoading"
            name="lucide:loader-2"
            class="h-4 w-4 animate-spin"
          />
          <span>{{ isLoading ? "Autenticando..." : "Entrar" }}</span>
        </button>
      </form>
    </div>
  </div>
</template>
