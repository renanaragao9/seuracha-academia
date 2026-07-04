<script setup lang="ts">
import type { MealPlanFood } from "~/interfaces/meal-plan";

definePageMeta({
  middleware: ["auth"],
});

const route = useRoute();
const planId = Number(route.query.id);

const mealPlanStore = useMealPlanStore();

const expandedMeals = ref<Set<number>>(new Set());

const plan = computed(() => mealPlanStore.currentItem);
const isLoading = computed(() => mealPlanStore.isLoading);
const error = computed(() => mealPlanStore.error);
const downloadingPdf = computed(() => mealPlanStore.isDownloadingPdf);

watch(plan, (newPlan) => {
  if (newPlan?.meals) {
    expandedMeals.value = new Set(newPlan.meals.map((m) => m.id));
  }
});

onMounted(() => {
  mealPlanStore.loadItem(planId);
});

const formatDate = (dateStr: string | null): string => {
  return brDate(dateStr);
};

const downloadPdf = (): void => {
  if (mealPlanStore.currentItem) {
    mealPlanStore.downloadPdf(mealPlanStore.currentItem.id);
  }
};

function toggleMeal(mealId: number): void {
  if (expandedMeals.value.has(mealId)) {
    expandedMeals.value.delete(mealId);
  } else {
    expandedMeals.value.add(mealId);
  }
}

function foodPortion(food: MealPlanFood): string {
  if (!food.quantity && !food.unit) return "Qtd. não informada";
  if (!food.quantity) return food.unit ?? "Qtd. não informada";
  if (!food.unit) return String(food.quantity);
  return `${food.quantity} ${food.unit}`;
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
          id="wave-mealplan-show"
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
      <rect width="100%" height="100%" fill="url(#wave-mealplan-show)" />
    </svg>

    <div class="relative z-10">
      <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8">
        <div class="flex items-center gap-4 flex-1 min-w-0">
          <NuxtLink
            to="/students/meal-plans"
            class="text-zinc-400 hover:text-white transition-colors shrink-0"
          >
            <Icon name="lucide:arrow-left" class="h-6 w-6" />
          </NuxtLink>
          <div class="flex-1 min-w-0">
            <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">
              {{ plan?.name || "Plano Alimentar" }}
            </h1>
            <p class="text-sm sm:text-base text-zinc-400">
              <template v-if="plan?.startDate">
                De {{ formatDate(plan.startDate) }}
                <template v-if="plan.endDate">
                  <br />Até {{ formatDate(plan.endDate) }}
                </template>
              </template>
            </p>
          </div>
        </div>
        <button
          v-if="plan"
          class="w-full sm:w-auto px-4 py-2 rounded-lg text-sm font-semibold bg-red-600 hover:bg-red-700 text-white transition-colors flex items-center justify-center gap-2"
          @click="downloadPdf"
          :disabled="downloadingPdf"
        >
          <Icon
            :name="downloadingPdf ? 'lucide:loader-2' : 'lucide:file-down'"
            :class="downloadingPdf ? 'animate-spin' : ''"
            class="h-4 w-4"
          />
          Plano Alimentar em PDF
        </button>
      </div>
    </div>

    <div
      v-if="isLoading"
      class="bg-zinc-800/80 rounded-2xl border border-white/5 text-center py-20"
    >
      <Icon
        name="lucide:loader-2"
        class="h-12 w-12 text-emerald-500 mx-auto mb-4 animate-spin"
      />
      <p class="text-zinc-400">Carregando plano alimentar...</p>
    </div>

    <div
      v-else-if="error"
      class="bg-zinc-800/80 rounded-2xl border border-red-500/20 text-center py-20"
    >
      <Icon
        name="lucide:alert-circle"
        class="h-12 w-12 text-red-500 mx-auto mb-4"
      />
      <h2 class="text-xl font-bold text-white mb-2">Erro ao carregar</h2>
      <p class="text-zinc-400">{{ error }}</p>
    </div>

    <div v-else-if="plan" class="space-y-4">
      <div
        v-for="meal in plan.meals"
        :key="meal.id"
        class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 overflow-hidden"
      >
        <button
          class="w-full px-4 sm:px-6 py-4 flex items-center justify-between gap-3 text-left"
          @click="toggleMeal(meal.id)"
        >
          <div class="flex items-center gap-3 min-w-0">
            <div
              class="h-10 w-10 rounded-xl bg-emerald-500/15 flex items-center justify-center shrink-0 text-emerald-400 font-semibold text-sm"
            >
              {{ meal.order }}
            </div>
            <div class="min-w-0">
              <p class="text-white font-semibold truncate">
                {{ meal.mealType.name }}
              </p>
              <p class="text-xs text-zinc-400">
                {{ meal.foods.length }}
                {{ meal.foods.length === 1 ? "alimento" : "alimentos" }}
              </p>
            </div>
          </div>
          <Icon
            :name="
              expandedMeals.has(meal.id)
                ? 'lucide:chevron-up'
                : 'lucide:chevron-down'
            "
            class="h-5 w-5 text-zinc-400"
          />
        </button>

        <div
          v-if="expandedMeals.has(meal.id)"
          class="border-t border-zinc-700/60"
        >
          <div
            v-for="food in meal.foods"
            :key="food.id"
            class="px-4 sm:px-6 py-4 border-b border-zinc-700/40 last:border-b-0"
          >
            <div class="flex items-start justify-between gap-4">
              <div class="min-w-0">
                <p class="text-white font-medium truncate">
                  {{ food.food.name }}
                </p>
                <p class="text-sm text-zinc-400">{{ foodPortion(food) }}</p>
                <p v-if="food.observation" class="text-xs text-zinc-500 mt-1">
                  {{ food.observation }}
                </p>
              </div>
              <span class="text-xs text-zinc-500">#{{ food.order }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
