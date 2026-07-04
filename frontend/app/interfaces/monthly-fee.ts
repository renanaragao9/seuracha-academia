export interface PlanType {
  id?: number;
  name: string;
}

export interface PaymentType {
  id: number;
  name: string;
}

export interface MonthlyFee {
  id: number;
  uuid?: string;
  startDate: string;
  endDate: string;
  datePayment: string | null;
  fullPayment?: string;
  discountPayment?: string | null;
  amountPaid?: string | null;
  finalPayment: number;
  planType: PlanType;
  paymentType?: PaymentType;
}
