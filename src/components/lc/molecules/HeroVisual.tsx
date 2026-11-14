import { ArrowUpRight } from "lucide-react";
import { Eyebrow, LogoMark, Pill, Text } from "../atoms";
import { getIcon, type LcIconName } from "../icons";

/** Elementor widget: "LC Campaign Card" — the featured advert mockup in the hero. */
export interface CampaignCardProps {
  tag: string;
  eyebrow: string;
  eyebrowIcon?: LcIconName | undefined;
  title: string;
  body: string;
  ctaLabel: string;
  ctaSub: string;
  href?: string | undefined;
}

export function CampaignCard({ tag, eyebrow, eyebrowIcon, title, body, ctaLabel, ctaSub, href = "#clinics" }: CampaignCardProps) {
  return (
    <article className="lc-campaign">
      <div className="lc-campaign__top">
        <Pill label={tag} variant="glass" wide />
        <span className="lc-campaign__mark">
          <LogoMark />
        </span>
      </div>
      <Eyebrow label={eyebrow} icon={eyebrowIcon} tone="on-dark" />
      <h3 className="lc-campaign__title">{title}</h3>
      <Text size="small" onDark>
        {body}
      </Text>
      <a href={href} className="lc-campaign__cta">
        <span>
          <span className="lc-campaign__cta-label">{ctaLabel}</span>
          <br />
          <span className="lc-campaign__cta-sub">{ctaSub}</span>
        </span>
        <span className="lc-campaign__arrow">
          <ArrowUpRight aria-hidden />
        </span>
      </a>
    </article>
  );
}

/** Elementor widget: "LC Floating Note" — small overlapping info card. */
export function FloatingNote({ icon, title, subtitle, className }: { icon?: LcIconName | undefined; title: string; subtitle: string; className?: string | undefined }) {
  const Icon = getIcon(icon);
  return (
    <div className={`lc-float-note ${className ?? ""}`}>
      <span className="lc-icon-tile lc-icon-tile--soft lc-icon-tile--sm">
        <LogoMark />
      </span>
      <div>
        <div className="lc-float-note__title">
          {Icon && <Icon aria-hidden />}
          {title}
        </div>
        <div className="lc-float-note__sub">{subtitle}</div>
      </div>
    </div>
  );
}
