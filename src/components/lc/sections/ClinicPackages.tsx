import { clinicPackages as defaults } from "../content";
import { useSelection } from "../selection";
import { PricingGrid } from "./PricingGrid";

/** Section widget: "LC Clinic Packages". */
export function ClinicPackages({ data = defaults }: { data?: typeof defaults | undefined }) {
  const { clinicPackage, setClinicPackage, setTrack } = useSelection();
  return (
    <section id="packages" className="lc-section" style={{ paddingTop: 0 }}>
      <div className="lc-container">
        <PricingGrid
          {...data}
          theme="clinic"
          selectedId={clinicPackage}
          onSelect={(id) => {
            setClinicPackage(id);
            setTrack("clinic");
          }}
        />
      </div>
    </section>
  );
}
