/**
 * LabConnect NG — all page copy as data.
 * Each block matches one section widget's controls, so the same structure
 * can be used as Elementor widget defaults (repeaters = arrays).
 */
import type { ButtonProps } from "./atoms";
import type { CampaignCardProps, NavLink, PricingCardProps, StatItem, StepItem, TestimonialCardProps, TrustItem, WorkCardProps } from "./molecules";
import type { ServiceCardProps } from "./molecules/ServiceCard";
import type { TrackCardProps } from "./molecules/TrackCard";
import type { MetricItem } from "./molecules/Stats";

export const site = {
  brand: "LabConnect NG",
  /** Business WhatsApp number in international format, digits only (e.g. 2348012345678). Empty = WhatsApp lets the visitor pick a chat. */
  whatsappNumber: "2349025997196",
  copyright: "© 2026 LabConnect NG. All rights reserved.",
  footerTagline: "Two services. One clear standard.",
};

export function whatsappLink(message: string) {
  const base = site.whatsappNumber ? `https://wa.me/${site.whatsappNumber}` : "https://wa.me/";
  return `${base}?text=${encodeURIComponent(message)}`;
}

export const nav: { links: NavLink[]; cta: ButtonProps } = {
  links: [
    { label: "For Clinics", href: "#clinics" },
    { label: "For Researchers", href: "#rvaas", accent: "(R-VaaS)" },
    { label: "Packages", href: "#packages" },
    { label: "Work", href: "#work" },
    { label: "Contact", href: "#contact" },
  ],
  cta: { label: "Start Your Project", href: "#contact", icon: "arrow-right", size: "sm" },
};

export const hero = {
  badges: [
    { label: "Design for Health & Research", variant: "outline" as const },
    { label: "R-VaaS is now live", variant: "mint-soft" as const, icon: "sparkles" as const, dot: "live" as const },
  ],
  title: "Your Clinic Saves Lives. Your Adverts Should Show It.",
  highlight: ["Your Adverts Should Show It."],
  description:
    "Too many excellent health businesses are ignored online. LabConnect NG turns your care, credibility and offers into adverts people notice, trust and act on.",
  buttons: [
    { label: "I run a Health Business", href: "#clinics", variant: "primary", size: "lg" },
    { label: "I am a Researcher → R-VaaS", href: "#rvaas", variant: "outline", size: "lg" },
  ] satisfies ButtonProps[],
  stats: [
    { value: "200+", label: "Facilities supported" },
    { value: "100+", label: "Papers visualized" },
    { value: "48 hrs", label: "Fast first delivery" },
  ] satisfies StatItem[],
  campaign: {
    tag: "Featured campaign",
    eyebrow: "Your health, our priority",
    eyebrowIcon: "stethoscope",
    title: "Care that feels close. Service you can trust.",
    body: "Same-week appointments · Experienced care team · A clinic that listens first.",
    ctaLabel: "Book a visit today",
    ctaSub: "Your health cannot wait.",
  } satisfies CampaignCardProps,
  note: { icon: "flask" as const, title: "R-VaaS · Research Visibility", subtitle: "One paper. One story. Designed to be shared." },
};

export const tracks = {
  eyebrow: "Choose your track",
  title: "Two services. One clear starting point.",
  description: "Pick the path that fits you. Each track has its own rhythm, deliverables and pricing.",
  items: [
    {
      id: "clinic",
      icon: "heart",
      title: "For Health Businesses",
      description: "Adverts that give labs, pharmacies, clinics and hospitals the status they have earned.",
      linkLabel: "Explore clinic designs",
      theme: "purple",
      target: "#clinics",
    },
    {
      id: "rvaas",
      icon: "flask",
      title: "For Researchers",
      badge: "R-VaaS",
      description: "Turn papers into visuals people understand, share and cite — through a repeatable process.",
      linkLabel: "Explore R-VaaS",
      theme: "mint",
      target: "#rvaas",
    },
  ] satisfies Array<Omit<TrackCardProps, "selected" | "onSelect"> & { id: "clinic" | "rvaas"; target: string }>,
};

export const marquee = ["Clinics", "Pharmacies", "Labs", "Hospitals", "Researchers", "Graphical abstracts", "Social campaigns"];

