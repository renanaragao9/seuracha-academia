import type { Post } from "~/interfaces/post";

interface ApiResponse<T> {
  data: T;
}

export async function fetchPosts(
  apiBase: string,
  token: string,
): Promise<Post[]> {
  const response = await $fetch<ApiResponse<Post[]>>(
    `${apiBase}/v1/posts`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  const raw = response.data ?? [];
  return raw.map(
    (item) =>
      convertKeysToCamel(item as unknown as Record<string, unknown>) as unknown as Post,
  );
}

export async function fetchPost(
  apiBase: string,
  token: string,
  id: number,
): Promise<Post | null> {
  const response = await $fetch<ApiResponse<Post>>(
    `${apiBase}/v1/posts/${id}`,
    {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` },
    },
  );

  if (!response?.data) return null;

  return convertKeysToCamel(
    response.data as unknown as Record<string, unknown>,
  ) as unknown as Post;
}
