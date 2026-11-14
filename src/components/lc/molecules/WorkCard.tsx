import { LogoMark, Pill, type PillVariant } from "../atoms";
import { cx } from "../utils";
import { MetricRow, type MetricItem } from "./Stats";

export type WorkCardTheme = "purple" | "lavender" | "night" | "mint" | "white";

/**
 * Elementor widget: "LC Work Card" — portfolio tile.
 * `kind` switches the bottom area: advert strip, metrics, carousel dots, or footer line.
 */
export interface WorkCardProps {
  kind: "advert" | "abstract" | "carousel" | "poster";
  theme: WorkCardTheme;
  tag: string;
  tagVariant?: PillVariant | undefined;
  title: string;
  body?: string | undefined;
  stripLabel?: string | undefined;
  stripNote?: string | undefined;
  metrics?: MetricItem[] | undefined;
  footerLabel?: string | undefined;
}

export function WorkCard({ kind, theme, tag, tagVariant = "mint", title, body, stripLabel, stripNote, metrics, footerLabel }: WorkCardProps) {
  const onDark = theme === "purple" || theme === "night";
  return (
    <article className={cx("lc-card lc-card--hover lc-work-card", `lc-work-card--${theme}`)}>
      <div>
        <Pill label={tag} variant={tagVariant} />
      </div>
      <h3 className="lc-work-card__title">{title}</h3>
      {kind === "abstract" && metrics && <MetricRow items={metrics} />}
      {body && <p className="lc-work-card__body">{body}</p>}
      {kind === "advert" && stripLabel && (
        <div className="lc-work-card__strip">
          <span>{stripLabel}</span>
          {stripNote ? <span className="lc-work-card__strip-note">{stripNote}</span> : <LogoMark />}
        </div>
      )}
      {kind === "carousel" && (
        <div className="lc-work-card__dots" aria-hidden>
          <span /> <span /> <span /> <span /> <span />
        </div>
      )}
      {kind === "poster" && footerLabel && (
        <div className="lc-work-card__footer">
          <LogoMark onDark={onDark} /> {footerLabel}
        </div>
      )}
    </article>
  );
}
