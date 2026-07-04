export interface BookingType {
  id: number;
  name: string;
  description: string | null;
  isActive: boolean;
}

export interface BookingStudent {
  id: number;
  studentId: number;
  status: string;
  student: { id: number; name: string } | null;
}

export interface Booking {
  id: number;
  status: string;
  description: string | null;
  fullAddresses: string;
  startDate: string;
  endDate: string;
  vacancies: number;
  bookedCount: number;
  bookingType: BookingType | null;
  bookingStudents?: BookingStudent[];
  isRegistered: boolean;
  user?: { id: number; name: string } | null;
  createdAt?: string;
  updatedAt?: string;
}
