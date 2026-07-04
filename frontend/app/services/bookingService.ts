import type { Booking } from "~/interfaces/booking";

interface ApiResponse<T> {
  data: T;
}

export async function fetchBookings(
  apiBase: string,
  token: string,
): Promise<Booking[]> {
  const response = await $fetch<ApiResponse<Booking[]>>(
    `${apiBase}/v1/bookings`,
    {
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  const raw = response.data ?? [];
  return raw.map(
    (item) =>
      convertKeysToCamel(item as unknown as Record<string, unknown>) as unknown as Booking,
  );
}

export async function fetchMyBookings(
  apiBase: string,
  token: string,
): Promise<Booking[]> {
  const response = await $fetch<ApiResponse<Booking[]>>(
    `${apiBase}/v1/bookings/my`,
    {
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  const raw = response.data ?? [];
  return raw.map(
    (item) =>
      convertKeysToCamel(item as unknown as Record<string, unknown>) as unknown as Booking,
  );
}

export async function fetchBooking(
  apiBase: string,
  token: string,
  id: number,
): Promise<Booking | null> {
  const response = await $fetch<ApiResponse<Booking>>(
    `${apiBase}/v1/bookings/${id}`,
    {
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as Booking;
}

export async function registerBooking(
  apiBase: string,
  token: string,
  id: number,
): Promise<Booking> {
  const response = await $fetch<ApiResponse<Booking>>(
    `${apiBase}/v1/bookings/${id}/register`,
    {
      method: "POST",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  return convertKeysToCamel(response.data) as unknown as Booking;
}

export async function unregisterBooking(
  apiBase: string,
  token: string,
  id: number,
): Promise<Booking> {
  const response = await $fetch<ApiResponse<Booking>>(
    `${apiBase}/v1/bookings/${id}/unregister`,
    {
      method: "POST",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  return convertKeysToCamel(response.data) as unknown as Booking;
}
