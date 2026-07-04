<script setup lang="ts">
import { ref, nextTick, onMounted, watch, type Ref } from "vue";
import { marked } from "marked";
import * as llmService from "~/services/llmService";

definePageMeta({
  middleware: "auth",
});

useHead({ title: "Chat IA" });

interface Message {
  role: "user" | "assistant";
  content: string;
  timestamp: string;
  trainingSheet?: {
    id: number;
    name: string;
    createdAt: string;
  };
  mealPlan?: {
    id: number;
    name: string;
    createdAt: string;
  };
}

interface Conversation {
  id: string;
  title: string;
  messages: Message[];
  createdAt: string;
  updatedAt: string;
}

interface Suggestion {
  label: string;
  message: string;
  icon: string;
}

const STORAGE_KEY = "chat_conversations";
const DEFAULT_WELCOME_MESSAGE: Message = {
  role: "assistant",
  content:
    "Olá! Sou sua assistente de fitness com IA. Posso te ajudar com dúvidas sobre treino, nutrição e saúde. Como posso te ajudar hoje?",
  timestamp: new Date().toISOString(),
};

const config = useRuntimeConfig();
const authStore = useAuthStore();

const conversations: Ref<Conversation[]> = ref([]);
const activeId: Ref<string> = ref("");
const inputMessage: Ref<string> = ref("");
const loading: Ref<boolean> = ref(false);
const error: Ref<string> = ref("");
const messagesContainer: Ref<HTMLElement | null> = ref(null);
const textareaRef: Ref<HTMLTextAreaElement | null> = ref(null);
const sidebarOpen: Ref<boolean> = ref(false);

const suggestions: Suggestion[] = [
  {
    label: "Criar ficha de treino",
    message: "Crie um plano de treino para mim",
    icon: "lucide:clipboard-list",
  },
  {
    label: "Analisar meu perfil",
    message: "Analise meu perfil de treino e progresso",
    icon: "lucide:chart-bar",
  },
  {
    label: "Criar plano alimentar",
    message: "Crie um plano alimentar para mim",
    icon: "lucide:utensils",
  },
];

const messages = computed(() => {
  return (
    conversations.value.find((c) => c.id === activeId.value)?.messages ?? []
  );
});

function generateId(): string {
  return Date.now().toString(36) + Math.random().toString(36).slice(2, 8);
}

function generateTitle(messages: Message[]): string {
  const firstUser = messages.find((m) => m.role === "user");
  if (!firstUser) return "Nova conversa";
  const text = firstUser.content.slice(0, 40);
  return text.length < firstUser.content.length ? text + "…" : text;
}

function createConversation(): Conversation {
  return {
    id: generateId(),
    title: "Nova conversa",
    messages: [DEFAULT_WELCOME_MESSAGE],
    createdAt: new Date().toISOString(),
    updatedAt: new Date().toISOString(),
  };
}

function loadConversations(): void {
  if (!import.meta.client) return;
  const stored = localStorage.getItem(STORAGE_KEY);
  if (stored) {
    try {
      conversations.value = JSON.parse(stored) as Conversation[];
    } catch {
      conversations.value = [];
    }
  }

  if (conversations.value.length === 0) {
    const conv = createConversation();
    conversations.value = [conv];
    activeId.value = conv.id;
  } else {
    activeId.value = conversations.value[0]!.id;
    if (conversations.value[0]!.messages.length === 0) {
      conversations.value[0]!.messages = [DEFAULT_WELCOME_MESSAGE];
    }
  }
}

function persist(): void {
  if (!import.meta.client) return;
  const sorted = [...conversations.value].sort(
    (a, b) => new Date(b.updatedAt).getTime() - new Date(a.updatedAt).getTime(),
  );
  conversations.value = sorted;
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(sorted));
  } catch {
    // storage full — silently ignore
  }
}

