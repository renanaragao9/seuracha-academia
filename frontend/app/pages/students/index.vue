<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const auth = useAuthStore();
const configuration = useConfigurationStore();
const dashboardStore = useDashboardStore();
const { posts, bookingsCount, isLoading } = storeToRefs(dashboardStore);

const academyName = computed(() => configuration.config?.name ?? "Academia");

useHead({
  title: () => academyName.value,
});

const currentImageIndex = ref<number>(0);
const touchStartX = ref<number>(0);
const touchEndX = ref<number>(0);

const carouselSlides = computed(() =>
  posts.value.length > 0 ? posts.value : [],
);

const today = new Date();
const currentDay = today.getDay();

const weekDays = [
  { name: "Domingo", short: "Dom", value: 0 },
  { name: "Segunda-feira", short: "Seg", value: 1 },
  { name: "Terça-feira", short: "Ter", value: 2 },
  { name: "Quarta-feira", short: "Qua", value: 3 },
  { name: "Quinta-feira", short: "Qui", value: 4 },
  { name: "Sexta-feira", short: "Sex", value: 5 },
  { name: "Sábado", short: "Sáb", value: 6 },
].map((day) => {
  const date = new Date(today);
  date.setDate(today.getDate() + (day.value - currentDay));
  const dayStr = String(date.getDate()).padStart(2, "0");
  const monthStr = String(date.getMonth() + 1).padStart(2, "0");
  return { ...day, date: `${dayStr}/${monthStr}` };
});

const shortcuts = computed(() => [
  {
    title: "Fichas de Treino",
    description: "Acesse suas fichas e séries personalizadas",
    icon: "lucide:dumbbell",
    route: "/students/training-sheets",
    count: 0,
    color: "emerald",
  },
  {
    title: "Avaliações Físicas",
    description: "Histórico completo de medidas e evolução",
    icon: "lucide:activity",
    route: "/students/assessments",
    count: 0,
    color: "blue",
  },
  {
    title: "Plano Alimentar",
    description: "Cardápio personalizado e metas nutricionais",
    icon: "lucide:utensils",
    route: "/students/meal-plans",
    count: 0,
    color: "green",
  },
  {
    title: "Mensalidades",
    description: "Pagamentos, boletos e situação financeira",
    icon: "lucide:credit-card",
    route: "/students/monthly-fees",
    count: 0,
    color: "purple",
  },
  {
    title: "Compras",
    description: "Itens adquiridos na loja da academia",
    icon: "lucide:shopping-bag",
    route: "/students/purchases",
    count: 0,
    color: "pink",
  },
  {
    title: "Agendamentos",
    description: "Aulas e eventos que você participou",
    icon: "lucide:calendar-days",
    route: "/students/bookings",
    count: 0,
    color: "emerald",
  },
  {
    title: "Postagens",
    description: "Novidades e comunicados da academia",
    icon: "lucide:newspaper",
    route: "/students/posts",
    count: 0,
    color: "emerald",
  },
  {
    title: "Produtos",
    description: "Vitrine de produtos e serviços",
    icon: "lucide:store",
    route: "/students/items",
    count: 0,
    color: "green",
  },
]);

onMounted(async () => {
  await Promise.all([dashboardStore.loadAll(), configuration.loadConfig()]);
  startCarousel();
});

const startCarousel = (): void => {
  if (carouselSlides.value.length <= 1) return;
  setInterval(() => {
    nextImage();
  }, 5000);
};

const nextImage = (): void => {
  if (carouselSlides.value.length === 0) return;
  currentImageIndex.value =
    (currentImageIndex.value + 1) % carouselSlides.value.length;
};

const prevImage = (): void => {
  if (carouselSlides.value.length === 0) return;
  currentImageIndex.value =
    currentImageIndex.value === 0
      ? carouselSlides.value.length - 1
      : currentImageIndex.value - 1;
};

const goToImage = (index: number): void => {
  currentImageIndex.value = index;
};

const handleTouchStart = (e: TouchEvent): void => {
  const touch = e.touches[0];
  if (!touch) return;
  touchStartX.value = touch.clientX;
};

const handleTouchEnd = (e: TouchEvent): void => {
  const touch = e.changedTouches[0];
  if (!touch) return;
  touchEndX.value = touch.clientX;
  const diff = touchStartX.value - touchEndX.value;
  if (Math.abs(diff) > 50) {
    if (diff > 0) nextImage();
    else prevImage();
  }
};

