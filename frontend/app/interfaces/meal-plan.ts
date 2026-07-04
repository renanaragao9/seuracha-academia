export interface Food {
  id: number;
  name: string;
}

export interface MealPlanFood {
  id: number;
  order: number;
  quantity: string | null;
  unit: string | null;
  observation: string | null;
  food: Food;
}

export interface MealType {
  id: number;
  name: string;
}

export interface MealPlanMeal {
  id: number;
  order: number;
  mealType: MealType;
  foods: MealPlanFood[];
}

export interface MealPlan {
  id: number;
  name: string;
  startDate: string | null;
  endDate: string | null;
  isActive: boolean;
  meals?: MealPlanMeal[];
  mealsCount: number;
}
