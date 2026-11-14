import { clinicServices as defaults } from "../content";
import { SectionHeader, ServiceCard } from "../molecules";

/** Section widget: "LC Services Grid" — Section Header + Service Card repeater. */
export function ClinicServices({ data = defaults }: { data?: typeof defaults }) {
  return (
    <section id="clinics" className="lc-section">
      <div className="lc-container">
        <SectionHeader badge={data.badge} title={data.title} highlight={data.highlight} description={data.description} />
        <div className="lc-grid lc-grid--4">
          {data.items.map((s) => (
            <ServiceCard key={s.title} {...s} />
          ))}
        </div>
      </div>
    </section>
  );
}
