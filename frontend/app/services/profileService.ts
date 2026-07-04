import type { ProfileData, ProfileUpdatePayload } from "~/interfaces/profile";

interface ApiResponse<T> {
  data: T;
}

export async function fetchProfile(
  apiBase: string,
  token: string,
): Promise<ProfileData | null> {
  const response = await $fetch<ApiResponse<ProfileData>>(
    `${apiBase}/v1/profile`,
    {
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as ProfileData;
}

export async function updateProfile(
  apiBase: string,
  token: string,
  payload: ProfileUpdatePayload,
): Promise<ProfileData | null> {
  const response = await $fetch<ApiResponse<ProfileData>>(
    `${apiBase}/v1/profile`,
    {
      method: "PUT",
      headers: { Authorization: `Bearer ${token}` },
      body: payload,
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as ProfileData;
}

export async function uploadProfileImage(
  apiBase: string,
  token: string,
  file: File,
): Promise<ProfileData | null> {
  const formData = new FormData();
  formData.append("image", file);

  const response = await $fetch<ApiResponse<ProfileData>>(
    `${apiBase}/v1/profile/image`,
    {
      method: "POST",
      headers: { Authorization: `Bearer ${token}` },
      body: formData,
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as ProfileData;
}

export async function changePassword(
  apiBase: string,
  token: string,
  payload: {
    current_password: string;
    password: string;
    password_confirmation: string;
  },
): Promise<boolean> {
  await $fetch(`${apiBase}/v1/password`, {
    method: "PUT",
    headers: { Authorization: `Bearer ${token}` },
    body: payload,
  });

  return true;
}
