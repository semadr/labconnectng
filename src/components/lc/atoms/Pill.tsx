import { getIcon, type LcIconName } from "../icons";
import { cx } from "../utils";

export type PillVariant = "outline" | "dark" | "mint" | "mint-soft" | "glass" | "chip";

/** Elementor widget: "LC Badge / Pill". */
export interface PillProps {
  label: string;
  variant?: PillVariant;
  dot?: "static" | "live";
  icon?: LcIconName;
  wide?: boolean;
  className?: string;
}

export function Pill({ label, variant = "outline", dot, icon, wide, className }: PillProps) {
  const Icon = getIcon(icon);
  return (
    <span className={cx("lc-pill", `lc-pill--${variant}`, wide && "lc-pill--wide", className)}>
      {dot && <span className={cx("lc-pill__dot", dot === "live" && "lc-pill__dot--live")} />}
      {Icon && <Icon className="lc-pill__icon" aria-hidden />}
      {label}
    </span>
  );
}
