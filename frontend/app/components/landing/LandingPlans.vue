<script setup lang="ts">
import type { LandingPlan } from "~/interfaces/landing-data";

const plansFromApi = inject<Ref<LandingPlan[]>>("landingPlans", ref([]));

const featureSets: Record<string, { text: string; included: boolean }[]> = {
  Básico: [
    { text: "Acesso à musculação", included: true },
    { text: "Acesso ao cardio", included: true },
    { text: "Avaliação física inicial", included: true },
    { text: "Ficha de treino", included: true },
    { text: "Aulas em grupo", included: false },
    { text: "Personal trainer", included: false },
    { text: "Acesso 24h", included: false },
  ],
  Pro: [
    { text: "Acesso à musculação", included: true },
    { text: "Acesso ao cardio", included: true },
    { text: "Avaliação física mensal", included: true },
    { text: "Ficha de treino personalizada", included: true },
    { text: "Aulas em grupo ilimitadas", included: true },
    { text: "Personal trainer (2x/semana)", included: true },
    { text: "Acesso 24h", included: false },
  ],
  Elite: [
    { text: "Tudo do plano Pro", included: true },
    { text: "Personal trainer ilimitado", included: true },
    { text: "Nutricionista parceiro", included: true },
    { text: "Acesso 24h", included: true },
    { text: "Sauna e spa", included: true },
    { text: "Área VIP exclusiva", included: true },
    { text: "Bebidas e suplementos", included: true },
  ],
};

const selectedPlan = inject<Ref<string>>("selectedPlan", ref(""));

function selectPlan(planName: string): void {
  selectedPlan.value = planName;
  document.getElementById("contato")?.scrollIntoView({ behavior: "smooth" });
}

const plans = computed(() => {
  const apiPlans = plansFromApi.value;
  if (apiPlans.length === 0) {
    return [];
  }
  return apiPlans.map((plan, index) => {
    const features = featureSets[plan.name] ?? [];
    return {
      name: plan.name,
      price: plan.amountBase ?? 0,
      periodLabel:
        plan.periodDays === 30
          ? "Mensal"
          : plan.periodDays
            ? `A cada ${plan.periodDays} dias`
            : "Mensal",
      description: plan.description || `Plano ${plan.name}`,
      features,
      cta: `Assinar ${plan.name}`,
      popular: index === 1,
      gradient:
        index === 1
          ? "from-emerald-500/20 to-emerald-700/20"
          : "from-zinc-800 to-zinc-900",
      border:
        index === 1
          ? "border-emerald-500/50 hover:border-emerald-500"
          : "border-zinc-700/50 hover:border-zinc-600",
    };
  });
});
</script>

<template>
  <section id="planos" class="relative py-24 pb-12 sm:pb-24 overflow-hidden">
    <div
      class="absolute inset-0 bg-gradient-to-b from-gray-950 via-zinc-900/50 to-gray-950"
    />

    <div class="relative z-10 max-w-7xl mx-auto px-6">
      <div class="text-center mb-16">
        <div
          class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium mb-6"
        >
          <Icon name="lucide:badge-dollar-sign" class="w-4 h-4" />
          Planos & Preços
        </div>
        <h2 class="text-4xl lg:text-5xl font-black text-white mb-4">
          Invista no seu
          <span
            class="bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent"
            >melhor eu</span
          >
        </h2>
        <p class="text-zinc-400 text-xl max-w-2xl mx-auto">
          Planos flexíveis para todos os perfis. Sem taxas de adesão e com a
          primeira semana grátis.
        </p>
      </div>

      <div class="grid md:grid-cols-3 gap-6 items-stretch">
        <div
          v-for="plan in plans"
          :key="plan.name"
          class="relative rounded-3xl border bg-gradient-to-br p-4 sm:p-8 flex flex-col transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
          :class="[
            plan.gradient,
            plan.border,
            plan.popular
              ? 'hover:shadow-emerald-500/20 scale-[1.02]'
              : 'hover:shadow-black/40',
          ]"
        >
          <div
            v-if="plan.popular"
            class="absolute -top-4 left-1/2 -translate-x-1/2"
          >
            <span
              class="px-6 py-2 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-700 text-white text-sm font-bold shadow-lg shadow-emerald-500/40 whitespace-nowrap"
            >
              ⭐ Mais popular
            </span>
          </div>

          <div class="mb-6">
            <h3 class="text-2xl font-black text-white mb-1">{{ plan.name }}</h3>
            <p class="text-zinc-400 text-sm">{{ plan.description }}</p>
          </div>

          <div class="mb-8">
            <div class="flex items-baseline gap-1">
              <span class="text-zinc-500 text-lg">R$</span>
              <span class="text-5xl font-black text-white">{{
                plan.price
              }}</span>
            </div>
            <p class="text-xs text-zinc-500 mt-1">{{ plan.periodLabel }}</p>
          </div>

          <ul class="space-y-3 mb-8 flex-1">
            <li
              v-for="feature in plan.features"
              :key="feature.text"
              class="flex items-center gap-3 text-sm"
              :class="feature.included ? 'text-zinc-200' : 'text-zinc-600'"
            >
              <div
                class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0"
                :class="feature.included ? 'bg-emerald-500/20' : 'bg-zinc-800'"
              >
                <Icon
                  :name="feature.included ? 'lucide:check' : 'lucide:x'"
                  class="w-3 h-3"
                  :class="
                    feature.included ? 'text-emerald-400' : 'text-zinc-600'
                  "
                />
              </div>
              {{ feature.text }}
            </li>
          </ul>

          <button
            @click="selectPlan(plan.name)"
            class="block w-full text-center py-4 rounded-2xl font-bold text-lg transition-all duration-300"
            :class="
              plan.popular
                ? 'bg-gradient-to-r from-emerald-500 to-emerald-700 text-white hover:shadow-xl hover:shadow-emerald-500/30 hover:scale-105'
                : 'border border-white/10 text-white hover:bg-white/10 hover:border-white/20'
            "
          >
            {{ plan.cta }}
          </button>
        </div>
      </div>

      <div
        class="mt-6 sm:mt-12 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-6 text-zinc-500 text-xs sm:text-sm"
      >
        <div class="flex items-center gap-2">
          <Icon name="lucide:shield-check" class="w-5 h-5 text-emerald-500" />
          <span>7 dias grátis, sem cartão</span>
        </div>
        <div class="flex items-center gap-2">
          <Icon name="lucide:credit-card" class="w-5 h-5 text-emerald-500" />
          <span>Cancele quando quiser</span>
        </div>
        <div class="flex items-center gap-2">
          <Icon name="lucide:lock" class="w-5 h-5 text-emerald-500" />
          <span>Pagamento 100% seguro</span>
        </div>
      </div>
    </div>
  </section>
</template>
