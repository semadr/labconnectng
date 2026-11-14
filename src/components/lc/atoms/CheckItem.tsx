import { Check } from "lucide-react";
import { cx } from "../utils";

/** Elementor widget: "LC Check Item" — feature list row (use in repeaters). */
export interface CheckItemProps {
  label: string;
  variant?: "tick" | "circle" | undefined;
  tone?: "purple" | "mint" | undefined;
  onDark?: boolean | undefined;
}

export function CheckItem({ label, variant = "tick", tone = "purple", onDark }: CheckItemProps) {
  return (
    <li
      className={cx(
        "lc-check",
        variant === "circle" && "lc-check--circle",
        tone === "mint" && "lc-check--mint",
        onDark && "lc-check--on-dark",
      )}
    >
      <Check className="lc-check__icon" strokeWidth={3} aria-hidden />
      <span>{label}</span>
    </li>
  );
}
