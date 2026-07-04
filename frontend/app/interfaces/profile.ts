export interface ProfileStats {
  trainingSheetsCount: number;
  assessmentsCount: number;
  workoutLogsCount: number;
  mealPlansCount: number;
  monthlyFeesCount: number;
  purchasesCount: number;
  bookingsCount: number;
}

export interface ProfileStudent {
  id: number;
  name: string;
  email: string | null;
  phone: string | null;
  code: string;
  birthDate: string | null;
  entryDate: string | null;
  gender: string | null;
  color: string | null;
  status: string | null;
  imageUrl: string | null;
  isActive: boolean;
  lastAccessAt: string | null;
  weight: number | null;
  height: number | null;
  notes: string | null;
}

export interface ProfileUser {
  id: number;
  name: string;
  email: string | null;
  phone: string | null;
  imageUrl: string | null;
}

export interface ProfileData {
  user: ProfileUser;
  student: ProfileStudent;
  stats: ProfileStats;
}

export interface ProfileUpdatePayload {
  name?: string;
  email?: string | null;
  phone?: string | null;
  gender?: string | null;
  birthDate?: string | null;
  weight?: number | null;
  height?: number | null;
}

export interface PasswordChangePayload {
  currentPassword: string;
  password: string;
  passwordConfirmation: string;
}
