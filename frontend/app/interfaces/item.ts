export interface ItemType {
  id: number;
  name: string;
  description?: string;
  isActive?: boolean;
}

export interface FieldType {
  id: number;
  name: string;
}

export interface ItemField {
  id: number;
  value: string;
  fieldType?: FieldType | null;
}

export interface Item {
  id: number;
  name: string;
  description?: string | null;
  imageUrl?: string | null;
  totalPrice?: string | null;
  promotionPrice?: string | null;
  itemType?: ItemType | null;
  fields?: ItemField[] | null;
  createdAt?: string | null;
}
