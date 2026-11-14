import { cx } from "../utils";

export interface StatItem {
  value: string;
  label: string;
}

/** Elementor widget: "LC Stat Card". */
export function StatCard({ value, label }: StatItem) {
  return (
    <div className="lc-stat">
      <div className="lc-stat__value">{value}</div>
      <div className="lc-stat__label">{label}</div>
    </div>
  );
}

/** Elementor widget: "LC Stat Group" — repeater of StatCards. */
export function StatGroup({ items }: { items: StatItem[] }) {
  return (
    <div className="lc-stat-group">
      {items.map((s) => (
        <StatCard key={s.label} {...s} />
      ))}
    </div>
  );
}

export interface MetricItem {
  value: string;
  label: string;
  highlight?: boolean | undefined;
}

/** Elementor widget: "LC Metric Tile" — e.g. "1 · Core message". */
export function MetricTile({
  value,
  label,
  variant = "white",
}: {
  value: string;
  label: string;
  variant?: "white" | "glass" | "mint" | undefined;
}) {
  return (
    <div className={cx("lc-metric", variant !== "white" && `lc-metric--${variant}`)}>
      <span className="lc-metric__value">{value}</span>
      <span className="lc-metric__label">{label}</span>
    </div>
  );
}

/** Elementor widget: "LC Metric Row" — 3 metric tiles, one highlighted. */
export function MetricRow({ items, base = "white" }: { items: MetricItem[]; base?: "white" | "glass" }) {
  return (
    <div className="lc-metric-row">
      {items.map((m) => (
        <MetricTile key={m.label} value={m.value} label={m.label} variant={m.highlight ? "mint" : base} />
      ))}
    </div>
  );
}
