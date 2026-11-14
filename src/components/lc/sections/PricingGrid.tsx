import { Heading, Pill, Text } from "../atoms";
import { PricingCard, type PricingCardProps } from "../molecules";

/** Shared layout for both pricing sections: heading row + 3 Pricing Cards. */
export function PricingGrid({
  title,
  highlight,
  note,
  noteStyle = "text",
  items,
  theme,
  selectedId,
  onSelect,
  ctaLabel,
  ctaSelectedLabel,
}: {
  title: string;
  highlight?: string;
  note: string;
  noteStyle?: "text" | "pill";
  items: PricingCardProps[];
  theme: "clinic" | "rvaas";
  selectedId: string;
  onSelect: (id: string) => void;
  ctaLabel?: string;
  ctaSelectedLabel?: string;
}) {
  return (
    <>
      <div className="lc-pkg-head">
        <Heading text={title} highlight={highlight} highlightTone={theme === "rvaas" ? "mint" : "purple"} level="h2" />
        {noteStyle === "pill" ? <Pill label={note} variant="chip" /> : <Text size="small">{note}</Text>}
      </div>
      <div className="lc-grid lc-grid--3 lc-grid--pricing">
        {items.map((p) => (
          <PricingCard
            key={p.id}
            {...p}
            theme={theme}
            ctaLabel={ctaLabel}
            ctaSelectedLabel={ctaSelectedLabel}
            selected={selectedId === p.id}
            onSelect={() => onSelect(p.id)}
          />
        ))}
      </div>
    </>
  );
}
