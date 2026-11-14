import { Button, Logo, Text } from "../atoms";
import { footer as defaults, site } from "../content";
import { FooterColumn } from "../molecules";

/** Section widget: "LC Footer" — Logo + tagline + Footer Columns + CTA. */
export function SiteFooter({ data = defaults }: { data?: typeof defaults | undefined }) {
  return (
    <footer className="lc-footer">
      <div className="lc-container">
        <div className="lc-footer__grid">
          <div className="lc-footer__brand">
            <Logo />
            <Text size="small">{data.tagline}</Text>
          </div>
          {data.columns.map((c) => (
            <FooterColumn key={c.title} {...c} />
          ))}
          <div className="lc-footer-col">
            <p className="lc-footer-col__title">{data.cta.title}</p>
            <Text size="small">{data.cta.body}</Text>
            <div>
              <Button {...data.cta.button} />
            </div>
          </div>
        </div>
        <div className="lc-footer__bottom">
          <span>{site.copyright}</span>
          <span>{site.footerTagline}</span>
        </div>
      </div>
    </footer>
  );
}
