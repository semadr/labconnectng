import { cx, splitHighlight } from "../utils";

export type HeadingLevel = "hero" | "h2" | "h3" | "h4";

/** Elementor widget: "LC Heading" — with a "Highlight words" control. */
export interface HeadingProps {
  text: string;
  highlight?: string | string[];
  highlightTone?: "purple" | "mint";
  level?: HeadingLevel;
  as?: "h1" | "h2" | "h3" | "h4" | "p";
  tone?: "ink" | "purple" | "on-dark";
  className?: string;
}

const defaultTag: Record<HeadingLevel, HeadingProps["as"]> = {
  hero: "h1",
  h2: "h2",
  h3: "h3",
  h4: "h3",
};

export function Heading({
  text,
  highlight,
  highlightTone = "purple",
  level = "h2",
  as,
  tone = "ink",
  className,
}: HeadingProps) {
  const Tag = as ?? defaultTag[level] ?? "h2";
  return (
    <Tag
      className={cx(
        "lc-heading",
        `lc-heading--${level}`,
        tone !== "ink" && `lc-heading--${tone}`,
        className,
      )}
    >
      {splitHighlight(text, highlight).map((seg, i) =>
        seg.hl ? (
          <span key={i} className={cx("lc-hl", highlightTone === "mint" && "lc-hl--mint")}>
            {seg.text}
          </span>
        ) : (
          <span key={i}>{seg.text}</span>
        ),
      )}
    </Tag>
  );
}
