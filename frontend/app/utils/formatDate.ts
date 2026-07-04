const weekDays: Record<number, string> = {
  0: "Domingo",
  1: "Segunda-feira",
  2: "Terça-feira",
  3: "Quarta-feira",
  4: "Quinta-feira",
  5: "Sexta-feira",
  6: "Sábado",
};

function parseDate(dateStr: string | null): { year: string; month: string; day: string } | null {
  if (!dateStr) return null;
  const [datePart] = dateStr.split(" ");
  if (!datePart) return null;
  const [year, month, day] = datePart.split("-");
  if (!year || !month || !day) return null;
  return { year, month, day };
}

export function brDate(dateStr: string | null): string {
  const p = parseDate(dateStr);
  if (!p) return "-";
  const date = new Date(Number(p.year), Number(p.month) - 1, Number(p.day));
  const weekDay = weekDays[date.getDay()] ?? "";
  return `${p.day}/${p.month}/${p.year} \u2014 ${weekDay}`;
}

export function brDateShort(dateStr: string | null): string {
  const p = parseDate(dateStr);
  if (!p) return "-";
  return `${p.day}/${p.month}/${p.year}`;
}

export function brTime(dateStr: string | null): string {
  if (!dateStr) return "";
  const [, timePart] = dateStr.split(" ");
  return timePart?.slice(0, 5) ?? "";
}
