import { Heading, type HeadingLevel, Pill, type PillVariant, Text } from "../atoms";
import { cx } from "../utils";

/** Elementor widget: "LC Section Header" — badge + heading + description. */
export interface SectionHeaderProps {
  badge?: string | undefined;
  badgeVariant?: PillVariant | undefined;
  title: string;
  highlight?: string | string[] | undefined;
  highlightTone?: "purple" | "mint" | undefined;
  description?: string | undefined;
  align?: "split" | "center" | "left" | undefined;
  level?: HeadingLevel | undefined;
  className?: string | undefined;
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
