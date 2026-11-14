import { Heading, type HeadingLevel, Pill, type PillVariant, Text } from "../atoms";
import { cx } from "../utils";

/** Elementor widget: "LC Section Header" — badge + heading + description. */
export interface SectionHeaderProps {
  badge?: string;
  badgeVariant?: PillVariant;
  title: string;
  highlight?: string | string[];
  highlightTone?: "purple" | "mint";
  description?: string;
  align?: "split" | "center" | "left";
  level?: HeadingLevel;
  className?: string;
}

export function SectionHeader({
  badge,
  badgeVariant = "dark",
  title,
  highlight,
  highlightTone,
  description,
  align = "split",
  level = "h2",
  className,
}: SectionHeaderProps) {
  return (
    <header className={cx("lc-section-header", `lc-section-header--${align}`, className)}>
      <div className="lc-section-header__main">
        {badge && <Pill label={badge} variant={badgeVariant} dot="static" wide />}
        <Heading text={title} highlight={highlight} highlightTone={highlightTone} level={level} />
      </div>
      {description && <Text size="lead">{description}</Text>}
    </header>
  );
}
