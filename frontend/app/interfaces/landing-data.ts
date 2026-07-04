import type { AcademyConfig } from "./academy-config";

export interface LandingStats {
  activeStudents: number;
  yearsExperience: number;
  professorsCount: number;
}

export interface LandingPlan {
  id: number;
  name: string;
  description: string | null;
  amountBase: number | null;
  periodDays: number | null;
}

export interface LandingData {
  configuration: AcademyConfig;
  stats: LandingStats;
  plans: LandingPlan[];
}
