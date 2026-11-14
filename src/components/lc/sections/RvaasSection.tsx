import { DotGrid, Eyebrow, Heading, Pill, QuoteLine, Text } from "../atoms";
import { rvaas as defaults, rvaasPackages as pkgDefaults } from "../content";
import { MetricRow, ProcessStep } from "../molecules";
import { useSelection } from "../selection";
import { PricingGrid } from "./PricingGrid";

/** Section widget: "LC R-VaaS Intro" — copy column + dark metric panel. */
export function RvaasIntro({ data = defaults }: { data?: typeof defaults | undefined }) {
  return (
    <div className="lc-rvaas__top">
      <div className="lc-rvaas__copy">
        <div className="lc-hero__badges">
          <Pill label={data.badge} variant="mint" dot="static" wide />
          <Pill label={data.subBadge} variant="mint-soft" />
        </div>
        <Heading text={data.title} highlight={data.highlight} highlightTone="mint" level="h2" tone="purple" />
        <QuoteLine>{data.quote}</QuoteLine>
        <Text>{data.description}</Text>
        <div className="lc-rvaas__chips">
          {data.chips.map((c) => (
            <Pill key={c} label={c} variant="chip" />
          ))}
        </div>
      </div>
      <aside className="lc-rvaas__panel">
        <Eyebrow label={data.panel.eyebrow} icon="file" tone="on-dark" />
        <Heading text={data.panel.title} level="h3" tone="on-dark" />
        <Text size="small" onDark>
          {data.panel.body}
        </Text>
        <MetricRow items={data.panel.metrics} base="glass" />
        <DotGrid />
      </aside>
    </div>
  );
}

/** Section widget: "LC R-VaaS Process" — 4-step timeline. */
export function RvaasProcess({ data = defaults.process }: { data?: typeof defaults.process | undefined }) {
  return (
    <div className="lc-rvaas__process">
      <div className="lc-rvaas__process-head">
        <Heading text={data.title} level="h3" />
        <Eyebrow label={data.eyebrow} tone="mint" />
      </div>
      <div className="lc-grid lc-grid--4">
        {data.steps.map((s, i) => (
          <ProcessStep key={s.number} {...s} last={i === data.steps.length - 1} />
        ))}
      </div>
    </div>
  );
}

/** Section widget: "LC R-VaaS Packages". */
export function RvaasPackages({ data = pkgDefaults }: { data?: typeof pkgDefaults | undefined }) {
  const { rvaasPackage, setRvaasPackage, setTrack } = useSelection();
  return (
    <PricingGrid
      {...data}
      noteStyle="pill"
      theme="rvaas"
      ctaLabel="Choose this plan"
      ctaSelectedLabel="Selected — start with this plan"
      selectedId={rvaasPackage}
      onSelect={(id) => {
        setRvaasPackage(id);
        setTrack("rvaas");
      }}
    />
  );
}

/** Full researcher block on the mint background. */
export function RvaasSection() {
  return (
    <section id="rvaas" className="lc-section lc-section--mint">
      <div className="lc-container">
        <div className="lc-rvaas">
          <RvaasIntro />
          <RvaasProcess />
        </div>
        <RvaasPackages />
      </div>
    </section>
  );
}
