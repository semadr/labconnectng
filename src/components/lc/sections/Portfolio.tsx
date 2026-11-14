import { portfolio as defaults } from "../content";
import { SectionHeader, WorkCard } from "../molecules";

/** Section widget: "LC Portfolio Gallery" — Section Header + Work Card repeater. */
export function Portfolio({ data = defaults }: { data?: typeof defaults }) {
  return (
    <section id="work" className="lc-section">
      <div className="lc-container">
        <SectionHeader badge={data.badge} title={data.title} description={data.description} />
        <div className="lc-grid lc-grid--3">
          {data.items.map((w) => (
            <WorkCard key={w.title} {...w} />
          ))}
        </div>
      </div>
    </section>
  );
}
