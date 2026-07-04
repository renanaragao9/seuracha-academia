<script setup lang="ts">
import type { AcademyConfig } from "~/interfaces/academy-config";
import type { LandingPlan } from "~/interfaces/landing-data";

const {
  public: { apiBase },
} = useRuntimeConfig();

const form = reactive({
  name: "",
  email: "",
  phone: "",
  plan: "",
  message: "",
});

const sending = ref<boolean>(false);
const sent = ref<boolean>(false);
const errorMessage = ref<string>("");

const config = inject<Ref<AcademyConfig | null>>("academyConfig");
const landingPlans = inject<Ref<LandingPlan[]>>("landingPlans", ref([]));
const selectedPlan = inject<Ref<string>>("selectedPlan", ref(""));

watch(selectedPlan, (planName) => {
  if (planName && landingPlans.value.length) {
    const plan = landingPlans.value.find(
      (p) => p.name.toLowerCase() === planName.toLowerCase()
    );
    if (plan) {
      form.plan = String(plan.id);
    }
  }
});

async function handleSubmit(): Promise<void> {
  sending.value = true;
  errorMessage.value = "";

  try {
    const body: Record<string, string> = {
      name: form.name,
      email: form.email,
    };
    if (form.phone) body.phone = form.phone;
    if (form.plan) body.plan_type_id = form.plan;
    if (form.message) body.message = form.message;

    await $fetch(`${apiBase}/v1/customer_registrations`, {
      method: "POST",
      body,
    });

    sent.value = true;
  } catch {
    errorMessage.value = "Não foi possível enviar. Tente novamente.";
  } finally {
    sending.value = false;
  }
}

const contactInfo = computed(() => [
  {
    icon: "lucide:map-pin",
    title: "Endereço",
    value: config?.value?.address?.full || "Endereço não disponível",
  },
  {
    icon: "lucide:phone",
    title: "Telefone",
    value: config?.value?.contact?.phone || "(00) 0000-0000",
  },
  {
    icon: "lucide:mail",
    title: "E-mail",
    value: config?.value?.contact?.email || "contato@academia.com.br",
  },
  {
    icon: "lucide:clock",
    title: "Horário",
    value: config?.value?.schedule?.openingHours || "Horários não disponíveis",
  },
]);

const socialLinks = computed(() => [
  {
    icon: "uil:instagram",
    label: "Instagram",
    url: config?.value?.social?.instagram
      ? `https://instagram.com/${config.value.social.instagram.replace("@", "")}`
      : "#",
  },
  {
    icon: "uil:facebook",
    label: "Facebook",
    url: config?.value?.social?.facebook
      ? `https://facebook.com/${config.value.social.facebook}`
      : "#",
  },
  {
    icon: "uil:youtube",
    label: "YouTube",
    url: config?.value?.social?.youtube
      ? `https://youtube.com/${config.value.social.youtube}`
      : "#",
  },
  {
    icon: "uil:whatsapp",
    label: "WhatsApp",
    url: config?.value?.contact?.whatsapp
      ? `https://wa.me/${config.value.contact.whatsapp.replace(/\D/g, "")}`
      : "#",
  },
]);

function formatPlanOption(plan: LandingPlan): string {
  const price = plan.amountBase
    ? `R$ ${Number(plan.amountBase).toFixed(2)}`
    : "Consultar";
  const period =
    plan.periodDays === 30
      ? "/mês"
      : plan.periodDays
        ? `/${plan.periodDays}d`
        : "";
  return `${plan.name} - ${price}${period}`;
}
</script>

