import { Avatar, Pill, Stars } from "../atoms";
import { cx } from "../utils";

/** Elementor widget: "LC Testimonial Card". */
export interface TestimonialCardProps {
  quote: string;
  name: string;
  role: string;
  initials: string;
  tone?: "light" | "dark";
  badge?: string;
  rating?: number;
}

export function TestimonialCard({ quote, name, role, initials, tone = "light", badge, rating = 5 }: TestimonialCardProps) {
  return (
    <figure className={cx("lc-card lc-testimonial", tone === "dark" && "lc-testimonial--dark")}>
      <div className="lc-testimonial__meta">
        {badge && <Pill label={badge} variant="mint" />}
        <Stars count={rating} />
      </div>
      <blockquote className="lc-testimonial__quote">“{quote}”</blockquote>
      <figcaption className="lc-testimonial__author">
        <Avatar initials={initials} tone={tone === "dark" ? "mint" : "purple"} />
        <div>
          <div className="lc-testimonial__name">{name}</div>
          <div className="lc-testimonial__role">{role}</div>
        </div>
      </figcaption>
    </figure>
  );
}
