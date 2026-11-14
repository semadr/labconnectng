/** Tiny class joiner — keeps lc-* class names untouched (no Tailwind merging). */
export function cx(...parts: Array<string | false | null | undefined>) {
  return parts.filter(Boolean).join(" ");
}

/**
 * Splits `text` into plain / highlighted segments.
 * Mirrors the Elementor "Highlight words" control: type the words to colour.
 */
export function splitHighlight(text: string, highlight?: string | string[]) {
  const words = (Array.isArray(highlight) ? highlight : highlight ? [highlight] : []).filter(Boolean);
  if (!words.length) return [{ text, hl: false }];
  const escaped = words.map((w) => w.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"));
  const re = new RegExp(`(${escaped.join("|")})`, "g");
  return text
    .split(re)
    .filter((s) => s !== "")
    .map((s) => ({ text: s, hl: words.includes(s) }));
}
