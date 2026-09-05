# Design brief

> Single source of truth for the redesign of the **Áreas (área de instituição)** templates in the **Mural de Estágios — ESS/UFRJ** portal (CakePHP 5, repo `mural5`).
> Status: foundation — brief, direction, page inventory, states and rollout plan decided. Later stages build the screens, then the logo, then iterate.

## Brief

**Product brief: verify and improve the areas templates** — `templates/Areas/{index,view,add,edit}.php`, the CRUD of the "Área de instituição" taxonomy that classifies every Instituição (internship-hosting organization) in the mural. Verified problems in the current baked Bootstrap templates: an action "rail" that is a fake navbar on every page with inline `font-size: 10pt` buttons; typos and inconsistent terminology (`"Área instituicoes"`, English `"Submit"` on the edit form); a raw table exposing the internal `id` with no search, no empty state, no institution counts; a detail page showing only name + id (a dead end even though Instituições deep-link into it); two inconsistent single-field forms; delete via bare `postLink` with generic `# {0}` confirm; and zero discoverability — the module has no entry in the top navigation. The design fixes all of this with one consistent, responsive pattern.

**Answer to "Are you going to make the changes on the template files?" — Yes, but in two clearly separated phases:**
- **Design phase (this thread, now):** produces only design deliverables under `.kun-design/2642402f/` — this brief, then interactive HTML screen prototypes (Lista de áreas, Detalhes da área, Cadastro de área). **No file in `templates/`, `src/`, `webroot/` is modified during this phase.** The prototypes render the redesigned screens with real content so you can review them on the canvas without touching the running system.
- **Implementation phase (after you approve):** the approved design is applied to the real CakePHP files, mapped one-to-one in "Implementation notes → File change map" below (the four Areas templates, the controller's `view()` to load linked institutions, the top-menu element, and the project CSS). Nothing is written to the app without your explicit go-ahead.

**Answer to "What do I have to do?" —** (1) review the screens generated on the canvas and react with corrections or approval; (2) say "aplicar / apply" when you are satisfied — that authorizes the code edits; (3) afterwards run the verification commands listed in Implementation notes (composer checks) or ask for them to be run here. You do not need to write code at any point.

## Concept & audience

**Product.** Mural de Estágios is the internship-management portal of the **Escola de Serviço Social — UFRJ**. The coordination team registers institutions, students (estagiários), supervisors and professors — all scoped to the current academic period (`mural_periodo_atual` from `Configuracoes`, e.g. "2026.1"). The header shows the official **ESS horizontal logo** (`webroot/img/logoess_horizontal-azul.svg`) with the wordmark "Mural de Estágios".

**Scope of this design.** The **Áreas de instituições** module: a small taxonomy (varchar 90, field `area`) used to classify every registered institution by field of work (health, education, public policy…). `Areas` has `hasMany Instituicoes` via `area_id`; policies: admins (`categoria 1`) manage, all other signed-in roles view read-only.

**Audience.**
- **Primary — coordinators/admins (categoria 1):** daily operators who scan the list, search, create, rename and understand *before deleting* that an area with institutions cannot be removed. Primary action: **Nova área**.
- **Secondary — read-only roles (professores 3, supervisores 4, alunos 2):** land on an area detail from an institution row and must read it comfortably with no admin actions and an easy way back.
- Tone: a precise, well-kept public record — institutional, civic, calm; not a startup dashboard.

## Visual direction

**Mood.** Precise like a university registry, warm like a student-facing service. Quiet neutral surfaces, ONE institutional blue as accent, typography carries hierarchy. No decorative gradients, no glassmorphism, no emoji, no cream backgrounds.

**Palette intent — anchored to the ESS logo blue `#2B6C9C`** (verified in the logo SVG asset). Cool slate neutrals (never warm/cream) + semantic colors:

| Token | Hex | Use |
|---|---|---|
| `ess-600` **brand** | `#2B6C9C` | Primary buttons, focus ring, active nav (white text ≈5.6:1 — AA) |
| `ess-800` | `#1C4565` | Links & interactive text on light (≈10:1) |
| `ess-700` | `#23577E` | Primary button hover |
| `ess-900` | `#14334C` | Footer band / deep emphasis |
| `ess-100` / `ess-50` | `#E2EDF6` / `#F2F7FB` | Selected-row wash / subtle panel tint |
| `slate-900` | `#1B2632` | Primary text (≈13:1) — never pure `#000` |
| `slate-600` | `#576470` | Secondary/meta text on white (≈6:1) |
| `slate-300`/`200`/`100` | `#C6CFD8` / `#DFE5EB` / `#EDF1F5` | Control borders / hairlines / inset surfaces |
| `slate-50` | `#F6F8FA` | Page background behind white panels |
| `success-700`/`100` | `#1E6B46` / `#E3F2E9` | Success flash, positive counts |
| `danger-700`/`100` | `#B42318` / `#FCEAE8` | Delete actions, destructive dialog, error flash |
| `warning-800`/`100` | `#7A4F01` / `#FFF4DA` | Delete-blocked explainer |

Rules: text on colored fills only as white on `ess-600`/danger buttons (≥4.5:1); never gray text on colored fills; one accent only.

**Typography.** One family — Inter (local/self-hosted) with system-ui fallback; no second family. Page title 24/650 (lh 1.25, −0.01em); section heading 18/600; body 16/400 lh 1.6; table/meta 14 with tabular numbers; labels/buttons 13–15/600 sentence case; captions 12. pt-BR copy throughout.

**Layout & motion.** 12-col grid, max content 1200px, 24px gutters (16px phones), 4px spacing base; white content panels (radius 10, 1px slate-200 border) on slate-50. Constant page anatomy: breadcrumb → page header (title + count + actions) → toolbar (search) → white data panel → pagination. Motion utilitarian: 140–160ms ease-out fade+4px for menus/tooltips/flash only; all transitions disabled under `prefers-reduced-motion`. Icons: small inline SVG line icons only (search, plus, pencil, trash, arrow-left) — replace the shell's `☰`/`▾` glyphs.

## Information architecture (pages)

Role-aware shell on every screen: header (ESS logo + wordmark + period chip + user menu), role menu (Mural / Consulta▾ [Instituições, **Áreas** ← new item] / Meus dados / Administração▾ / Usuário▾), flash region, footer (ESS/UFRJ · Mural de Estágios · período). Breadcrumb: `Mural › Consulta › Áreas de instituições › [nome]`.

1. **Lista de áreas** (`GET /areas`) — module hub: search, counts, create entry point, row actions.
2. **Detalhes da área** (`GET /areas/{id}`) — classification review: the area plus every institution filed under it.
3. **Cadastro de área** (`GET/POST /areas/add` e `/areas/{id}/edit`) — one form pattern for create and edit states.

Adjacent modules referenced by links (not scaffolded): Mural (`/`), Instituições (`/instituicoes`), login (`/users/login`).

## State & responsiveness plan

**Global:** all pages require login (as today); `categoria 1` sees management actions, other roles render read-only without action buttons; period chip always from `configuracao.mural_periodo_atual` (never hardcoded); flash banners under the header with icon + text (success/error/info, dark text on tint); not-found/denied keep header plus "Voltar para a listagem" escape.

**1. Lista de áreas (index).** Columns: Área (link → detail), Instituições vinculadas (count chip), Ações (Ver/Editar/Excluir — admin). Toolbar: "Buscar área" filter + summary count; primary CTA **Nova área**; secondary path **Ver instituições** (`/instituicoes`). States: loaded, search zero-matches ("Nenhuma área encontrada para '…'"), truly empty catalog (first-run panel with CTA), pagination bounds, sorted columns (`aria-sort`).

**2. Detalhes da área (view).** Header: area name + "N instituições" badge; admin actions: Editar área (primary), Voltar (secondary), Excluir área (danger → confirm dialog; disabled with explainer "Exclua ou reclassifique as instituições vinculadas antes de excluir a área." when count > 0). Body: "Instituições nesta área" panel — rows link to `Instituicoes::view`; empty variant "Nenhuma instituição nesta área ainda" + link to `/instituicoes`. Non-admins: header + list + Voltar only.

**3. Cadastro de área (add/edit).** One field "Nome da área" (required, max 90) with live counter `n/90` + helper text; actions [Cancelar] [Salvar área / Salvar alterações]. States: empty create, prefilled edit, inline validation errors ("O nome da área é obrigatório." / "Máximo de 90 caracteres."), busy submit "Salvando…", success flash after redirect (create → detail "Área criada com sucesso."; edit → detail "Alterações salvas."; delete → list "Área excluída.").

**Responsive (desktop-first; canvas 1280×800).** ≥1024: full horizontal menu, table with sortable headers. 768–1023: hamburger nav, header stacks, table scrolls inside panel. <768: rows become stacked cards (name link + count chip + actions); search/actions full-width; breadcrumb collapses to Voltar. <480: 16px gutters, ≥44px touch targets, pagination compresses to Anterior/Próxima. All breakpoints keep AA contrast, 2px `ess-600` focus-visible rings, and `prefers-reduced-motion`.

## Implementation notes

**What the prototypes cover.** Screens implement the `#content` region that `templates/layout/default.php` already wraps (menu_superior + flash + footer exist in the shell); each sets a real per-page title via `fetch('title')` — "Áreas de instituições", "Detalhes da área", "Nova área" — inside the document `<title>`.

**File change map (implementation phase — applied only after approval):**

| File | Change |
|---|---|
| `templates/Areas/index.php` | Replace baked table + action-navbar with the redesigned list hub (search, counts, empty state, row actions, pagination) |
| `templates/Areas/view.php` | Detail header + "Instituições nesta área" panel + guarded delete dialog |
| `templates/Areas/add.php` / `edit.php` | Unified form pattern (field, counter, inline errors, cancel, correct submit labels) |
| `src/Controller/AreasController.php` | `view()` adds `->contain('Instituicoes')` so the detail page has real data (small backend follow-up) |
| `templates/element/menu_superior.php` | New "Áreas" item under the admin Consulta group → `Areas::index`, mirroring the Instituições entry |
| `webroot/css/mural.css` + `app-theme.css` | Design tokens + component classes; removes inline `style=` attributes |
| `templates/Instituicoes/add.php` | Fix binding bug `areas_id` → `area_id` (adjacent fix, applied in the same batch) |

**Catalogued fixes applied with the redesign:** heading typo `"Área instituicoes"` → `"Áreas de instituições"`; `"Submit"` → `"Salvar alterações"`; unify add/edit chrome (add uses `element('templates')` + `.wrapper`, edit uses plain container); delete confirm `"Tem certeza que quer excluir este registro # {0}?"` → purpose-built dialog with blocked variant when institutions exist. Data model unchanged (schema untouched): `areas.id`, `areas.area` varchar 90, `instituicoes.area_id`.

**Accessibility baseline:** labels on every input, `aria-sort` on sortable headers, dialog focus trap + ESC, `aria-live` on flash/counter, AA contrast, no color-only meaning.

**Verification commands (implementation phase):** `composer cs-check`, `vendor/bin/phpunit` (or `composer test`), plus a manual browser pass on `/areas` as admin and as a non-admin role; review with `git diff` before committing. Git commit or stash before applying is recommended so the batch is reversible.

**Copy language:** pt-BR only; fixed terminology — module "Áreas de instituições", record "Área", actions "Nova área / Editar / Excluir / Voltar", count "N instituições".
