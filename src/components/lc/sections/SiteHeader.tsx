import { Menu, X } from "lucide-react";
import { useState } from "react";
import { Button, Logo } from "../atoms";
import { nav as defaults } from "../content";
import { NavMenu } from "../molecules";

/** Section widget: "LC Header" = Logo + Nav Menu + Button (+ mobile drawer). */
export function SiteHeader({ data = defaults }: { data?: typeof defaults | undefined }) {
  const [open, setOpen] = useState(false);
  return (
    <header className="lc-header">
      <div className="lc-container lc-header__inner">
        <Logo />
        <div className="lc-header__nav">
          <NavMenu links={data.links} />
        </div>
        <Button {...data.cta} className="lc-header__cta" />
        <button
          type="button"
          className="lc-header__toggle"
          aria-expanded={open}
          aria-label={open ? "Close menu" : "Open menu"}
          onClick={() => setOpen((o) => !o)}
        >
          {open ? <X aria-hidden /> : <Menu aria-hidden />}
        </button>
      </div>
      {open && (
        <div className="lc-header__drawer">
          <NavMenu links={data.links} orientation="vertical" onNavigate={() => setOpen(false)} />
          <Button {...data.cta} size="md" block onClick={() => setOpen(false)} />
        </div>
      )}
    </header>
  );
}
