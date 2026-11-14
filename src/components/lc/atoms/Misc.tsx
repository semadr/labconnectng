import { Star } from "lucide-react";
import { cx } from "../utils";

/** Elementor widget: "LC Stars" — rating row. */
export function Stars({ count = 5 }: { count?: number }) {
  return (
    <span className="lc-stars" role="img" aria-label={`${count} out of 5 stars`}>
      {Array.from({ length: count }).map((_, i) => (
        <Star key={i} aria-hidden />
      ))}
    </span>
  );
}

/** Elementor widget: "LC Avatar" — initials circle. */
export function Avatar({ initials, tone = "purple" }: { initials: string; tone?: "purple" | "mint" }) {
  return <span className={cx("lc-avatar", tone === "mint" && "lc-avatar--mint")}>{initials}</span>;
}

/** Elementor widget: "LC Step Number" — "01" as circle or big serif numeral. */
export function StepNumber({ value, variant = "circle" }: { value: string; variant?: "circle" | "big" }) {
  return <span className={cx("lc-step-num", `lc-step-num--${variant}`)}>{value}</span>;
}

/** Elementor widget: "LC Price" — amount + period. */
export function Price({ amount, period, onDark }: { amount: string; period?: string; onDark?: boolean }) {
  return (
    <div className={cx("lc-price", onDark && "lc-price--on-dark")}>
      <span className="lc-price__amount">{amount}</span>
      {period && <span className="lc-price__period">{period}</span>}
    </div>
  );
}

/** Decorative dot grid (absolute-positioned). */
export function DotGrid({ className }: { className?: string }) {
  return <span className={cx("lc-dots", className)} aria-hidden />;
}
