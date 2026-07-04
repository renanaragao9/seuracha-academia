import type { ApiResponse, ChatData } from "~/interfaces/ia";

export async function chat(
  apiBase: string,
  token: string,
  message: string,
  model?: string,
  systemPrompt?: string,
  messages?: { role: string; content: string }[],
): Promise<ApiResponse<ChatData>> {
  return await $fetch<ApiResponse<ChatData>>(`${apiBase}/v1/ia/chat`, {
    method: "POST",
    headers: { Authorization: `Bearer ${token}` },
    body: {
      message,
      model,
      system_prompt: systemPrompt,
      messages,
    },
  });
}