const getGreeting = (): string => {
  const hour = new Date().getHours();
  if (hour < 12) return "Bom dia";
  if (hour < 18) return "Boa tarde";
  return "Boa noite";
};
</script>

<template>
  <div v-if="isLoading" class="flex items-center justify-center min-h-screen">
    <Icon
      name="lucide:loader-2"
      class="h-12 w-12 text-emerald-500 animate-spin"
    />
  </div>

  <div
    v-else
    class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 space-y-6 sm:space-y-8 relative"
  >
    <svg
      class="absolute inset-0 w-full h-full opacity-[0.04] pointer-events-none"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <pattern
          id="wave-students"
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
      <rect width="100%" height="100%" fill="url(#wave-students)" />
    </svg>
    <section class="relative">
      <div
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5 sm:mb-6"
      >
        <div>
          <h1 class="text-2xl sm:text-3xl font-bold text-white">
            {{ getGreeting() }}, {{ auth.user?.name?.split(" ")[0] }}!
          </h1>
          <p class="text-sm sm:text-base text-zinc-400 mt-1">
            {{ configuration.config?.name ?? "Academia" }}
          </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
          <NuxtLink
            to="/students/profile"
            class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-semibold hover:bg-emerald-500/20 transition-all"
          >
            <Icon name="lucide:user" class="h-4 w-4" />
            Meu Perfil
          </NuxtLink>
          <NuxtLink
            to="/students/chat"
            class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-violet-500/10 border border-violet-500/20 text-violet-400 text-sm font-semibold hover:bg-violet-500/20 transition-all"
          >
            <Icon name="lucide:bot" class="h-4 w-4" />
            Chat IA
          </NuxtLink>
        </div>
      </div>

      <div
        class="relative h-52 sm:h-64 md:h-96 rounded-2xl overflow-hidden bg-zinc-800/50"
        @touchstart.passive="handleTouchStart"
        @touchend.passive="handleTouchEnd"
      >
        <TransitionGroup name="carousel" tag="div" class="relative h-full">
          <div
            v-for="(post, index) in carouselSlides"
            v-show="index === currentImageIndex"
            :key="post.id"
            class="absolute inset-0"
          >
            <div class="w-full h-full flex items-end p-4 sm:p-8 bg-zinc-800">
              <img
                v-if="post.imageUrl"
                :src="post.imageUrl"
                :alt="post.title"
                class="absolute inset-0 w-full h-full object-cover"
              />
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"
              />
              <div
                class="relative w-full bg-black/40 backdrop-blur-sm rounded-2xl p-4 sm:p-6"
              >
                <h2
                  class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-1 sm:mb-2"
                >
                  {{ post.title }}
                </h2>
                <p
                  class="text-sm sm:text-lg text-white/90 line-clamp-2"
                  v-html="post.description"
                />
                <div
                  v-if="post.linkSite || post.linkVideo"
                  class="mt-3 flex gap-3"
                >
                  <a
                    v-if="post.linkSite"
                    :href="post.linkSite"
                    target="_blank"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-400 hover:text-emerald-300 transition-colors"
                  >
                    <Icon name="lucide:external-link" class="h-3.5 w-3.5" />
                    Saiba mais
                  </a>
                  <a
                    v-if="post.linkVideo"
                    :href="post.linkVideo"
                    target="_blank"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-400 hover:text-blue-300 transition-colors"
                  >
                    <Icon name="lucide:video" class="h-3.5 w-3.5" />
                    Assistir
                  </a>
                </div>
              </div>
            </div>
          </div>
        </TransitionGroup>

        <button
          class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-1.5 sm:p-2 transition-all max-sm:hidden"
          @click="prevImage"
        >
          <Icon name="lucide:chevron-left" class="h-5 w-5 sm:h-6 sm:w-6" />
        </button>
        <button
          class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-1.5 sm:p-2 transition-all max-sm:hidden"
          @click="nextImage"
        >
          <Icon name="lucide:chevron-right" class="h-5 w-5 sm:h-6 sm:w-6" />
        </button>

        <div
          v-if="carouselSlides.length > 1"
          class="absolute bottom-3 sm:bottom-4 left-1/2 -translate-x-1/2 flex gap-2"
        >
          <button
            v-for="(_, index) in carouselSlides"
            :key="index"
            class="w-2 h-2 rounded-full transition-all"
            :class="
              index === currentImageIndex
                ? 'bg-emerald-500 w-8'
                : 'bg-white/50 hover:bg-white/70'
            "
            @click="goToImage(index)"
          />
        </div>
      </div>
    </section>

    <section>
      <h2 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4">
        Dias da Semana
      </h2>
      <div class="grid grid-cols-7 gap-1.5 md:gap-4">
        <button
          v-for="day in weekDays"
          :key="day.value"
          class="flex flex-col items-center justify-center rounded-xl md:rounded-2xl transition-all md:hover:scale-105 py-2 md:py-4"
          :class="
            day.value === currentDay
              ? 'bg-emerald-500/10 border border-emerald-500/20'
              : 'hover:bg-zinc-800/40'
          "
          @click="navigateTo('/students/bookings')"
        >
          <div
            class="text-[10px] md:text-sm font-semibold"
            :class="
              day.value === currentDay ? 'text-emerald-400' : 'text-zinc-400'
            "
          >
            <span class="hidden md:inline">{{ day.name }}</span>
            <span class="md:hidden">{{ day.short }}</span>
          </div>
          <div
            class="text-xs sm:text-sm md:text-base font-bold mt-0.5"
            :class="day.value === currentDay ? 'text-white' : 'text-white'"
          >
            {{ day.date }}
          </div>
          <div
            v-if="bookingsCount[day.value]"
            class="text-[9px] md:text-xs mt-0.5 font-medium"
            :class="
              day.value === currentDay ? 'text-emerald-400' : 'text-zinc-500'
            "
          >
            {{ bookingsCount[day.value] }} evento{{
              (bookingsCount[day.value] ?? 0) > 1 ? "s" : ""
            }}
          </div>
        </button>
      </div>
    </section>

    <section>
      <h2 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4">
        Atalhos Rápidos
      </h2>
      <div
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6"
      >
        <NuxtLink
          v-for="shortcut in shortcuts"
          :key="shortcut.title"
          :to="shortcut.route"
          class="card-default group transition-all md:hover:scale-105 hover:shadow-xl border border-emerald-500/10 hover:border-emerald-500/30 flex items-center gap-4 sm:block sm:relative overflow-hidden py-4 sm:py-6"
        >
          <div
            v-if="shortcut.count > 0"
            class="absolute top-3 right-3 bg-emerald-500/15 text-emerald-400 text-xs font-bold px-2 py-1 rounded-full"
          >
            {{ shortcut.count }}
          </div>

          <div
            class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl flex items-center justify-center shrink-0 sm:mb-4"
            :class="{
              'bg-emerald-500/15': shortcut.color === 'emerald',
              'bg-blue-500/15': shortcut.color === 'blue',
              'bg-green-500/15': shortcut.color === 'green',
              'bg-purple-500/15': shortcut.color === 'purple',
              'bg-pink-500/15': shortcut.color === 'pink',
            }"
          >
            <Icon
              :name="shortcut.icon"
              class="h-7 w-7 sm:h-8 sm:w-8"
              :class="{
                'text-emerald-500': shortcut.color === 'emerald',
                'text-blue-500': shortcut.color === 'blue',
                'text-green-500': shortcut.color === 'green',
                'text-purple-500': shortcut.color === 'purple',
                'text-pink-500': shortcut.color === 'pink',
              }"
            />
          </div>

          <div class="flex-1 min-w-0 sm:block">
            <h3
              class="text-lg sm:text-xl font-bold text-white mb-0.5 sm:mb-1 group-hover:text-emerald-400 transition-colors"
            >
              {{ shortcut.title }}
            </h3>
            <p class="text-sm sm:text-base text-zinc-400">
              {{ shortcut.description }}
            </p>
          </div>

          <Icon
            name="lucide:arrow-right"
            class="h-6 w-6 text-zinc-600 group-hover:text-emerald-500 group-hover:translate-x-1 transition-all shrink-0 sm:hidden"
          />
        </NuxtLink>
      </div>
    </section>
  </div>
</template>

<style scoped>
.carousel-enter-active,
.carousel-leave-active {
  transition: opacity 0.5s ease;
}

.carousel-enter-from,
.carousel-leave-to {
  opacity: 0;
}
</style>