export const clinicServices = {
  badge: "Section A · For Health Businesses",
  title: "Medical Advert Designs for Health Businesses",
  highlight: "Health Businesses",
  description:
    "Labs, pharmacies, clinics and hospitals that have been ignored online get status on social media and on their website. We make your expertise visible — and your next patient's decision easier.",
  items: [
    { icon: "megaphone", title: "Social Media Adverts", description: "Scroll-stopping designs that make your services easy to trust and easy to choose." },
    { icon: "monitor", title: "Website Banners", description: "Clean, credible banners that turn a quick visit into an enquiry or booking." },
    { icon: "share", title: "WhatsApp Status Packs", description: "Daily-ready visuals sized for status, so your community sees you again and again." },
    { icon: "pen", title: "Promo Flyers", description: "Offers, screenings, openings and health campaigns — designed to be shared." },
  ] satisfies ServiceCardProps[],
};

export const clinicPackages = {
  title: "Clinic packages",
  highlight: "packages",
  note: "Clear pricing. No hidden design fees.",
  items: [
    {
      id: "spark",
      badge: "Package 01",
      name: "One-Off Spark",
      amount: "₦15,000",
      period: "one-time",
      description: "A fast, polished first impression for a launch, offer, or announcement.",
      features: ["3 custom advert designs", "48-hour delivery", "1 revision round", "Ready for WhatsApp + social"],
    },
    {
      id: "weekly",
      badge: "Most popular",
      name: "Weekly Authority",
      amount: "₦45,000",
      period: "/ week",
      description: "Stay visible every week — without chasing a designer or missing a post.",
      features: ["10 designs every week", "Social + WhatsApp-ready formats", "Consistent brand styling", "Priority turnaround"],
      featured: true,
    },
    {
      id: "month",
      badge: "Package 03",
      name: "Month-End Dominance",
      amount: "₦150,000",
      period: "/ month",
      description: "Own the month with a full campaign rhythm and a calendar that does the work.",
      features: ["35+ designs", "Monthly content calendar", "Website banners included", "Campaign + promo flyers"],
    },
  ] satisfies PricingCardProps[],
};

export const rvaas = {
  badge: "Section B · For Researchers",
  subBadge: "A different service · Same design standard",
  title: "R-VaaS — Research Visibility as a Service",
  highlight: "R-VaaS",
  quote: "“Your Research Deserves To Be Seen, Not Just Published.”",
  description:
    "We transform research works into stunning, shareable designs through a repeatable process. For researchers ready to get their visibility started — we turn complex papers into visuals people actually understand, share and cite.",
  chips: ["Graphical abstracts", "Carousels", "Social cards", "Posters"],
  panel: {
    eyebrow: "From manuscript to momentum",
    title: "Your findings are too important to stay inside a PDF.",
    body: "R-VaaS gives every paper a visual system — so a busy reader can grasp it in seconds and remember it long after.",
    metrics: [
      { value: "1", label: "Core message" },
      { value: "3", label: "Key findings" },
      { value: "1", label: "Visual hook", highlight: true },
    ] satisfies MetricItem[],
  },
  process: {
    title: "How R-VaaS Works",
    eyebrow: "Repeatable process",
    steps: [
      { number: "01", title: "Submit Your Paper", description: "Share your manuscript, key findings and figures. No design work needed from you." },
      { number: "02", title: "We Extract The Story", description: "We distill 1 core message, 3 key findings and 1 visual hook people will remember." },
      { number: "03", title: "We Design The System", description: "Graphical abstract, carousel, social cards and poster — one coherent visual system." },
      { number: "04", title: "We Post & Amplify", description: "Scheduled posting for a month. Your work gets seen, shared and cited — not shelved." },
    ] satisfies StepItem[],
  },
};

export const rvaasPackages = {
  title: "R-VaaS packages",
  highlight: "R-VaaS",
  note: "1 paper, 2 papers and more — we scale with your output.",
  items: [
    {
      id: "one-paper",
      badge: "R-VaaS 01",
      name: "1 Paper / Month",
      amount: "₦35,000",
      period: "/ month",
      description: "Start your visibility with one paper, beautifully translated for the world.",
      features: ["1 paper transformed", "1 graphical abstract", "5 carousel slides", "4 social cards", "1-month posting plan"],
    },
    {
      id: "two-papers",
      badge: "Most popular for researchers",
      name: "2 Papers / Month",
      amount: "₦60,000",
      period: "/ month",
      description: "Keep momentum. Publish, visualise, post — then do it again.",
      features: ["2 papers transformed", "2 graphical abstracts", "10 carousel slides", "8 social cards", "2-month posting plan"],
      featured: true,
    },
    {
      id: "growth",
      badge: "R-VaaS 03",
      name: "Researcher Growth",
      amount: "₦100,000",
      period: "/ 3 months",
      description: "A longer runway for a researcher building a recognisable public profile.",
      features: ["3+ papers transformed", "Personal brand kit", "LinkedIn + X strategy", "Conference poster"],
    },
  ] satisfies PricingCardProps[],
};

