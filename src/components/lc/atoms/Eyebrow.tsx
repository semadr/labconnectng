import { getIcon, type LcIconName } from "../icons";
import { cx } from "../utils";

/** Elementor widget: "LC Eyebrow" — small uppercase kicker above headings. */
export interface EyebrowProps {
  label: string;
  tone?: "purple" | "mint" | "on-dark";
  icon?: LcIconName;
}

export function Eyebrow({ label, tone = "purple", icon }: EyebrowProps) {
  const Icon = getIcon(icon);
  return (
    <span className={cx("lc-eyebrow", tone !== "purple" && `lc-eyebrow--${tone}`)}>
      {Icon && <Icon className="lc-eyebrow__icon" aria-hidden />}
      {label}
    </span>
  );
}
