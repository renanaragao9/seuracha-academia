export interface User {
  id: number;
  name: string;
  email: string | null;
  phone: string | null;
  imageUrl?: string | null;
}

export interface LoginPayload {
  email?: string;
  phone?: string;
  password: string;
}

export interface LoginResponse {
  data: {
    user: User;
    token: string;
  };
}