function updateActiveTitle(): void {
  const conv = conversations.value.find((c) => c.id === activeId.value);
  if (!conv || conv.title !== "Nova conversa") return;
  conv.title = generateTitle(conv.messages);
}

function newChat(): void {
  const conv = createConversation();
  conversations.value.unshift(conv);
  activeId.value = conv.id;
  persist();
  sidebarOpen.value = false;
  void nextTick(() => scrollToBottom());
}

function switchConversation(id: string): void {
  activeId.value = id;
  sidebarOpen.value = false;
  void nextTick(() => scrollToBottom());
}

function deleteConversation(id: string): void {
  if (conversations.value.length <= 1) {
    const fresh = createConversation();
    conversations.value = [fresh];
    activeId.value = fresh.id;
    persist();
    return;
  }

  conversations.value = conversations.value.filter((c) => c.id !== id);

  if (activeId.value === id) {
    activeId.value = conversations.value[0]!.id;
  }
  persist();
}

watch(
  messages,
  () => {
    void nextTick(() => scrollToBottom());
  },
  { deep: true },
);

onMounted((): void => {
  loadConversations();
  void nextTick(() => scrollToBottom());
});

async function sendMessage(): Promise<void> {
  if (!inputMessage.value.trim() || loading.value) return;

  const userText: string = inputMessage.value.trim();
  inputMessage.value = "";
  error.value = "";

  autoResize();

  messages.value.push({
    role: "user",
    content: userText,
    timestamp: new Date().toISOString(),
  });

  updateActiveTitle();
  persist();
  await scrollToBottom();

  loading.value = true;

  const history = messages.value
    .slice(0, -1)
    .map((m) => ({ role: m.role, content: m.content }));

  try {
    const response = await llmService.chat(
      config.public.apiBase,
      authStore.token ?? "",
      userText,
      undefined,
      undefined,
      history,
    );

    if (response.status === "success" && response.data?.message) {
      messages.value.push({
        role: "assistant",
        content: response.data.message,
        timestamp: new Date().toISOString(),
        trainingSheet: response.data.training_sheet
          ? {
              id: response.data.training_sheet.id,
              name: response.data.training_sheet.name,
              createdAt: response.data.training_sheet.created_at,
            }
          : undefined,
        mealPlan: response.data.meal_plan
          ? {
              id: response.data.meal_plan.id,
              name: response.data.meal_plan.name,
              createdAt: response.data.meal_plan.created_at,
            }
          : undefined,
      });
      const conv = conversations.value.find((c) => c.id === activeId.value);
      if (conv) conv.updatedAt = new Date().toISOString();
      persist();
    } else {
      error.value = response.message || "Erro ao processar mensagem";
    }
  } catch (err: unknown) {
    error.value = "Erro ao conectar com IA";
    console.error(err);
  } finally {
    loading.value = false;
    await scrollToBottom();
  }
}

async function scrollToBottom(): Promise<void> {
  await nextTick();
  if (messagesContainer.value) {
    messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
  }
}

function formatTime(timestamp: string): string {
  const date: Date = new Date(timestamp);
  return date.toLocaleTimeString("pt-BR", {
    hour: "2-digit",
    minute: "2-digit",
  });
}

function formatDate(timestamp: string): string {
  const date = new Date(timestamp);
  const now = new Date();
  const diffDays = Math.floor(
    (now.getTime() - date.getTime()) / (1000 * 60 * 60 * 24),
  );

  if (diffDays === 0) return "Hoje";
  if (diffDays === 1) return "Ontem";
  if (diffDays < 7) return `${diffDays} dias atrás`;

  return date.toLocaleDateString("pt-BR", {
    day: "2-digit",
    month: "short",
  });
}

function handleKeydown(e: KeyboardEvent): void {
  if (e.key === "Enter" && !e.shiftKey) {
    e.preventDefault();
    void sendMessage();
  }
}

function sendSuggestion(suggestion: Suggestion): void {
  if (loading.value) return;
  inputMessage.value = suggestion.message;
  void sendMessage();
}

