import { marquee as defaults } from "../content";
import { Marquee } from "../molecules";

/** Section widget: "LC Rolling Bar" — full-width Marquee. */
export function TrustMarquee({ items = defaults }: { items?: string[] }) {
  return <Marquee items={items} />;
}
