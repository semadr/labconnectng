import logoAsset from "@/assets/labconnect-logo.png.asset.json";
import { cx } from "../utils";

/**
 * Elementor widget: "LC Logo Mark" — the bridge icon drawn as SVG
 * (purple node + ring linked to the mint hub). Use as bullet, badge, divider.
 */
export function LogoMark({ onDark, className }: { onDark?: boolean | undefined; className?: string | undefined }) {
  return (
    <svg
      viewBox="0 0 64 64"
      className={cx("lc-logomark", onDark && "lc-logomark--on-dark", className)}
      aria-hidden
    >
      <line x1="20" y1="18" x2="36" y2="36" className="lc-logomark__link" strokeWidth="5" strokeLinecap="round" />
      <line x1="16" y1="50" x2="36" y2="42" className="lc-logomark__link" strokeWidth="5" strokeLinecap="round" />
      <circle cx="18" cy="16" r="8" className="lc-logomark__node" />
      <circle cx="14" cy="50" r="6" className="lc-logomark__ring" strokeWidth="5" />
      <circle cx="42" cy="38" r="12" className="lc-logomark__hub" />
    </svg>
  );
}

/** Elementor widget: "LC Logo" — full logo image linking home. */
export interface LogoProps {
  href?: string | undefined;
  src?: string | undefined;
  alt?: string | undefined;
}

export function Logo({ href = "#top", src = logoAsset.url, alt = "LabConnect — Build the bridge" }: LogoProps) {
  return (
    <a href={href} className="lc-logo" aria-label="LabConnect home">
      <img src={src} alt={alt} width={164} height={34} />
    </a>
  );
}