function renderMarkdown(text: string): string {
  return marked.parse(text, { breaks: true }) as string;
}

function autoResize(): void {
  const el = textareaRef.value;
  if (!el) return;
  el.style.height = "auto";
  el.style.height = `${Math.min(el.scrollHeight, 200)}px`;
}
</script>

<template>
  <div class="flex h-[calc(100vh-4rem)]">
    <transition name="sidebar">
      <div
        v-if="sidebarOpen"
        class="fixed inset-0 z-40 lg:hidden"
        @click="sidebarOpen = false"
      >
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" />
      </div>
    </transition>

    <aside
      class="fixed lg:static inset-y-0 left-0 z-50 w-72 bg-zinc-900 border-r border-zinc-800 flex flex-col transition-transform duration-200"
      :class="
        sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
      "
    >
      <div class="p-4 border-b border-zinc-800">
        <button
          @click="newChat"
          class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-emerald-500 hover:bg-emerald-400 text-white transition-colors"
        >
          <Icon name="lucide:plus" class="h-4 w-4" />
          Nova conversa
        </button>
      </div>

      <div class="flex-1 overflow-y-auto px-2 py-2 space-y-1">
        <div
          v-for="conv in conversations"
          :key="conv.id"
          class="group flex items-center gap-2 px-3 py-2.5 rounded-xl cursor-pointer transition-colors"
          :class="conv.id === activeId ? 'bg-zinc-800' : 'hover:bg-zinc-800/50'"
          @click="switchConversation(conv.id)"
        >
          <div class="flex-1 min-w-0">
            <p
              class="text-sm truncate"
              :class="conv.id === activeId ? 'text-white' : 'text-zinc-400'"
            >
              {{ conv.title }}
            </p>
            <p class="text-[11px] text-zinc-500 mt-0.5">
              {{ formatDate(conv.updatedAt) }}
            </p>
          </div>
          <button
            class="text-zinc-500 hover:text-red-400 transition-colors p-1"
            title="Excluir conversa"
            @click.stop="deleteConversation(conv.id)"
          >
            <Icon name="lucide:trash-2" class="h-3.5 w-3.5" />
          </button>
        </div>
      </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
      <div
        class="flex items-center gap-2 sm:gap-3 px-3 sm:px-6 py-2.5 border-b border-zinc-800"
      >
        <button
          @click="sidebarOpen = !sidebarOpen"
          class="lg:hidden p-1 -ml-0.5 text-zinc-400 hover:text-white transition-colors shrink-0"
        >
          <Icon name="lucide:menu" class="h-5 w-5" />
        </button>
        <div class="flex-1 flex items-center justify-center gap-2">
          <div
            class="w-8 h-8 rounded-full bg-emerald-500/15 flex items-center justify-center shrink-0"
          >
            <Icon name="lucide:bot" class="h-4 w-4 text-emerald-500" />
          </div>
          <div>
            <h1 class="text-white font-semibold text-sm leading-none">
              Assistente IA
            </h1>
            <p class="text-zinc-400 text-xs mt-0.5">Fitness &amp; Nutrição</p>
          </div>
        </div>
        <NuxtLink
          to="/students"
          class="flex items-center gap-1 text-zinc-400 hover:text-white transition-colors shrink-0 text-sm"
        >
          <Icon name="lucide:arrow-left" class="h-4 w-4" />
          <span class="hidden sm:inline">Voltar</span>
        </NuxtLink>
      </div>

      <div class="flex-1 flex flex-col min-h-0 px-4 sm:px-6">
        <div
          ref="messagesContainer"
          class="flex-1 overflow-y-auto space-y-4 py-6 pr-1 scroll-smooth"
        >
          <div
            v-for="(msg, idx) in messages"
            :key="idx"
            class="flex gap-3"
            :class="msg.role === 'user' ? 'flex-row-reverse' : 'flex-row'"
          >
            <div
              class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center text-xs font-bold mt-0.5"
              :class="
                msg.role === 'user'
                  ? 'bg-emerald-500/15 text-emerald-400'
                  : 'bg-zinc-700 text-zinc-300'
              "
            >
              <Icon
                :name="msg.role === 'user' ? 'lucide:user' : 'lucide:bot'"
                class="h-4 w-4"
              />
            </div>

            <div
              class="max-w-[75%] space-y-1"
              :class="msg.role === 'user' ? 'items-end' : 'items-start'"
            >
              <div
                class="rounded-2xl px-4 py-3 text-sm leading-relaxed"
                :class="
                  msg.role === 'user'
                    ? 'bg-emerald-500 text-white rounded-tr-sm'
                    : 'bg-zinc-800 text-zinc-100 rounded-tl-sm border border-zinc-700 markdown-body'
                "
              >
                <template v-if="msg.role === 'assistant'">
                  <div v-html="renderMarkdown(msg.content)" />
                </template>
                <template v-else>
                  {{ msg.content }}
                </template>
              </div>
              <div
                v-if="msg.trainingSheet"
                class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl px-4 py-3 flex items-center gap-3"
              >
                <div
                  class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0"
                >
                  <Icon
                    name="lucide:clipboard-list"
                    class="h-5 w-5 text-emerald-400"
                  />
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-white truncate">
                    {{ msg.trainingSheet.name }}
                  </p>
                  <p class="text-xs text-zinc-400 mt-0.5">
                    Ficha de treino criada com sucesso
                  </p>
                </div>
                <NuxtLink
                  :to="`/students/training-sheets`"
                  class="text-xs text-emerald-400 hover:text-emerald-300 font-medium shrink-0"
                >
                  Ver fichas
                </NuxtLink>
              </div>
              <div
                v-if="msg.mealPlan"
                class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl px-4 py-3 flex items-center gap-3"
              >
                <div
                  class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0"
                >
                  <Icon
                    name="lucide:utensils"
                    class="h-5 w-5 text-emerald-400"
                  />
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-white truncate">
                    {{ msg.mealPlan.name }}
                  </p>
                  <p class="text-xs text-zinc-400 mt-0.5">
                    Plano alimentar criado com sucesso
                  </p>
                </div>
                <NuxtLink
                  :to="`/students/meal-plans`"
                  class="text-xs text-emerald-400 hover:text-emerald-300 font-medium shrink-0"
                >
                  Ver planos
                </NuxtLink>
              </div>
              <p
                class="text-[11px] text-zinc-500 px-1"
                :class="msg.role === 'user' ? 'text-right' : 'text-left'"
              >
                {{ formatTime(msg.timestamp) }}
              </p>
            </div>
          </div>

          <div v-if="loading" class="flex gap-3">
            <div
              class="w-8 h-8 rounded-full bg-zinc-700 flex items-center justify-center shrink-0"
            >
              <Icon name="lucide:bot" class="h-4 w-4 text-zinc-300" />
            </div>
            <div
              class="bg-zinc-800 border border-zinc-700 rounded-2xl rounded-tl-sm px-4 py-3"
            >
              <div class="flex gap-1 items-center h-5">
                <span
                  class="w-2 h-2 rounded-full bg-zinc-500 animate-bounce"
                  style="animation-delay: 0ms"
                />
                <span
                  class="w-2 h-2 rounded-full bg-zinc-500 animate-bounce"
                  style="animation-delay: 150ms"
                />
                <span
                  class="w-2 h-2 rounded-full bg-zinc-500 animate-bounce"
                  style="animation-delay: 300ms"
                />
              </div>
            </div>
          </div>

          <div v-if="error" class="flex justify-center">
            <p
              class="text-xs text-red-400 bg-red-500/10 border border-red-500/20 rounded-lg px-3 py-2"
            >
              {{ error }}
            </p>
          </div>
        </div>

        <div class="py-3 space-y-3">
          <div class="flex gap-2 flex-wrap justify-center">
            <button
              v-for="suggestion in suggestions"
              :key="suggestion.label"
              :disabled="loading"
              class="flex items-center gap-2 px-4 py-2 rounded-full text-xs font-medium bg-zinc-800 border border-zinc-700 text-zinc-300 hover:text-white hover:border-zinc-500 hover:bg-zinc-700/50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              @click="sendSuggestion(suggestion)"
            >
              <Icon
                :name="suggestion.icon"
                class="h-3.5 w-3.5 text-emerald-400"
              />
              {{ suggestion.label }}
            </button>
          </div>

          <div class="flex gap-3 items-end">
            <div class="flex-1 relative">
              <textarea
                ref="textareaRef"
                v-model="inputMessage"
                :disabled="loading"
                rows="1"
                placeholder="Digite sua mensagem..."
                class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-4 py-3 text-sm text-white placeholder-zinc-500 resize-none focus:outline-none focus:border-emerald-500 transition-colors disabled:opacity-50"
                @keydown="handleKeydown"
                @input="autoResize"
              />
            </div>
            <button
              :disabled="loading || !inputMessage.trim()"
              class="w-11 h-11 rounded-xl bg-emerald-500 hover:bg-emerald-400 disabled:bg-zinc-700 disabled:cursor-not-allowed flex items-center justify-center transition-colors shrink-0"
              @click="sendMessage"
            >
              <Icon name="lucide:send" class="h-4 w-4 text-white" />
            </button>
          </div>
          <p class="text-center text-[11px] text-zinc-600">
            Enter para enviar · Shift+Enter para quebrar linha
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.sidebar-enter-active,
.sidebar-leave-active {
  transition: opacity 0.2s ease;
}
.sidebar-enter-from,
.sidebar-leave-to {
  opacity: 0;
}

