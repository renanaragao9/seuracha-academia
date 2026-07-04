<template>
  <section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 via-emerald-500 to-emerald-700" />
    <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(rgba(0,0,0,.3) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,.3) 1px, transparent 1px); background-size: 40px 40px;" />
    <div class="absolute top-0 right-0 w-64 h-64 rounded-full bg-white/10 blur-3xl" />
    <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full bg-black/20 blur-3xl" />

    <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
      <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 border border-white/30 text-white text-sm font-medium mb-6">
        <span class="w-2 h-2 rounded-full bg-white animate-pulse" />
        Oferta por tempo limitado
      </div>

      <h2 class="text-4xl lg:text-6xl font-black text-white mb-6 leading-tight">
        Primeira semana <br />completamente <span class="underline decoration-wavy decoration-white/50">grátis</span>
      </h2>

      <p class="text-white/80 text-xl mb-10 max-w-2xl mx-auto">
        Experimente todos os recursos da academia sem compromisso. Sem cartão de crédito necessário.
      </p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a
          href="#contato"
          class="group inline-flex items-center justify-center gap-2 px-10 py-5 rounded-2xl bg-white text-emerald-600 font-bold text-lg hover:bg-white/90 hover:shadow-2xl hover:scale-105 transition-all duration-300"
        >
          Quero minha semana grátis
          <Icon name="lucide:arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
        </a>
        <a
          href="tel:+5511999999999"
          class="inline-flex items-center justify-center gap-2 px-10 py-5 rounded-2xl border-2 border-white/50 text-white font-semibold text-lg hover:bg-white/10 hover:border-white transition-all duration-300"
        >
          <Icon name="lucide:phone" class="w-5 h-5" />
          Ligar agora
        </a>
      </div>
    </div>
  </section>
</template>
