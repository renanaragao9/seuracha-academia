export function timeAgo(dateStr: string | null | undefined): string {
  if (!dateStr) return "";

  const date = new Date(dateStr.replace(" ", "T"));
  const now = new Date();
  const diffMs = now.getTime() - date.getTime();

  if (diffMs < 0) return "agora";

  const seconds = Math.floor(diffMs / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);
  const weeks = Math.floor(days / 7);
  const months = Math.floor(days / 30);
  const years = Math.floor(days / 365);

  if (seconds < 60) return "Há menos de um minuto";
  if (minutes === 1) return "Há 1 minuto";
  if (minutes < 60) return `Há ${minutes} minutos`;
  if (hours === 1) return "Há 1 hora";
  if (hours < 24) return `Há ${hours} horas`;
  if (days === 1) return "Há 1 dia";
  if (days < 7) return `Há ${days} dias`;
  if (weeks === 1) return "Há 1 semana";
  if (weeks < 5) return `Há ${weeks} semanas`;
  if (months === 1) return "Há 1 mês";
  if (months < 12) return `Há ${months} meses`;
  if (years === 1) return "Há 1 ano";
  return `Há ${years} anos`;
}
