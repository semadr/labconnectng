import {
  ArrowRight,
  ArrowUpRight,
  BadgeCheck,
  CalendarClock,
  FileText,
  FlaskConical,
  HeartPulse,
  Megaphone,
  MonitorSmartphone,
  PenLine,
  Share2,
  Sparkles,
  Stethoscope,
  Zap,
  type LucideIcon,
} from "lucide-react";

/**
 * Icon registry — the React equivalent of Elementor's Icon control.
 * Content refers to icons by name so the same data can drive PHP widgets.
 */
export const lcIcons = {
  "arrow-right": ArrowRight,
  "arrow-up-right": ArrowUpRight,
  "badge-check": BadgeCheck,
  calendar: CalendarClock,
  file: FileText,
  flask: FlaskConical,
  heart: HeartPulse,
  megaphone: Megaphone,
  monitor: MonitorSmartphone,
  pen: PenLine,
  share: Share2,
  sparkles: Sparkles,
  stethoscope: Stethoscope,
  zap: Zap,
} satisfies Record<string, LucideIcon>;

export type LcIconName = keyof typeof lcIcons;

export function getIcon(name?: LcIconName) {
  return name ? lcIcons[name] : undefined;
}
