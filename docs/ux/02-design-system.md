# PAGER — UI Design System

The system lives in code, not in a separate design file:

| Layer | Source of truth |
|---|---|
| Color tokens | `resources/views/partials/tokens.blade.php` |
| Icons | `resources/views/components/icon.blade.php` (`<x-icon>`) |
| Typography | Inter, loaded from fonts.bunny.net on each page |

Every page includes the tokens partial with `@include('partials.tokens')` before its own `<style>` block. **Do not redefine tokens inside a page.** Add new tokens to the partial so all pages stay in sync.

---

## Color

### Neutrals
| Token | Value | Use |
|---|---|---|
| `--white` | `#ffffff` | Cards, landing background |
| `--bg` / `--surface` | `#f8f7ff` | App background (dashboard, admin) |
| `--ink` | `#111827` | Headings and body text |
| `--sub` | `#6b7280` | Secondary text, captions |
| `--border` | `#e5e7eb` | Dividers, card and input borders |

### Brand
| Token | Value | Use |
|---|---|---|
| `--purple` | `#7c3aed` | Primary buttons, links, active states, icons |
| `--purple-dim` | `#6d28d9` | Button hover |
| `--purple-bg` | `#f5f3ff` | Selected cards, badges, soft highlights |
| `--purple-mid` | `#ede9fe` | Borders on highlighted surfaces |
| `--purple-lite` | `#ddd6fe` | Secondary chart series |

### Feature accents
Each core module has its own accent pair (text/icon color plus a tinted background):

| Module | Accent | Background |
|---|---|---|
| Journal | `--purple` | `--purple-bg` |
| AI Advice | `--blue` `#2563eb` | `--blue-bg` `#eff6ff` |
| Resources | `--green` `#059669` | `--green-bg` `#ecfdf5` |
| Milestones | `--amber` `#d97706` | `--amber-bg` `#fffbeb` |
| Experts | `--pink` `#db2777` | `--pink-bg` `#fdf2f8` |

### Status
| Token | Value | Use |
|---|---|---|
| `--ok`, `--ok-bg`, `--ok-bdr` | green | Success, "verified", "live" |
| `--danger`, `--danger-bg`, `--danger-bdr` | `#dc2626` family | Errors, destructive actions |

`--error*` is an alias of `--danger*`. It's kept so the auth forms keep working. Use `--danger` in new code.

### What was fixed
Before this pass, each page had its own copy of the tokens and they had drifted:
- `--ink` was `#0f0e17` on the landing page and `#111827` everywhere else. It is now `#111827` on all pages.
- The success green was `#059669` on some pages and `#16a34a` in admin. It is now `#059669` everywhere.
- The error color was called `--error` on the auth pages and `--danger` in admin. Both names now point to the same value.

---

## Typography

**Typeface:** Inter, with the fallback `system-ui, sans-serif`.

| Role | Size | Weight | Tracking |
|---|---|---|---|
| Hero heading | `clamp(2.6rem, 5.5vw, 4.25rem)` | 800 | -0.04em |
| Section heading | ~1.5–2rem | 800 | -0.03em |
| Card title | ~1rem | 700–800 | -0.02em |
| Body | 0.875–1.0625rem | 400 | normal, line-height 1.6–1.75 |
| Eyebrow / label | 0.68–0.8rem | 700–800 | +0.08–0.1em, uppercase |

> ⚠️ `resources/views/ui-kit.blade.php` uses **Mali** and **Manjari**, not Inter, and does not use the tokens. It is an experimental component playground, not a reference for the real app. Either bring it in line with the tokens and Inter, or remove it before sharing it as "the UI kit."

---

## Icons

**Library:** [Lucide](https://lucide.dev), inlined as SVG so it needs no JS and no extra network requests.

```blade
<x-icon name="book-open" :size="20" />
<x-icon :name="$tip['icon']" :size="20" class="my-class" />
```

- Icons use `stroke="currentColor"`, so **set the color on the parent** (for example, `color: var(--purple)`).
- Standard sizes: **14** (inline in chips and badges), **18–20** (lists, tips), **22–24** (feature tiles, cards), **32** (empty states).
- To add an icon, copy its inner `<path>` markup from `https://unpkg.com/lucide-static/icons/<name>.svg` into the `$icons` array in the component.

**Intentional exceptions:** the journal mood picker (😊 😌 😴 😰) and the greeting wave (👋) stay as emoji. Faces carry emotion better than line icons, and Lucide has no face set.

**Icon map (current):**
| Concept | Icon |
|---|---|
| Journal | `book-open` |
| AI advice | `bot` |
| Resources | `library` |
| Milestones | `target` |
| Experts / check-ups | `stethoscope` |
| Privacy | `lock` |
| Expecting | `heart` |
| New parent | `baby` |
| Working parent | `briefcase` |
| Solo parent | `sparkles` |
| Delete | `trash-2` |
| Empty journal | `notebook-pen` |

---

## Components (as used in the app)

| Component | Where | Notes |
|---|---|---|
| Primary button (`.btn-solid`, `.btn-submit`) | Landing, auth | Purple fill, lifts on hover |
| Ghost button (`.btn-nav-ghost`) | Nav | Border only |
| Chip / pill (`.hero-chip`, `.badge`, `.feat-tag`) | Everywhere | Fully rounded, tinted background |
| Feature card (`.feat-card`) | Landing | Uses `--accent` / `--icon-bg` per module |
| Selectable card (`.type-card`) | Register | Radio input + card, purple when checked |
| Tip card (`.tip-card`) | Dashboard | Icon + title + text, links out |
| KPI card (`.kpi-card`) | Admin | Big number, gradient top bar on hover |

---

## Open design decisions
1. **Background:** replace the hand-made blurred orbs on the landing page with the Aura "Orchid Bloom" gradient? A preview was built. Still to decide: whole page or hero only.
2. **Component styles** are still copied per page (only the tokens are shared). The next step would be one shared stylesheet built with Vite and Tailwind, which is already installed.
