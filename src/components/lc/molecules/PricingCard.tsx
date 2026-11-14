import { Button, CheckItem, Heading, Pill, Price, Text } from "../atoms";
import { cx } from "../utils";

/** Elementor widget: "LC Pricing Card" — use 3 side by side, one featured. */
export interface PricingCardProps {
  id: string;
  badge: string;
  name: string;
  amount: string;
  period?: string;
  description: string;
  features: string[];
  ctaLabel?: string;
  ctaSelectedLabel?: string;
  theme?: "clinic" | "rvaas";
  featured?: boolean;
  selected?: boolean;
  onSelect?: () => void;
}

export function PricingCard({
  badge,
  name,
  amount,
  period,
  description,
  features,
  ctaLabel = "Choose this package",
  ctaSelectedLabel = "Selected — start with this package",
  theme = "clinic",
  featured,
  selected,
  onSelect,
}: PricingCardProps) {
  const dark = featured && theme === "clinic";
  const badgeVariant = featured ? "mint" : theme === "rvaas" ? "mint-soft" : "outline";
  const btnVariant = selected ? (dark ? "accent" : theme === "rvaas" ? "primary" : "accent") : theme === "rvaas" ? "accent" : "primary";
  return (
    <article
      className={cx(
        "lc-card lc-pricing-card",
        theme === "rvaas" && "lc-pricing-card--mint",
        featured && "lc-pricing-card--featured",
        selected && "is-selected",
      )}
    >
      <Pill label={badge} variant={badgeVariant} className="lc-pricing-card__badge" icon={featured ? "sparkles" : undefined} />
      <Heading text={name} level="h4" />
      <Price amount={amount} period={period} onDark={dark} />
      <Text size="small">{description}</Text>
      <ul className="lc-pricing-card__features">
        {features.map((f) => (
          <CheckItem
            key={f}
            label={f}
            variant={theme === "rvaas" ? "circle" : "tick"}
            tone={dark ? "mint" : "purple"}
            onDark={dark}
          />
        ))}
      </ul>
      <div className="lc-pricing-card__cta">
        <Button
          label={selected ? ctaSelectedLabel : ctaLabel}
          variant={btnVariant}
          icon={selected ? "badge-check" : undefined}
          iconPosition="before"
          block
          onClick={onSelect}
        />
      </div>
    </article>
  );
}
