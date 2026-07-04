<script setup lang="ts">
definePageMeta({
  middleware: ["auth"],
});

const profileStore = useProfileStore();
const { profileData, isLoading, isChangingPassword, isUploadingImage, error } =
  storeToRefs(profileStore);

const showPasswordModal = ref<boolean>(false);
const fileInput = ref<HTMLInputElement | null>(null);
const imagePreview = ref<string | null>(null);

function triggerFileInput(): void {
  fileInput.value?.click();
}

function handleImageSelect(event: Event): void {
  const target = event.target as HTMLInputElement;
  const file = target.files?.[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = (e) => {
    imagePreview.value = e.target?.result as string;
  };
  reader.readAsDataURL(file);

  profileStore.uploadImage(file);
  target.value = "";
}

const passwordForm = reactive({
  currentPassword: "",
  newPassword: "",
  confirmPassword: "",
});

const showPassword = reactive({
  current: false,
  new: false,
  confirm: false,
});

const genderLabel = computed<Record<string, string>>(() => ({
  male: "Masculino",
  female: "Feminino",
  other: "Outro",
}));

const statusLabel = computed<Record<string, string>>(() => ({
  active: "Ativo",
  inactive: "Inativo",
  suspended: "Suspenso",
  pending: "Pendente",
}));

const statsCards = computed(() => {
  const s = profileData.value?.stats;
  if (!s) return [];
  return [
    {
      label: "Treinos",
      value: s.workoutLogsCount,
      icon: "lucide:dumbbell",
      color: "emerald",
    },
    {
      label: "Avaliações",
      value: s.assessmentsCount,
      icon: "lucide:activity",
      color: "blue",
    },
    {
      label: "Planos Alimentares",
      value: s.mealPlansCount,
      icon: "lucide:utensils",
      color: "green",
    },
    {
      label: "Compras",
      value: s.purchasesCount,
      icon: "lucide:shopping-bag",
      color: "pink",
    },
    {
      label: "Agendamentos",
      value: s.bookingsCount,
      icon: "lucide:calendar-days",
      color: "purple",
    },
    {
      label: "Mensalidades",
      value: s.monthlyFeesCount,
      icon: "lucide:credit-card",
      color: "amber",
    },
  ];
});

const maxStatValue = computed(() => {
  const values = statsCards.value.map((c) => c.value);
  return Math.max(...values, 1);
});

const initials = computed(() => {
  const name = profileData.value?.student.name ?? "";
  return name
    .split(" ")
    .map((n) => n[0])
    .join("")
    .toUpperCase()
    .slice(0, 2);
});

const birthDateFormatted = computed(() => {
  const d = profileData.value?.student.birthDate;
  return d ? brDate(d) : null;
});

const entryDateFormatted = computed(() => {
  const d = profileData.value?.student.entryDate;
  return d ? brDate(d) : null;
});

const imcValue = computed(() => {
  const w = profileData.value?.student.weight;
  const h = profileData.value?.student.height;
  if (!w || !h || h === 0) return null;
  return (w / (h / 100) ** 2).toFixed(1);
});

const passwordMismatch = computed(
  () =>
    passwordForm.confirmPassword.length > 0 &&
    passwordForm.newPassword !== passwordForm.confirmPassword,
);

function openPasswordModal(): void {
  passwordForm.currentPassword = "";
  passwordForm.newPassword = "";
  passwordForm.confirmPassword = "";
  showPasswordModal.value = true;
}

function closePasswordModal(): void {
  if (isChangingPassword.value) return;
  showPasswordModal.value = false;
}

async function handleChangePassword(): Promise<void> {
  if (passwordForm.newPassword !== passwordForm.confirmPassword) return;
  const ok = await profileStore.changePassword(
    passwordForm.currentPassword,
    passwordForm.newPassword,
  );
  if (ok) {
    showPasswordModal.value = false;
  }
}

onMounted(() => {
  profileStore.load();
});
</script>

<template>
  <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8 relative">
    <svg
      class="absolute inset-0 w-full h-full opacity-[0.04] pointer-events-none"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <pattern
          id="wave-profile"
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
      <rect width="100%" height="100%" fill="url(#wave-profile)" />
    </svg>

    <div class="relative z-10">
      <div class="flex items-center gap-4 mb-8">
        <NuxtLink
          to="/students"
          class="text-zinc-400 hover:text-white transition-colors"
        >
          <Icon name="lucide:arrow-left" class="h-6 w-6" />
        </NuxtLink>
        <div>
          <h1 class="text-2xl sm:text-3xl font-bold text-white">Meu Perfil</h1>
          <p class="text-sm sm:text-base text-zinc-400">
            Gerencie suas informações pessoais
          </p>
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
        <p class="text-zinc-400">Carregando perfil...</p>
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

      <div v-else-if="profileData" class="space-y-6">
        <div
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-5 sm:p-8"
        >
          <div
            class="flex flex-col sm:flex-row items-center sm:items-start gap-6"
          >
            <div class="relative shrink-0">
              <input
                ref="fileInput"
                type="file"
                accept="image/jpeg,image/png,image/webp"
                class="hidden"
                @change="handleImageSelect"
              />
              <button
                type="button"
                class="group relative w-24 h-24 sm:w-28 sm:h-28 rounded-2xl overflow-hidden border-2 border-emerald-500/30 focus:outline-none"
                :class="{ 'cursor-pointer': !isUploadingImage }"
                :disabled="isUploadingImage"
                @click="triggerFileInput"
              >
                <img
                  v-if="imagePreview || profileData.user.imageUrl"
                  :src="imagePreview || (profileData.user.imageUrl ?? undefined)"
                  :alt="profileData.student.name"
                  class="w-full h-full object-cover"
                />
                <div
                  v-else
                  class="w-full h-full bg-emerald-500/15 flex items-center justify-center text-3xl sm:text-4xl font-black text-emerald-400"
                >
                  {{ initials }}
                </div>
                <div
                  class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                >
                  <Icon
                    :name="isUploadingImage ? 'lucide:loader-2' : 'lucide:camera'"
                    class="h-6 w-6 text-white"
                    :class="{ 'animate-spin': isUploadingImage }"
                  />
                </div>
              </button>
            </div>

            <div class="flex-1 min-w-0 text-center sm:text-left">
              <div
                class="flex flex-wrap items-center gap-3 justify-center sm:justify-start"
              >
                <h2 class="text-2xl sm:text-3xl font-bold text-white truncate">
                  {{ profileData.student.name }}
                </h2>
                <span
                  v-if="profileData.student.status"
                  :class="[
                    'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border',
                    profileData.student.status === 'active'
                      ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30'
                      : profileData.student.status === 'inactive'
                        ? 'bg-zinc-700/50 text-zinc-400 border-zinc-600'
                        : profileData.student.status === 'suspended'
                          ? 'bg-red-500/10 text-red-400 border-red-500/30'
                          : 'bg-amber-500/10 text-amber-400 border-amber-500/30',
                  ]"
                >
                  {{
                    statusLabel[profileData.student.status] ??
                    profileData.student.status
                  }}
                </span>
              </div>
              <p class="text-sm text-zinc-400 mt-1">
                Código: {{ profileData.student.code }}
              </p>
              <div
                class="flex flex-wrap gap-3 mt-3 justify-center sm:justify-start text-sm text-zinc-300"
              >
                <span
                  v-if="profileData.student.email"
                  class="flex items-center gap-1.5"
                >
                  <Icon name="lucide:mail" class="h-4 w-4 text-zinc-500" />
                  {{ profileData.student.email }}
                </span>
                <span
                  v-if="profileData.student.phone"
                  class="flex items-center gap-1.5"
                >
                  <Icon name="lucide:phone" class="h-4 w-4 text-zinc-500" />
                  {{ profileData.student.phone }}
                </span>
              </div>
              <button
                class="mt-4 px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-500 hover:bg-emerald-600 text-white transition-colors flex items-center gap-2"
                @click="openPasswordModal"
              >
                <Icon name="lucide:lock" class="h-4 w-4" />
                Alterar Senha
              </button>
            </div>
          </div>

          <div
            class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-zinc-700/50"
          >
            <div class="text-center">
              <p class="text-xs text-zinc-500 uppercase tracking-wider">Peso</p>
              <p class="text-lg font-bold text-white mt-1">
                {{
                  profileData.student.weight
                    ? `${profileData.student.weight} kg`
                    : "-"
                }}
              </p>
            </div>
            <div class="text-center">
              <p class="text-xs text-zinc-500 uppercase tracking-wider">
                Altura
              </p>
              <p class="text-lg font-bold text-white mt-1">
                {{
                  profileData.student.height
                    ? `${profileData.student.height} cm`
                    : "-"
                }}
              </p>
            </div>
            <div class="text-center">
              <p class="text-xs text-zinc-500 uppercase tracking-wider">IMC</p>
              <p class="text-lg font-bold text-emerald-400 mt-1">
                {{ imcValue ?? "-" }}
              </p>
            </div>
            <div class="text-center">
              <p class="text-xs text-zinc-500 uppercase tracking-wider">
                Gênero
              </p>
              <p class="text-lg font-bold text-white mt-1">
                {{
                  profileData.student.gender
                    ? (genderLabel[profileData.student.gender] ??
                      profileData.student.gender)
                    : "-"
                }}
              </p>
            </div>
          </div>

          <div
            v-if="birthDateFormatted || entryDateFormatted"
            class="flex flex-wrap gap-4 mt-4 pt-4 border-t border-zinc-700/50 text-sm text-zinc-400 justify-center sm:justify-start"
          >
            <span v-if="birthDateFormatted">
              Nascimento: {{ birthDateFormatted }}
            </span>
            <span v-if="entryDateFormatted">
              Matrícula: {{ entryDateFormatted }}
            </span>
          </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
          <div
            v-for="card in statsCards"
            :key="card.label"
            class="bg-zinc-800/80 rounded-xl border border-emerald-500/10 p-4 text-center"
          >
            <Icon
              :name="card.icon"
              class="h-5 w-5 mx-auto mb-2"
              :class="{
                'text-emerald-400': card.color === 'emerald',
                'text-blue-400': card.color === 'blue',
                'text-green-400': card.color === 'green',
                'text-pink-400': card.color === 'pink',
                'text-purple-400': card.color === 'purple',
                'text-amber-400': card.color === 'amber',
              }"
            />
            <p class="text-2xl font-black text-white">{{ card.value }}</p>
            <p class="text-[10px] text-zinc-500 uppercase tracking-wider mt-1">
              {{ card.label }}
            </p>
          </div>
        </div>

        <div
          class="bg-zinc-800/80 rounded-2xl border border-emerald-500/10 p-5 sm:p-6"
        >
          <h3 class="text-base font-bold text-white mb-4">
            Resumo de Atividades
          </h3>
          <div class="space-y-4">
            <div
              v-for="card in statsCards"
              :key="card.label"
              class="flex items-center gap-3"
            >
              <span class="text-xs text-zinc-400 w-28 shrink-0 truncate">{{
                card.label
              }}</span>
              <div
                class="flex-1 h-3 bg-zinc-700/70 rounded-full overflow-hidden"
              >
                <div
                  class="h-full rounded-full transition-all duration-700"
                  :class="{
                    'bg-emerald-500': card.color === 'emerald',
                    'bg-blue-500': card.color === 'blue',
                    'bg-green-500': card.color === 'green',
                    'bg-pink-500': card.color === 'pink',
                    'bg-purple-500': card.color === 'purple',
                    'bg-amber-500': card.color === 'amber',
                  }"
                  :style="{ width: `${(card.value / maxStatValue) * 100}%` }"
                />
              </div>
              <span class="text-sm font-semibold text-white w-8 text-right">{{
                card.value
              }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Teleport to="body">
      <Transition name="modal">
        <div
          v-if="showPasswordModal"
          class="fixed inset-0 z-50 flex items-center justify-center p-4"
          @click.self="closePasswordModal"
        >
          <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" />

          <div
            class="relative w-full max-w-md rounded-2xl border border-zinc-700/50 bg-zinc-900 shadow-2xl"
          >
            <div
              class="flex items-center justify-between p-5 border-b border-zinc-700/50"
            >
              <div class="flex items-center gap-3">
                <div
                  class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500/10"
                >
                  <Icon name="lucide:lock" class="h-5 w-5 text-emerald-400" />
                </div>
                <div>
                  <h3 class="text-base font-bold text-white">Alterar Senha</h3>
                  <p class="text-sm text-zinc-400">
                    Digite sua senha atual e a nova
                  </p>
                </div>
              </div>
              <button
                class="rounded-lg p-2 text-zinc-400 hover:text-white hover:bg-zinc-800 transition-colors"
                @click="closePasswordModal"
              >
                <Icon name="lucide:x" class="h-5 w-5" />
              </button>
            </div>

            <div class="p-5 space-y-5">
              <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1.5"
                  >Senha Atual</label
                >
                <div class="relative">
                  <input
                    v-model="passwordForm.currentPassword"
                    :type="showPassword.current ? 'text' : 'password'"
                    required
                    class="w-full rounded-xl border border-zinc-700 bg-zinc-800 pr-12 pl-4 py-3 text-white placeholder-zinc-600 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500/50 transition-colors"
                  />
                  <button
                    type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-200 transition-colors"
                    @click="showPassword.current = !showPassword.current"
                  >
                    <Icon
                      :name="
                        showPassword.current ? 'lucide:eye-off' : 'lucide:eye'
                      "
                      class="h-5 w-5"
                    />
                  </button>
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1.5"
                  >Nova Senha</label
                >
                <div class="relative">
                  <input
                    v-model="passwordForm.newPassword"
                    :type="showPassword.new ? 'text' : 'password'"
                    required
                    minlength="8"
                    class="w-full rounded-xl border border-zinc-700 bg-zinc-800 pr-12 pl-4 py-3 text-white placeholder-zinc-600 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500/50 transition-colors"
                  />
                  <button
                    type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-200 transition-colors"
                    @click="showPassword.new = !showPassword.new"
                  >
                    <Icon
                      :name="showPassword.new ? 'lucide:eye-off' : 'lucide:eye'"
                      class="h-5 w-5"
                    />
                  </button>
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1.5"
                  >Confirmar Nova Senha</label
                >
                <div class="relative">
                  <input
                    v-model="passwordForm.confirmPassword"
                    :type="showPassword.confirm ? 'text' : 'password'"
                    required
                    minlength="8"
                    :class="[
                      'w-full rounded-xl border pr-12 pl-4 py-3 text-white placeholder-zinc-600 focus:outline-none focus:ring-1 transition-colors',
                      passwordMismatch
                        ? 'border-red-500 bg-red-500/10 focus:border-red-500 focus:ring-red-500/50'
                        : 'border-zinc-700 bg-zinc-800 focus:border-emerald-500 focus:ring-emerald-500/50',
                    ]"
                  />
                  <button
                    type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-200 transition-colors"
                    @click="showPassword.confirm = !showPassword.confirm"
                  >
                    <Icon
                      :name="
                        showPassword.confirm ? 'lucide:eye-off' : 'lucide:eye'
                      "
                      class="h-5 w-5"
                    />
                  </button>
                </div>
                <p v-if="passwordMismatch" class="text-xs text-red-400 mt-1">
                  As senhas não conferem.
                </p>
              </div>

              <div
                class="flex justify-end gap-3 pt-4 border-t border-zinc-700/50"
              >
                <button
                  class="px-5 py-2.5 rounded-xl border border-zinc-700 text-zinc-300 text-sm font-semibold hover:bg-zinc-800 transition-colors"
                  @click="closePasswordModal"
                >
                  Cancelar
                </button>
                <button
                  :disabled="
                    isChangingPassword ||
                    passwordMismatch ||
                    !passwordForm.currentPassword ||
                    !passwordForm.newPassword
                  "
                  class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white text-sm font-semibold hover:shadow-lg hover:shadow-emerald-500/30 transition-all disabled:opacity-60"
                  @click="handleChangePassword"
                >
                  <Icon
                    v-if="isChangingPassword"
                    name="lucide:loader-2"
                    class="h-4 w-4 animate-spin"
                  />
                  <Icon v-else name="lucide:lock" class="h-4 w-4" />
                  {{ isChangingPassword ? "Alterando..." : "Alterar Senha" }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<style scoped>
.modal-enter-active {
  transition: all 0.2s ease-out;
}
.modal-leave-active {
  transition: all 0.15s ease-in;
}
.modal-enter-from {
  opacity: 0;
}
.modal-enter-from > div:last-child {
  transform: scale(0.95) translateY(10px);
}
.modal-leave-to {
  opacity: 0;
}
.modal-leave-to > div:last-child {
  transform: scale(0.95) translateY(10px);
}
</style>
