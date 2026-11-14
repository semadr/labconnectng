import { createFileRoute } from "@tanstack/react-router";
import type { ReactNode } from "react";
import {
  Avatar,
  Button,
  CheckItem,
  Eyebrow,
  Heading,
  IconTile,
  Logo,
  LogoMark,
  Pill,
  Price,
  QuoteLine,
  Stars,
  StepNumber,
  Text,
} from "@/components/lc/atoms";
import { clinicPackages, clinicServices, hero, howItWorks, marquee, portfolio, rvaas, testimonials, tracks } from "@/components/lc/content";
import {
  ButtonGroup,
  CampaignCard,
  FloatingNote,
  FooterColumn,
  Marquee,
  MetricRow,
  NavMenu,
  PricingCard,
  ProcessStep,
  SectionHeader,
  ServiceCard,
  StatCard,
  StepCard,
  TestimonialCard,
  TrackCard,
  TrustRow,
  WorkCard,
} from "@/components/lc/molecules";

export const Route = createFileRoute("/widgets")({
  head: () => ({
    meta: [
      { title: "LabConnect Widget Library — Atoms & Molecules" },
      { name: "description", content: "Every reusable LabConnect building block, shown on its own for the Elementor widget plugin." },
      { property: "og:title", content: "LabConnect Widget Library" },
      { property: "og:description", content: "Reusable LabConnect building blocks for the Elementor plugin." },
      { property: "og:type", content: "website" },
      { name: "twitter:card", content: "summary" },
      { name: "robots", content: "noindex" },
    ],
  }),
  component: WidgetLibrary,
});

function Item({ name, widget, dark, children }: { name: string; widget: string; dark?: boolean; children: ReactNode }) {
  return (
    <div className="lc-lib__item">
      <div className="lc-lib__label">
        <strong>{widget}</strong> <code>{name}</code>
      </div>
      <div className={`lc-lib__stage${dark ? " lc-lib__stage--dark" : ""}`}>{children}</div>
    </div>
  );
}

