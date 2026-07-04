<script setup lang="ts">
import type { AcademyConfig } from "~/interfaces/academy-config";
import type { LandingStats } from "~/interfaces/landing-data";

const config = inject<Ref<AcademyConfig | null>>("academyConfig");
const landingStats = inject<Ref<LandingStats | null>>("landingStats");

const statsItems = computed(() => [
  {
    value: landingStats?.value
      ? `${landingStats.value.activeStudents}+`
      : "2.500+",
    label: "Alunos ativos",
  },
  {
    value: landingStats?.value
      ? `${landingStats.value.yearsExperience}+`
      : "15+",
    label: "Anos de experiência",
  },
  {
    value: landingStats?.value
      ? `${landingStats.value.professorsCount}+`
      : "40+",
    label: "Professores certificados",
  },
  { value: "98%", label: "Satisfação dos clientes" },
]);

const logoUrl = computed(() => config?.value?.branding?.logoUrl ?? null);
const description = computed(
  () =>
    config?.value?.description ||
    "A academia que vai além do físico. Equipamentos de última geração, professores especializados e uma comunidade que te impulsiona a superar limites.",
);
</script>

<template>
  <section class="relative min-h-screen flex items-center overflow-hidden">
    <div
      class="absolute inset-0 bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950"
    />
    <div
      class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(16,185,129,0.15),_transparent_60%)]"
    />
    <div
      class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_rgba(4,120,87,0.1),_transparent_60%)]"
    />

    <div
      class="absolute inset-0 opacity-10"
      style="
        background-image:
          linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
          linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        background-size: 60px 60px;
      "
    />

    <div
      class="absolute top-1/4 right-1/4 w-96 h-96 rounded-full bg-emerald-500/10 blur-3xl animate-pulse"
    />
    <div
      class="absolute bottom-1/4 left-1/4 w-64 h-64 rounded-full bg-emerald-700/10 blur-3xl animate-pulse"
      style="animation-delay: 1s"
    />

    <div class="relative z-10 max-w-7xl mx-auto px-6 pt-28 pb-20">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-8">
          <div
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium"
          >
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" />
            Academia completa · Aberto agora
          </div>

          <h1
            class="text-5xl lg:text-7xl font-black leading-none tracking-tight"
          >
            <span class="text-white">Transforme</span>
            <br />
            <span class="text-white">seu</span>
            <span
              class="bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent"
            >
              corpo</span
            >
            <br />
            <span class="text-white">e sua</span>
            <span
              class="bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent"
            >
              mente</span
            >
          </h1>

          <p class="text-xl text-zinc-400 leading-relaxed max-w-lg">
            {{ description }}
          </p>

          <div class="flex flex-col sm:flex-row gap-4">
            <a
              href="#planos"
              class="group inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white font-bold text-lg hover:shadow-2xl hover:shadow-emerald-500/30 hover:scale-105 transition-all duration-300"
            >
              Comece hoje mesmo
              <Icon
                name="lucide:arrow-right"
                class="w-5 h-5 group-hover:translate-x-1 transition-transform"
              />
            </a>
            <a
              href="#modalidades"
              class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl border border-white/10 text-white font-semibold text-lg hover:bg-white/5 hover:border-white/20 transition-all duration-300"
            >
              <Icon name="lucide:play-circle" class="w-5 h-5 text-emerald-500" />
              Ver modalidades
            </a>
          </div>
        </div>

        <div class="lg:pl-8">
          <div class="relative">
            <div
              class="relative rounded-3xl overflow-hidden border border-white/10 bg-gradient-to-br from-zinc-800/80 to-zinc-900/80 backdrop-blur-xl p-4 sm:p-8 shadow-2xl"
            >
              <div
                class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-emerald-500/50 to-transparent"
              />

              <div class="flex justify-center mb-4 sm:mb-8">
                <img
                  v-if="logoUrl"
                  :src="logoUrl"
                  :alt="config?.value?.name ?? 'Academia'"
                  class="w-16 h-16 sm:w-24 sm:h-24 rounded-2xl sm:rounded-3xl object-contain"
                />
                <div
                  v-else
                  class="w-16 h-16 sm:w-24 sm:h-24 rounded-2xl sm:rounded-3xl bg-emerald-500/15 flex items-center justify-center"
                >
                  <Icon name="lucide:dumbbell" class="w-8 h-8 sm:w-12 sm:h-12 text-emerald-500" />
                </div>
              </div>

              <div class="grid grid-cols-2 gap-3">
                <div
                  v-for="stat in statsItems"
                  :key="stat.label"
                  class="rounded-2xl bg-zinc-800/60 border border-white/5 p-3 sm:p-4 text-center hover:border-emerald-500/30 transition-colors duration-300"
                >
                  <div class="text-xl sm:text-3xl font-black text-white mb-1">
                    {{ stat.value }}
                  </div>
                  <div class="text-[10px] sm:text-xs text-zinc-500 font-medium">
                    {{ stat.label }}
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <div
      class="hidden md:flex absolute bottom-8 left-1/2 -translate-x-1/2 flex-col items-center gap-2 text-zinc-600"
    >
      <span class="text-xs font-medium tracking-widest uppercase">Rolar</span>
      <div
        class="w-0.5 h-8 bg-gradient-to-b from-zinc-600 to-transparent animate-bounce"
      />
    </div>
  </section>
</template>
