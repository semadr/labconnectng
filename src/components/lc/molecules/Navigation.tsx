import { Fragment } from "react";
import { cx } from "../utils";

export interface NavLink {
  label: string;
  href: string;
  accent?: string | undefined;
}

/** Elementor widget: "LC Nav Menu". */
export function NavMenu({
  links,
  orientation = "horizontal",
  onNavigate,
}: {
  links: NavLink[];
  orientation?: "horizontal" | "vertical" | undefined;
  onNavigate?: () => void | undefined;
}) {
  return (
    <nav className={cx("lc-nav", orientation === "vertical" && "lc-nav--vertical")} aria-label="Main">
      {links.map((l) => (
        <a key={l.href + l.label} href={l.href} className="lc-nav__link" onClick={onNavigate}>
          {l.label}
          {l.accent && <span className="lc-nav__accent"> {l.accent}</span>}
        </a>
      ))}
    </nav>
  );
}

/** Elementor widget: "LC Footer Column" — title + link list. */
export function FooterColumn({ title, links }: { title: string; links: NavLink[] }) {
  return (
    <div className="lc-footer-col">
      <p className="lc-footer-col__title">{title}</p>
      <ul className="lc-footer-col__list">
        {links.map((l) => (
          <li key={l.label}>
            <a href={l.href}>{l.label}</a>
          </li>
        ))}
      </ul>
    </div>
  );
}

/** Elementor widget: "LC Marquee" — scrolling trust ticker. */
export function Marquee({ items, speed = 32, reverse }: { items: string[]; speed?: number | undefined; reverse?: boolean | undefined }) {
  const group = (hidden?: boolean) => (
    <div className="lc-marquee__group" aria-hidden={hidden}>
      {items.map((it, i) => (
        <Fragment key={i}>
          <span className="lc-marquee__item">{it}</span>
          <span className="lc-marquee__sep" />
        </Fragment>
      ))}
    </div>
  );
  return (
    <div
      className={cx("lc-marquee", reverse && "lc-marquee--reverse")}
      style={{ ["--lc-marquee-speed" as string]: `${speed}s` }}
    >
      <div className="lc-marquee__track">
        {group()}
        {group(true)}
      </div>
    </div>
  );
}
