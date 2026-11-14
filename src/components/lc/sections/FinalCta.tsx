import { DotGrid, Heading, LogoMark, Text } from "../atoms";
import { clinicPackages, finalCta as defaults, rvaasPackages, whatsappLink } from "../content";
import { ButtonGroup, TrustRow } from "../molecules";
import { useSelection } from "../selection";

/** Section widget: "LC Final CTA" — two WhatsApp buttons that carry the chosen package. */
export function FinalCta({ data = defaults }: { data?: typeof defaults | undefined }) {
  const { clinicPackage, rvaasPackage } = useSelection();
  const clinic = clinicPackages.items.find((p) => p.id === clinicPackage);
  const research = rvaasPackages.items.find((p) => p.id === rvaasPackage);
  const clinicMsg = `Hello LabConnect, I run a health business and I'd like to start with the ${clinic?.name} package (${clinic?.amount} ${clinic?.period}).`;
  const researchMsg = `Hello LabConnect, I am a researcher and I'd like to start R-VaaS with the ${research?.name} plan (${research?.amount} ${research?.period}).`;
  return (
    <section id="contact" className="lc-section">
      <div className="lc-container">
        <div className="lc-final-cta">
          <DotGrid className="lc-dots--a" />
          <DotGrid className="lc-dots--b" />
          <span className="lc-final-cta__mark">
            <LogoMark />
          </span>
          <Heading text={data.title} highlight={data.highlight} level="h2" tone="on-dark" />
          <Text size="lead" onDark>
            {data.description}
          </Text>
          <ButtonGroup
            align="center"
            buttons={[
              { label: data.clinicLabel, href: whatsappLink(clinicMsg), external: true, variant: "light", size: "lg", icon: "arrow-right" },
              { label: data.rvaasLabel, href: whatsappLink(researchMsg), external: true, variant: "accent", size: "lg" },
            ]}
          />
          <p className="lc-final-cta__summary" aria-live="polite">
            Clinic track: <strong>{clinic?.name}</strong> · R-VaaS: <strong>{research?.name}</strong>
          </p>
          <TrustRow items={data.trust} align="center" onDark />
        </div>
      </div>
    </section>
  );
}
