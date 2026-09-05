# DESIGN.md: Verify and improve the areas templates

Portable project design guide for Kun, Stitch-style workflows, and code agents.

## Source

- Updated: 2026-09-05T03:32:55.284Z
- Project brief: `.kun-design/2642402f/design.md`
- Shared token file: `DESIGN.md`
- Origin: Kun design mode

## Product Brief

Are you going to make the changes on the templates files of areas? What I have to do?

## Design Context

- Preset: none
- Design context (honor it in every visual decision):
- Target: Web — default to responsive browser/web-page or web-app layouts; create desktop screen frames around 1280x800 unless the brief asks for another breakpoint.
- Avoid generic AI tells: cream/sand default backgrounds, purple→blue gradients, bounce/elastic easing, nested cards, gray text on colored backgrounds. Verify text contrast and provide a prefers-reduced-motion fallback.

## Tokens

See root `DESIGN.md`. Token values are intentionally not duplicated in this generated handoff.

## Components

See root `DESIGN.md` for public component guidance; Kun-native rich component trees remain in internal document sidecars.

## Screens and Prototype Flow

- **Are you going to make the changes on the** (e4b982fa): HTML `.kun-design/2642402f/e4b982fa/v1.html`; frame 1280x800; notes `.kun-design/2642402f/e4b982fa/DESIGN.md`; direction: Are you going to make
- **Logo** (12ba72c4): HTML `.kun-design/2642402f/12ba72c4/v1.html`; frame 1280x800; notes `.kun-design/2642402f/12ba72c4/DESIGN.md`; role: logo

## Implementation Guidance

- Read root `DESIGN.md` first and keep UI work aligned with its tokens and component guidance plus the screen flow below.
- Treat each HTML or SVG artifact DESIGN.md as the detailed handoff for states, responsive behavior, animation, and implementation notes.
- Preserve planned prototype hrefs when converting HTML screens into production routes.
- Keep SVG motion declarative and preserve its viewBox, accessibility metadata, and reduced-motion behavior.
