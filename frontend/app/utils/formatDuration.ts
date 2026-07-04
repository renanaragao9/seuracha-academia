export function formatDuration(minutes: number | null | undefined): string {
  if (minutes == null || isNaN(minutes)) return "-";

  const totalSeconds = Math.round(minutes * 60);
  const h = Math.floor(totalSeconds / 3600);
  const m = Math.floor((totalSeconds % 3600) / 60);
  const s = totalSeconds % 60;

  const parts: string[] = [];
  if (h > 0) parts.push(`${h}h`);
  if (m > 0) parts.push(`${m}min`);
  if (s > 0) parts.push(`${s}s`);
  if (parts.length === 0) return "0s";

  return parts.join(" ");
}
