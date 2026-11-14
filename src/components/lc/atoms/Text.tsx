import type { ReactNode } from "react";
import { cx } from "../utils";

/** Elementor widget: "LC Text" — body / lead paragraph. */
export interface TextProps {
  children: ReactNode;
  size?: "body" | "lead" | "small" | undefined;
  onDark?: boolean | undefined;
  className?: string | undefined;
}

export function Text({ children, size = "body", onDark, className }: TextProps) {
  return (
    <p
      className={cx(
        "lc-text",
        size !== "body" && `lc-text--${size}`,
        onDark && "lc-text--on-dark",
        className,
      )}
    >
      {children}
    </p>
  );
}

/** Elementor widget: "LC Quote line" — serif pull-quote. */
export function QuoteLine({ children }: { children: ReactNode }) {
  return <p className="lc-quote">{children}</p>;
}
