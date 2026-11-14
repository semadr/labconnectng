import type { MouseEventHandler } from "react";
import { getIcon, type LcIconName } from "../icons";
import { cx } from "../utils";

export type ButtonVariant = "primary" | "accent" | "outline" | "light" | "ghost";

/** Elementor widget: "LC Button" — controls mirror these props. */
export interface ButtonProps {
  label: string;
  href?: string | undefined;
  variant?: ButtonVariant | undefined;
  size?: "sm" | "md" | "lg" | undefined;
  icon?: LcIconName | undefined;
  iconPosition?: "before" | "after" | undefined;
  block?: boolean | undefined;
  external?: boolean | undefined;
  onClick?: MouseEventHandler<HTMLElement> | undefined;
  className?: string | undefined;
}

export function Button({
  label,
  href,
  variant = "primary",
  size = "md",
  icon,
  iconPosition = "after",
  block,
  external,
  onClick,
  className,
}: ButtonProps) {
  const Icon = getIcon(icon);
  const cls = cx(
    "lc-btn",
    `lc-btn--${variant}`,
    size !== "md" && `lc-btn--${size}`,
    block && "lc-btn--block",
    className,
  );
  const content = (
    <>
      {Icon && iconPosition === "before" && <Icon className="lc-btn__icon" aria-hidden />}
      <span>{label}</span>
      {Icon && iconPosition === "after" && (
        <Icon className="lc-btn__icon lc-btn__icon--trail" aria-hidden />
      )}
    </>
  );
  if (href) {
    return (
      <a
        href={href}
        className={cls}
        onClick={onClick}
        {...(external ? { target: "_blank", rel: "noopener noreferrer" } : {})}
      >
        {content}
      </a>
    );
  }
  return (
    <button type="button" className={cls} onClick={onClick}>
      {content}
    </button>
  );
}
