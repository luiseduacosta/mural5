---
name: Mural5 — ESS/UFRJ Estágios
seed_color: "#2B6C9C"
mode: light
tone: clean
template: saas
sections:
  - palette
  - typography
  - buttons
  - forms
  - navigation
  - cards
  - states
  - spacing
  - radius
  - shadow
tokens:
  - name: brand
    kind: color
    value: "#2B6C9C"
  - name: brand-dark
    kind: color
    value: "#1D4F7A"
  - name: brand-soft
    kind: color
    value: "#EAF3FB"
  - name: bg
    kind: color
    value: "#F4F7FB"
  - name: surface
    kind: color
    value: "#FFFFFF"
  - name: surface-alt
    kind: color
    value: "#EEF4FB"
  - name: border
    kind: color
    value: "#DFE7F1"
  - name: text
    kind: color
    value: "#1F2937"
  - name: text-muted
    kind: color
    value: "#6B7280"
  - name: success
    kind: color
    value: "#198754"
  - name: warning
    kind: color
    value: "#FFC107"
  - name: danger
    kind: color
    value: "#DC3545"
  - name: nav-gradient
    kind: gradient
    value: "linear-gradient(135deg, #2B6C9C 0%, #1D4F7A 100%)"
  - name: font-sans
    kind: type
    value: '"Segoe UI", "Helvetica Neue", Arial, sans-serif'
  - name: font-nav
    kind: type
    value: '"Raleway", sans-serif'
  - name: space-1
    kind: space
    value: "0.25rem"
  - name: space-2
    kind: space
    value: "0.5rem"
  - name: space-3
    kind: space
    value: "0.75rem"
  - name: space-4
    kind: space
    value: "1rem"
  - name: space-6
    kind: space
    value: "1.5rem"
  - name: space-8
    kind: space
    value: "2rem"
  - name: space-12
    kind: space
    value: "3rem"
  - name: radius-button
    kind: radius
    value: "0.6rem"
  - name: radius-input
    kind: radius
    value: "0.75rem"
  - name: radius-card
    kind: radius
    value: "1rem"
  - name: radius-full
    kind: radius
    value: "999px"
  - name: shadow-card
    kind: shadow
    value: "0 0.75rem 1.5rem rgba(31, 41, 55, 0.08)"
  - name: shadow-nav
    kind: shadow
    value: "0 0.5rem 1.2rem rgba(29, 79, 122, 0.18)"
---

# Mural5 — Design System

Canonical theme for the Mural5 internship bulletin board (ESS/UFRJ). Every token here is extracted
from the application's current stylesheet (`webroot/css/app-theme.css`) and maps 1:1 to its CSS
custom properties (`--app-*`). Any visual change to the app should update both places.

## Rationale

The app is an academic administrative tool: institutional, calm, information-dense. The brand blue
(#2B6C9C) anchors identity; the near-white blue-gray background (#F4F7FB) keeps long data tables
legible; rounded cards (1rem) and soft shadows give structure without decoration. The only gradient
allowed is the navigation bar's brand→brand-dark sweep.

## Palette

- **brand / brand-dark / brand-soft** — identity, hover states, table header tint.
- **bg / surface / surface-alt / border** — page, panels, alternates, dividers.
- **text / text-muted** — body text and secondary text (AA on surface and bg).
- **success / warning / danger** — status badges and flash messages; always paired with text,
  never color alone.

## Typography

- Content: `Segoe UI`, `Helvetica Neue`, Arial — system stack, no webfont payload.
- Navigation: `Raleway` (loaded via `webroot/css/fonts.css`).
- Scale (from `mural.css`): h1 2.1rem, h2 1.6rem, h3 1.3rem, body 0.96rem; headings bold (700)
  with -0.02em tracking, uppercase table headers at 0.78rem / 0.04em tracking.

## Components

- **Buttons**: 0.6rem radius, weight 600, 0.2s ease-in-out transition. Primary = brand fill,
  hover brand-dark. No gradients on buttons.
- **Forms**: inputs 0.75rem radius, min-height 2.8rem; focus ring rgba(43,108,156,0.12) at 0.2rem.
- **Cards & tables**: 1rem radius, 1px `border`, `shadow-card`; table header uses `brand-soft`
  background with `brand-dark` uppercase text; row hover rgba(43,108,156,0.03).
- **Navigation**: sticky, `nav-gradient` background, white text (5.6:1 contrast, AA),
  dropdowns on `brand-dark` with 0.8rem radius.
- **Pagination**: Bootstrap 5 `.pagination justify-content-center` (element `paginator`) with
  muted small counter text (element `paginator_count`).
- **Badges/flash**: pill radius (999px); success flash rgba(25,135,84,0.08) fill with 0.15-alpha border.

## Motion

Subtle and functional only: 0.2s button transitions. No bounce/elastic easing; honor
`prefers-reduced-motion` in any future animation.
