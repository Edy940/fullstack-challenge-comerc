export function required(v: any, label = "Campo"): string | null {
  if (v === undefined || v === null || (typeof v === "string" && v.trim() === "")) return `${label} é obrigatório`;
  return null;
}
export function email(v: string, label = "E-mail"): string | null {
  if (!v) return null;
  const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
  return ok ? null : `${label} inválido`;
}
export function minValue(n: number, label = "Valor", min = 0): string | null {
  if (n === undefined || n === null) return null;
  return Number(n) >= min ? null : `${label} deve ser  ${min}`;
}