<template>
  <section id="contato" class="relative py-12 sm:py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-gray-950 to-zinc-900" />
    <div
      class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_center,_rgba(16,185,129,0.1),_transparent_60%)]"
    />

    <div class="relative z-10 max-w-7xl mx-auto px-6">
      <div class="text-center mb-16">
        <div
          class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium mb-6"
        >
          <Icon name="lucide:send" class="w-4 h-4" />
          Contato
        </div>
        <h2 class="text-4xl lg:text-5xl font-black text-white mb-4">
          Pronto para
          <span
            class="bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent"
          >
            começar?</span
          >
        </h2>
        <p class="text-zinc-400 text-xl max-w-2xl mx-auto">
          Fale com a nossa equipe e garanta sua primeira semana grátis.
        </p>
      </div>

      <div class="grid lg:grid-cols-2 gap-6 sm:gap-12 w-full min-w-0">
        <div
          class="rounded-3xl border border-white/10 bg-zinc-900/60 backdrop-blur-sm p-4 sm:p-8 w-full min-w-0"
        >
          <Transition mode="out-in" name="fade">
            <div
              v-if="sent"
              class="flex flex-col items-center justify-center py-12 text-center"
            >
              <div
                class="w-20 h-20 rounded-full bg-emerald-500/15 flex items-center justify-center mb-6"
              >
                <Icon name="lucide:check" class="w-10 h-10 text-emerald-500" />
              </div>
              <h3 class="text-2xl font-black text-white mb-2">
                Mensagem enviada!
              </h3>
              <p class="text-zinc-400">
                Nossa equipe entrará em contato em até 24 horas.
              </p>
              <button
                class="mt-6 text-emerald-500 hover:text-emerald-400 transition-colors text-sm font-medium"
                @click="
                  sent = false;
                  form.name = '';
                  form.email = '';
                  form.phone = '';
                  form.plan = '';
                  form.message = '';
                "
              >
                Enviar outra mensagem
              </button>
            </div>

            <form v-else class="space-y-5" @submit.prevent="handleSubmit">
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

              <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 sm:col-span-1">
                  <label class="block text-sm font-medium text-zinc-400 mb-2"
                    >Nome <span class="text-red-500">*</span></label
                  >
                  <input
                    v-model="form.name"
                    type="text"
                    required
                    placeholder="Seu nome completo"
                    class="w-full px-4 py-3 rounded-xl bg-zinc-800 border border-zinc-700 text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/50 transition-colors"
                  />
                </div>
                <div class="col-span-2 sm:col-span-1">
                  <label class="block text-sm font-medium text-zinc-400 mb-2"
                    >Telefone</label
                  >
                  <input
                    :value="form.phone"
                    type="tel"
                    placeholder="(11) 98765-4321"
                    class="w-full px-4 py-3 rounded-xl bg-zinc-800 border border-zinc-700 text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/50 transition-colors"
                    @input="form.phone = phoneMask($event)"
                    @keydown="preventNonDigit"
                  />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-zinc-400 mb-2"
                  >E-mail <span class="text-red-500">*</span></label
                >
                <input
                  v-model="form.email"
                  type="email"
                  required
                  placeholder="seu@email.com"
                  class="w-full px-4 py-3 rounded-xl bg-zinc-800 border border-zinc-700 text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/50 transition-colors"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-zinc-400 mb-2"
                  >Plano de interesse <span class="text-red-500">*</span></label
                >
                <select
                  v-model="form.plan"
                  required
                  class="w-full px-4 py-3 rounded-xl bg-zinc-800 border border-zinc-700 text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/50 transition-colors appearance-none cursor-pointer"
                >
                  <option value="" disabled selected class="text-zinc-600">
                    Selecione um plano
                  </option>
                  <option
                    v-for="plan in landingPlans"
                    :key="plan.id"
                    :value="plan.id"
                  >
                    {{ formatPlanOption(plan) }}
                  </option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-zinc-400 mb-2"
                  >Mensagem</label
                >
                <textarea
                  v-model="form.message"
                  rows="4"
                  placeholder="Como podemos ajudar?"
                  class="w-full px-4 py-3 rounded-xl bg-zinc-800 border border-zinc-700 text-white placeholder-zinc-600 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/50 transition-colors resize-none"
                />
              </div>

              <button
                type="submit"
                :disabled="sending"
                class="group w-full py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white font-bold text-lg hover:shadow-xl hover:shadow-emerald-500/30 hover:scale-[1.02] transition-all duration-300 disabled:opacity-60 disabled:scale-100 flex items-center justify-center gap-2"
              >
                <Icon
                  v-if="sending"
                  name="lucide:loader-2"
                  class="w-5 h-5 animate-spin"
                />
                <span>{{
                  sending ? "Enviando..." : "Quero começar agora"
                }}</span>
                <Icon
                  v-if="!sending"
                  name="lucide:arrow-right"
                  class="w-5 h-5 group-hover:translate-x-1 transition-transform"
                />
              </button>
            </form>
          </Transition>
        </div>

        <div class="space-y-6 w-full min-w-0">
          <div
            v-for="info in contactInfo"
            :key="info.title"
            class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl border border-white/5 bg-zinc-900/40 hover:border-emerald-500/20 transition-colors duration-300 w-full min-w-0 overflow-hidden"
          >
            <div
              class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-500/15 flex items-center justify-center flex-shrink-0"
            >
              <Icon
                :name="info.icon"
                class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-500"
              />
            </div>
            <div class="min-w-0 break-words">
              <div class="text-sm font-semibold text-zinc-400 mb-1">
                {{ info.title }}
              </div>
              <div class="text-white font-medium">{{ info.value }}</div>
            </div>
          </div>

          <div
            class="p-4 sm:p-5 rounded-2xl border border-white/5 bg-zinc-900/40 w-full min-w-0 overflow-hidden"
          >
            <div class="text-sm font-semibold text-zinc-400 mb-4">
              Siga-nos nas redes sociais
            </div>
            <div class="flex gap-3">
              <a
                v-for="social in socialLinks"
                :key="social.label"
                :href="social.url"
                target="_blank"
                rel="noopener noreferrer"
                :aria-label="social.label"
                class="w-10 h-10 rounded-xl bg-zinc-800 border border-zinc-700 flex items-center justify-center text-zinc-400 hover:bg-gradient-to-br hover:from-emerald-500 hover:to-emerald-700 hover:text-white hover:border-transparent transition-all duration-300"
              >
                <Icon :name="social.icon" class="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
