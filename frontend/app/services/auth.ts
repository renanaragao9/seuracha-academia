import type { LoginPayload, LoginResponse, User } from "~/interfaces/auth";

export async function login(
  apiBase: string,
  payload: LoginPayload,
): Promise<LoginResponse["data"] | null> {
  const response = await $fetch<LoginResponse>(`${apiBase}/v1/login`, {
    method: "POST",
    body: payload,
  });

  if (!response?.data) return null;

  return {
    ...response.data,
    user: convertKeysToCamel(response.data.user as unknown as Record<string, unknown>) as unknown as User,
  };
}

export async function logout(
  apiBase: string,
  token: string,
): Promise<void> {
  await $fetch(`${apiBase}/v1/logout`, {
    method: "POST",
    headers: { Authorization: `Bearer ${token}` },
  });
}

export async function fetchMe(
  apiBase: string,
  token: string,
): Promise<User | null> {
  const response = await $fetch<{ data: Record<string, unknown> }>(`${apiBase}/v1/me`, {
    headers: { Authorization: `Bearer ${token}` },
  });

  if (!response?.data) return null;

  return convertKeysToCamel(response.data) as unknown as User;
}
