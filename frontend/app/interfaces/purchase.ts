export interface PurchaseItem {
  id: number;
  quantity: number;
  unitPrice: number;
  subtotal: number;
  item: {
    id: number;
    name: string;
  };
}

export interface Purchase {
  id: number;
  uuid?: string;
  status: string | null;
  observation: string | null;
  dateSale: string;
  amountPrice: number;
  discountAmount: number;
  totalAmount: number;
  items: PurchaseItem[];
}
