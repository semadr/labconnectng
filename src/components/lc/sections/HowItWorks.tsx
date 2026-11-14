import { howItWorks as defaults, testimonials as tDefaults } from "../content";
import { SectionHeader, StepCard, TestimonialCard, type TestimonialCardProps } from "../molecules";

/** Section widget: "LC How It Works" — centered header + 3 Step Cards. */
export function HowItWorks({ data = defaults }: { data?: typeof defaults | undefined }) {
  return (
    <>
      <SectionHeader badge={data.badge} title={data.title} description={data.description} align="center" />
      <div className="lc-grid lc-grid--3">
        {data.steps.map((s) => (
          <StepCard key={s.number} {...s} />
        ))}
      </div>
    </>
  );
}

/** Section widget: "LC Testimonials" — Testimonial Card repeater. */
export function Testimonials({ items = tDefaults }: { items?: TestimonialCardProps[] | undefined }) {
  return (
    <div className="lc-grid lc-grid--2 lc-testimonials">
      {items.map((t) => (
        <TestimonialCard key={t.name} {...t} />
      ))}
    </div>
  );
}

export function HowItWorksSection() {
  return (
    <section id="how" className="lc-section lc-section--lavender">
      <div className="lc-container">
        <HowItWorks />
        <Testimonials />
      </div>
    </section>
  );
}
