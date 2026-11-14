import { getIcon, type LcIconName } from "../icons";
import { cx } from "../utils";

/** Elementor widget: "LC Icon Tile" — icon in a rounded square. */
export interface IconTileProps {
  icon: LcIconName;
  tone?: "purple" | "mint" | "soft" | "white" | undefined;
  size?: "sm" | "md" | "lg" | undefined;
}

export function IconTile({ icon, tone = "purple", size = "md" }: IconTileProps) {
  const Icon = getIcon(icon);
  return (
    <span
      className={cx(
        "lc-icon-tile",
        tone !== "purple" && `lc-icon-tile--${tone}`,
        size !== "md" && `lc-icon-tile--${size}`,
      )}
      aria-hidden
    >
      {Icon && <Icon />}
    </span>
  );
}
