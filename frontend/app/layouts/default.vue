<template>
  <div class="min-h-screen bg-page-default text-white flex flex-col">
    <AppHeader />

    <main class="flex-1">
      <slot />
    </main>

    <AppFooter />
  </div>
</template>