export const portfolio = {
  badge: "Selected work",
  title: "Two tracks. One visual standard.",
  description: "Clinic adverts build trust fast. Research visuals make complex ideas unforgettable. Explore both worlds.",
  items: [
    { kind: "advert", theme: "purple", tag: "Clinic advert", tagVariant: "glass", title: "Free Health Screening Weekend", body: "Blood pressure · Blood sugar · General consultation", stripLabel: "Book your slot", stripNote: "Limited spaces →" },
    { kind: "advert", theme: "lavender", tag: "Pharmacy promo", title: "Wellness essentials, delivered with care.", body: "Order today · Trusted pharmacists · Fast local delivery", stripLabel: "Shop the offer" },
    { kind: "advert", theme: "night", tag: "Lab campaign", title: "Know your numbers. Protect your future.", body: "Full body check · Results in 24 hours · Confidential", stripLabel: "Book a test today →" },
    {
      kind: "abstract",
      theme: "mint",
      tag: "Graphical abstract",
      tagVariant: "dark",
      title: "What changed after the intervention?",
      metrics: [
        { value: "1", label: "Core question" },
        { value: "3", label: "Key findings" },
        { value: "→", label: "Clear takeaway", highlight: true },
      ],
      body: "Designed for quick reading, conference sharing and social posting.",
    },
    { kind: "carousel", theme: "purple", tag: "Research carousel", title: "Slide 1: The problem everyone missed.", body: "Swipe through the evidence, method and result — one idea per slide." },
    { kind: "poster", theme: "white", tag: "Conference poster", tagVariant: "mint-soft", title: "A poster people actually stop to read.", body: "Bold hierarchy, one visual hook and findings that can be understood from two metres away.", footerLabel: "Ready for print + LinkedIn" },
  ] satisfies WorkCardProps[],
};

export const howItWorks = {
  badge: "Simple by design",
  title: "How it works",
  description: "Tell us what you need. We design it. You share it with confidence.",
  steps: [
    { number: "01", title: "Share your brief", description: "Tell us your service, paper, offer or goal — plus any brand colours, photos or key messages." },
    { number: "02", title: "We design it", description: "We craft a clean, on-brand visual system that is easy to understand and ready to share." },
    { number: "03", title: "You get seen", description: "Post it, print it, or let R-VaaS schedule it. Your work reaches the people who need it." },
  ] satisfies StepItem[],
};

export const testimonials: TestimonialCardProps[] = [
  {
    quote: "Our adverts finally look like the standard of care we provide. Patients mention our posts before they even mention a referral.",
    name: "Clinic Owner",
    role: "Health business client · Weekly Authority",
    initials: "CO",
  },
  {
    quote: "R-VaaS turned a dense paper into a graphical abstract my network actually understood. The conversation started before the journal link did.",
    name: "PhD Candidate & Researcher",
    role: "Research Visibility as a Service",
    initials: "PhD",
    tone: "dark",
    badge: "R-VaaS client",
  },
];

export const finalCta = {
  title: "Ready to be seen — for the right reasons?",
  highlight: "for the right reasons?",
  description: "Choose your path and start your project. You will know exactly what you are getting, when it arrives, and how it helps you grow.",
  clinicLabel: "I run a Health Business",
  rvaasLabel: "I am a Researcher → R-VaaS",
  trust: [
    { icon: "badge-check", label: "Clear packages" },
    { icon: "calendar", label: "Fast turnaround" },
    { icon: "zap", label: "Designed to be shared" },
  ] satisfies TrustItem[],
};

export const footer = {
  tagline: "Design that gives health businesses status — and gives research the visibility it deserves.",
  columns: [
    {
      title: "Health Businesses",
      links: clinicServices.items.map((s) => ({ label: s.title, href: "#clinics" })),
    },
    {
      title: "Researchers · R-VaaS",
      links: ["Graphical Abstracts", "Research Carousels", "Social Cards", "Conference Posters"].map((label) => ({ label, href: "#rvaas" })),
    },
  ],
  cta: {
    title: "Start a project",
    body: "Pick a track, choose a package, and tell us what you want the world to see.",
    button: { label: "Start Your Project", href: "#contact", size: "sm" } satisfies ButtonProps,
  },
};
