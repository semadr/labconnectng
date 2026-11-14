import { Heading, IconTile, Text } from "../atoms";
import type { LcIconName } from "../icons";

/** Elementor widget: "LC Service Card". */
export interface ServiceCardProps {
  icon: LcIconName;
  title: string;
  description: string;
}

export function ServiceCard({ icon, title, description }: ServiceCardProps) {
  return (
    <article className="lc-card lc-card--hover lc-service-card">
      <IconTile icon={icon} />
      <Heading text={title} level="h4" className="lc-service-card__title" />
      <Text size="small">{description}</Text>
    </article>
  );
}