.markdown-body :deep(h1) {
  font-size: 1.25rem;
  font-weight: 700;
  color: #fff;
  margin: 1rem 0 0.5rem;
}
.markdown-body :deep(h2) {
  font-size: 1.1rem;
  font-weight: 600;
  color: #e2e8f0;
  margin: 0.875rem 0 0.375rem;
}
.markdown-body :deep(h3) {
  font-size: 1rem;
  font-weight: 600;
  color: #cbd5e1;
  margin: 0.75rem 0 0.25rem;
}
.markdown-body :deep(p) {
  margin: 0.375rem 0;
}
.markdown-body :deep(ul) {
  padding-left: 1.25rem;
  margin: 0.375rem 0;
  list-style: disc;
}
.markdown-body :deep(ol) {
  padding-left: 1.25rem;
  margin: 0.375rem 0;
  list-style: decimal;
}
.markdown-body :deep(li) {
  margin: 0.125rem 0;
}
.markdown-body :deep(strong) {
  font-weight: 600;
  color: #f1f5f9;
}
.markdown-body :deep(em) {
  font-style: italic;
}
.markdown-body :deep(code) {
  background: rgba(255, 255, 255, 0.08);
  padding: 0.125rem 0.375rem;
  border-radius: 0.25rem;
  font-size: 0.85em;
}
.markdown-body :deep(blockquote) {
  border-left: 3px solid #10b981;
  padding-left: 0.75rem;
  color: #9ca3af;
  margin: 0.5rem 0;
}
.markdown-body :deep(hr) {
  border: none;
  border-top: 1px solid #374151;
  margin: 0.75rem 0;
}
.markdown-body :deep(table) {
  width: 100%;
  border-collapse: collapse;
  margin: 0.5rem 0;
  font-size: 0.85rem;
}
.markdown-body :deep(th) {
  background: rgba(255, 255, 255, 0.06);
  padding: 0.375rem 0.625rem;
  text-align: left;
  font-weight: 600;
  border: 1px solid #374151;
}
.markdown-body :deep(td) {
  padding: 0.375rem 0.625rem;
  border: 1px solid #374151;
}
</style>
