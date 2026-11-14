import { DotGrid, Heading, Pill, Text } from "../atoms";
import { hero as defaults } from "../content";
import { ButtonGroup, CampaignCard, FloatingNote, StatGroup } from "../molecules";
import { TrackSelector } from "./TrackSelector";

/** Section widget: "LC Hero (Clinic)" — badges, heading, text, buttons, stats, campaign card. */
export function Hero({ data = defaults }: { data?: typeof defaults | undefined }) {
  return (
    <section id="top" className="lc-section--grid lc-hero">
      <div className="lc-container">
        <div className="lc-hero__grid">
          <div className="lc-hero__copy lc-reveal">
            <div className="lc-hero__badges">
              {data.badges.map((b) => (
                <Pill key={b.label} {...b} />
              ))}
            </div>
            <Heading text={data.title} highlight={data.highlight} level="hero" />
            <Text size="lead">{data.description}</Text>
            <ButtonGroup buttons={data.buttons} />
            <StatGroup items={data.stats} />
          </div>
          <div className="lc-hero__visual">
            <DotGrid />
            <CampaignCard {...data.campaign} />
            <FloatingNote {...data.note} className="lc-hero__note" />
          </div>
        </div>
        <TrackSelector />
      </div>
    </section>
  );
}
