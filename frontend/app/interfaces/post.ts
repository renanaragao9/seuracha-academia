export interface PostType {
  id: number;
  name: string;
}

export interface Post {
  id: number;
  title: string;
  description: string;
  imageUrl?: string | null;
  linkVideo?: string | null;
  linkSite?: string | null;
  status?: string;
  startDate?: string | null;
  endDate?: string | null;
  postType?: PostType | null;
  user?: { id: number; name: string } | null;
  createdAt?: string | null;
}
