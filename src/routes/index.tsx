import { createFileRoute } from "@tanstack/react-router";
import { SelectionProvider } from "@/components/lc/selection";
import {
  ClinicPackages,
  ClinicServices,
  FinalCta,
  Hero,
  HowItWorksSection,
  Portfolio,
  RvaasSection,
  SiteFooter,
  SiteHeader,
  TrustMarquee,
} from "@/components/lc/sections";

export const Route = createFileRoute("/")({
  head: () => ({
    meta: [
      { title: "LabConnect NG — Adverts for Health Businesses & R-VaaS for Researchers" },
      {
        name: "description",
        content:
          "Scroll-stopping adverts for labs, pharmacies, clinics and hospitals — plus R-VaaS, Research Visibility as a Service, that turns papers into visuals people share and cite.",
      },
      { property: "og:title", content: "LabConnect NG — Build the bridge to better health" },
      {
        property: "og:description",
        content: "Medical advert designs for health businesses and Research Visibility as a Service (R-VaaS) for researchers.",
      },
      { property: "og:type", content: "website" },
      { name: "twitter:card", content: "summary_large_image" },
    ],
  }),
  component: Index,
});

function Index() {
  return (
    <SelectionProvider>
      <div className="lc-root">
        <SiteHeader />
        <main>
          <Hero />
          <TrustMarquee />
          <ClinicServices />
          <ClinicPackages />
          <RvaasSection />
          <Portfolio />
          <HowItWorksSection />
          <FinalCta />
        </main>
        <SiteFooter />
      </div>
    </SelectionProvider>
  );
}
