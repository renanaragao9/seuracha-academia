export function phoneMask(event: Event): string {
  const input = event.target as HTMLInputElement;
  const digits = input.value.replace(/\D/g, "").slice(0, 11);
  let masked = "";
  if (digits.length > 0) masked = `(${digits.slice(0, 2)}`;
  if (digits.length > 2) masked += `) ${digits[2]}`;
  if (digits.length > 3) masked += `-${digits.slice(3, 7)}`;
  if (digits.length > 7) masked += `-${digits.slice(7)}`;
  return masked;
}

export function preventNonDigit(event: KeyboardEvent): void {
  if (event.key === "Backspace" || event.key === "Delete" || event.key === "Tab" || event.key === "ArrowLeft" || event.key === "ArrowRight") return;
  if (!/^\d$/.test(event.key)) event.preventDefault();
}