function WidgetLibrary() {
  return (
    <div className="lc-root">
      <div className="lc-container" style={{ paddingBlock: "3rem 5rem" }}>
        <SectionHeader
          badge="Widget library"
          title="Every building block, on its own."
          highlight="on its own."
          description="Atoms are the smallest pieces. Molecules combine atoms. Sections on the home page only arrange molecules — so each piece here becomes its own Elementor widget."
          align="left"
        />
        <Button label="Back to the page" href="/" variant="outline" size="sm" icon="arrow-right" />

        <section className="lc-lib__group">
          <Heading text="Atoms" level="h3" />
          <Item widget="LC Button" name="<Button variant>">
            <Button label="Primary" icon="arrow-right" />
            <Button label="Accent" variant="accent" />
            <Button label="Outline" variant="outline" />
            <Button label="Ghost link" variant="ghost" icon="arrow-right" />
            <Button label="Small" size="sm" />
          </Item>
          <Item widget="LC Button (on dark)" name="<Button variant='light'>" dark>
            <Button label="Light" variant="light" icon="arrow-right" />
            <Button label="Accent" variant="accent" />
          </Item>
          <Item widget="LC Badge / Pill" name="<Pill variant>">
            <Pill label="Outline" />
            <Pill label="Dark + dot" variant="dark" dot="static" wide />
            <Pill label="Mint" variant="mint" />
            <Pill label="Live" variant="mint-soft" dot="live" icon="sparkles" />
            <Pill label="Chip" variant="chip" />
          </Item>
          <Item widget="LC Eyebrow" name="<Eyebrow tone>">
            <Eyebrow label="Choose your track" />
            <Eyebrow label="Repeatable process" tone="mint" />
            <Eyebrow label="With icon" icon="file" />
          </Item>
          <Item widget="LC Heading" name="<Heading level highlight>">
            <div className="lc-stack">
              <Heading text="Hero heading with highlight." highlight="highlight." level="hero" />
              <Heading text="Section heading" level="h2" />
              <Heading text="Card heading" level="h3" />
              <Heading text="Small title" level="h4" />
            </div>
          </Item>
          <Item widget="LC Text / Quote line" name="<Text size> <QuoteLine>">
            <div className="lc-stack">
              <Text size="lead">Lead paragraph for introductions.</Text>
              <Text>Body paragraph text.</Text>
              <QuoteLine>{rvaas.quote}</QuoteLine>
            </div>
          </Item>
          <Item widget="LC Icon Tile" name="<IconTile tone size>">
            <IconTile icon="heart" />
            <IconTile icon="flask" tone="mint" />
            <IconTile icon="megaphone" tone="soft" />
            <IconTile icon="share" tone="white" />
            <IconTile icon="pen" size="sm" />
          </Item>
          <Item widget="LC Logo / Logo Mark" name="<Logo> <LogoMark>">
            <Logo />
            <LogoMark />
          </Item>
          <Item widget="LC Check Item" name="<CheckItem variant>">
            <ul className="lc-stack">
              <CheckItem label="Tick style" />
              <CheckItem label="Circle style" variant="circle" />
            </ul>
          </Item>
          <Item widget="LC Price · Stars · Avatar · Step Number" name="<Price> <Stars> <Avatar> <StepNumber>">
            <Price amount="₦45,000" period="/ week" />
            <Stars />
            <Avatar initials="CO" />
            <Avatar initials="PhD" tone="mint" />
            <StepNumber value="01" />
            <StepNumber value="02" variant="big" />
          </Item>
        </section>

        <section className="lc-lib__group">
          <Heading text="Molecules" level="h3" />
          <Item widget="LC Section Header" name="<SectionHeader align>">
            <div style={{ width: "100%" }}>
              <SectionHeader badge="Selected work" title="Two tracks. One visual standard." description="Split layout header." />
            </div>
          </Item>
          <Item widget="LC Button Group · Trust Row" name="<ButtonGroup> <TrustRow>">
            <div className="lc-stack">
              <ButtonGroup buttons={hero.buttons} />
              <TrustRow items={[{ icon: "badge-check", label: "Clear packages" }, { icon: "calendar", label: "Fast turnaround" }]} />
            </div>
          </Item>
          <Item widget="LC Stat Card · Metric Row" name="<StatCard> <MetricRow>">
            <StatCard {...hero.stats[0]!} />
            <div className="lc-grow">
              <MetricRow items={rvaas.panel.metrics} />
            </div>
          </Item>
          <Item widget="LC Service Card · Track Card" name="<ServiceCard> <TrackCard>">
            <div className="lc-grow">
              <ServiceCard {...clinicServices.items[0]!} />
            </div>
            <div className="lc-grow">
              <TrackCard {...tracks.items[1]!} selected />
            </div>
          </Item>
          <Item widget="LC Pricing Card" name="<PricingCard theme featured>">
            <div className="lc-grow">
              <PricingCard {...clinicPackages.items[0]!} />
            </div>
            <div className="lc-grow">
              <PricingCard {...clinicPackages.items[1]!} selected />
            </div>
          </Item>
          <Item widget="LC Process Step · Step Card" name="<ProcessStep> <StepCard>">
            <div className="lc-grow">
              <ProcessStep {...rvaas.process.steps[0]!} />
            </div>
            <div className="lc-grow">
              <StepCard {...howItWorks.steps[0]!} />
            </div>
          </Item>
          <Item widget="LC Testimonial Card" name="<TestimonialCard tone>">
            <div className="lc-grow">
              <TestimonialCard {...testimonials[0]!} />
            </div>
            <div className="lc-grow">
              <TestimonialCard {...testimonials[1]!} />
            </div>
          </Item>
          <Item widget="LC Work Card" name="<WorkCard kind theme>">
            {portfolio.items.slice(2, 5).map((w) => (
              <div className="lc-grow" key={w.title}>
                <WorkCard {...w} />
              </div>
            ))}
          </Item>
          <Item widget="LC Campaign Card · Floating Note" name="<CampaignCard> <FloatingNote>">
            <div className="lc-grow">
              <CampaignCard {...hero.campaign} />
            </div>
            <FloatingNote {...hero.note} />
          </Item>
          <Item widget="LC Nav Menu · Footer Column" name="<NavMenu> <FooterColumn>">
            <NavMenu links={[{ label: "Packages", href: "#" }, { label: "Work", href: "#" }]} />
            <FooterColumn title="Researchers" links={[{ label: "Graphical Abstracts", href: "#" }, { label: "Posters", href: "#" }]} />
          </Item>
          <Item widget="LC Marquee" name="<Marquee speed reverse>">
            <div style={{ width: "100%" }}>
              <Marquee items={marquee} />
            </div>
          </Item>
        </section>
      </div>
    </div>
  );
}
