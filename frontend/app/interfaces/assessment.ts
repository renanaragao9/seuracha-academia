export interface MeasurementType {
  id: number;
  name: string;
}

export interface AssessmentItem {
  id: number;
  value: string;
  unit: string | null;
  notes: string | null;
  measurementType: MeasurementType;
}

export interface Assessment {
  id: number;
  name: string;
  startDate: string | null;
  endDate: string | null;
  observations: string | null;
  isActive: boolean;
  items?: AssessmentItem[];
  itemsCount: number;
}
