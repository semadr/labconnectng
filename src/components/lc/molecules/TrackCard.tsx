import { ArrowRight } from "lucide-react";
import { Heading, IconTile, Pill, Text } from "../atoms";
import type { LcIconName } from "../icons";
import { cx } from "../utils";

/** Elementor widget: "LC Track Card" — selectable audience card. */
export interface TrackCardProps {
  icon: LcIconName;
  title: string;
  badge?: string;
  description: string;
  linkLabel: string;
  theme?: "purple" | "mint";
  selected?: boolean;
  onSelect?: () => void;
}

export function TrackCard({
  icon,
  title,
  badge,
  description,
  linkLabel,
  theme = "purple",
  selected,
  onSelect,
}: TrackCardProps) {
  return (
    <button
      type="button"
      onClick={onSelect}
      aria-pressed={selected}
      className={cx("lc-card lc-track-card", theme === "mint" && "lc-track-card--mint", selected && "is-selected")}
    >
      <div className="lc-track-card__top">
        <IconTile icon={icon} tone={theme === "mint" ? "mint" : "purple"} />
        <Pill
          label={selected ? "Selected" : "Select"}
          variant={selected ? (theme === "mint" ? "mint" : "dark") : "outline"}
          dot={selected ? "static" : undefined}
        />
      </div>
      <div className="lc-track-card__title">
        <Heading text={title} level="h4" as="p" />
        {badge && <Pill label={badge} variant="mint" />}
      </div>
      <Text size="small">{description}</Text>
      <span className="lc-track-card__link">
        {linkLabel} <ArrowRight aria-hidden />
      </span>
    </button>
  );
}
