import { Heading, LogoMark, StepNumber, Text } from "../atoms";
import { cx } from "../utils";

export interface StepItem {
  number: string;
  title: string;
  description: string;
}

/** Elementor widget: "LC Process Step" — numbered timeline item. */
export function ProcessStep({ number, title, description, last }: StepItem & { last?: boolean | undefined }) {
  return (
    <div className={cx("lc-process-step", last && "lc-process-step--last")}>
      <div className="lc-process-step__head">
        <StepNumber value={number} variant="circle" />
        <span className="lc-process-step__line" aria-hidden />
      </div>
      <Heading text={title} level="h4" />
      <Text size="small">{description}</Text>
    </div>
  );
}

/** Elementor widget: "LC Step Card" — big numeral card for "How it works". */
export function StepCard({ number, title, description }: StepItem) {
  return (
    <article className="lc-card lc-card--hover lc-step-card">
      <div className="lc-step-card__top">
        <StepNumber value={number} variant="big" />
        <LogoMark />
      </div>
      <Heading text={title} level="h4" />
      <Text size="small">{description}</Text>
    </article>
  );
}
