export interface AcademyConfig {
  id: number;
  name: string;
  cnpj: string | null;
  description: string | null;
  contact: {
    email: string | null;
    phone: string | null;
    whatsapp: string | null;
    emergencyPhone: string | null;
  };
  address: {
    zipCode: string | null;
    street: string | null;
    number: string | null;
    complement: string | null;
    neighborhood: string | null;
    city: string | null;
    state: string | null;
    full: string | null;
  };
  social: {
    website: string | null;
    instagram: string | null;
    facebook: string | null;
    youtube: string | null;
  };
  branding: {
    logo: string | null;
    logoUrl: string | null;
    favicon: string | null;
    faviconUrl: string | null;
  };
  schedule: {
    openingHours: string | null;
    openingTime: string | null;
    closingTime: string | null;
  };
  settings: {
    allowStudentRegistration: boolean;
    allowOnlineAssessments: boolean;
    sendEmailNotifications: boolean;
    sendWhatsappNotifications: boolean;
    defaultTrainingDurationDays: number | null;
    defaultAssessmentDurationDays: number | null;
    maxWorkoutsPerStudent: number | null;
  };
  isActive: boolean;
}
