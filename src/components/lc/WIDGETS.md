# LabConnect → Elementor widget map

Three layers. Each React component = one Elementor widget; props = widget controls;
arrays = repeater controls. Styles live in `src/styles/lc/*.css` as plain CSS with
`lc-` BEM classes, so the same files are enqueued by the plugin unchanged and each
widget's `render()` outputs the same markup.

```text
tokens.css  -> colours, fonts, radii, shadows (CSS variables)
atoms.css   -> Button, Pill, Eyebrow, Heading, Text, IconTile, LogoMark, CheckItem, Stars, Avatar, StepNumber, Price, DotGrid
molecules.css -> SectionHeader, StatCard/Group, MetricTile/Row, ButtonGroup, TrustRow, ServiceCard, TrackCard,
                 PricingCard, ProcessStep, StepCard, TestimonialCard, WorkCard, CampaignCard, FloatingNote,
                 Marquee, NavMenu, FooterColumn
sections.css -> layout shells only (header, hero, tracks, grids, R-VaaS block, final CTA, footer)
```

## Atoms (smallest widgets)
| Widget | Component | Controls |
|---|---|---|
| LC Button | `atoms/Button` | label, link, variant (primary/accent/outline/light/ghost), size, icon, icon position, full width |
| LC Badge / Pill | `atoms/Pill` | label, variant (outline/dark/mint/mint-soft/glass/chip), dot (none/static/live), icon, wide spacing |
| LC Eyebrow | `atoms/Eyebrow` | label, tone, icon |
| LC Heading | `atoms/Heading` | text, highlight words, highlight colour, level (hero/h2/h3/h4), HTML tag, tone |
| LC Text / Quote | `atoms/Text` | text, size (body/lead/small), on dark |
| LC Icon Tile | `atoms/IconTile` | icon, tone, size |
| LC Logo / Logo Mark | `atoms/LogoMark` | image, link / on-dark |
| LC Check Item | `atoms/CheckItem` | label, style (tick/circle), tone |
| LC Price | `atoms/Misc#Price` | amount, period |
| LC Stars / Avatar / Step Number | `atoms/Misc` | count / initials+tone / value+style |

## Molecules (cards & groups)
| Widget | Component | Controls |
|---|---|---|
| LC Section Header | `molecules/SectionHeader` | badge, badge style, title, highlight, description, align (split/center/left) |
| LC Stat Card / Group | `molecules/Stats` | value, label (repeater) |
| LC Metric Tile / Row | `molecules/Stats` | value, label, highlighted (repeater) |
| LC Button Group | `molecules/Groups` | buttons (repeater of LC Button controls), align |
| LC Trust Row | `molecules/Groups` | items (icon + label), align, on dark |
| LC Service Card | `molecules/ServiceCard` | icon, title, description |
| LC Track Card | `molecules/TrackCard` | icon, title, badge, description, link label, theme, selected |
| LC Pricing Card | `molecules/PricingCard` | badge, name, amount, period, description, features (repeater), button labels, theme (clinic/rvaas), featured |
| LC Process Step | `molecules/Steps#ProcessStep` | number, title, description |
| LC Step Card | `molecules/Steps#StepCard` | number, title, description |
| LC Testimonial Card | `molecules/TestimonialCard` | quote, name, role, initials, tone, badge, rating |
| LC Work Card | `molecules/WorkCard` | kind (advert/abstract/carousel/poster), theme, tag, title, body, strip label/note, metrics, footer |
| LC Campaign Card | `molecules/HeroVisual` | tag, eyebrow, icon, title, body, CTA label/sub, link |
| LC Floating Note | `molecules/HeroVisual` | icon, title, subtitle |
| LC Marquee | `molecules/Navigation#Marquee` | items, speed, direction |
| LC Nav Menu / Footer Column | `molecules/Navigation` | links (repeater) |

## Sections (optional all-in-one widgets — each is just molecules in a grid)
Header · Hero (Clinic) + Track Selector · Rolling Bar · Services Grid · Clinic Packages ·
R-VaaS Intro · R-VaaS Process · R-VaaS Packages · Portfolio Gallery · How It Works ·
Testimonials · Final CTA · Footer.

All default copy lives in `content.ts` (use it as widget defaults).
Shared selection (chosen track / packages → WhatsApp message) lives in `selection.tsx`.
Browse every piece in isolation at `/widgets`.
