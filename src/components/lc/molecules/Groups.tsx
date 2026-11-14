import { Button, type ButtonProps } from "../atoms";
import { getIcon, type LcIconName } from "../icons";
import { cx } from "../utils";

/** Elementor widget: "LC Button Group" — repeater of buttons. */
export function ButtonGroup({ buttons, align = "start" }: { buttons: ButtonProps[]; align?: "start" | "center" | undefined }) {
  return (
    <div className={cx("lc-btn-group", align === "center" && "lc-btn-group--center")}>
      {buttons.map((b) => (
        <Button key={b.label} {...b} />
      ))}
    </div>
  );
}

export interface TrustItem {
  icon: LcIconName;
  label: string;
}

/** Elementor widget: "LC Trust Row" — small icon + label promises. */
export function TrustRow({
  items,
  align = "start",
  onDark,
}: {
  items: TrustItem[];
  align?: "start" | "center" | undefined;
  onDark?: boolean | undefined;
}) {
  return (
    <ul className={cx("lc-trust-row", align === "center" && "lc-trust-row--center", onDark && "lc-trust-row--on-dark")}>
      {items.map((t) => {
        const Icon = getIcon(t.icon);
        return (
          <li key={t.label} className="lc-trust-row__item">
            {Icon && <Icon aria-hidden />}
            {t.label}
          </li>
        );
      })}
    </ul>
  );
}
