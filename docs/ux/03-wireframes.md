# PAGER — Wireframes

Low-fidelity layouts for the **new screens and states** found in the [journey map](01-user-journey-map.md). Screens that already exist and work are not re-wireframed here. The live app serves as their reference.

Legend: `[ Button ]` · `( ) radio` · `[x] checkbox` · `▢ icon` · `____ input` · `…` more content

---

## W1 — Profile & settings (new page)
**Fixes:** Parent type can never be changed after sign-up (priority #1).
**Route:** `/profile`, linked from the user name in the dashboard nav.

```
┌────────────────────────────────────────────────────────────┐
│ ▢ PAGER        Journal  Milestones  AI Tips  …   Maria ▾   │
├────────────────────────────────────────────────────────────┤
│  ← Back to dashboard                                        │
│                                                             │
│  Your profile                                               │
│  ─────────────────────────────────────────────              │
│  Name            [ Maria Santos__________ ]                 │
│  Email           maria@example.com   ✓ Verified             │
│                                                             │
│  Your stage                                                 │
│  This changes your tips, milestones and resources.          │
│  ┌──────────────┐ ┌──────────────┐                          │
│  │ ▢ heart      │ │ ▢ baby    ●  │  ← current, purple       │
│  │ Expecting    │ │ New Parent   │                          │
│  └──────────────┘ └──────────────┘                          │
│  ┌──────────────┐ ┌──────────────┐                          │
│  │ ▢ briefcase  │ │ ▢ sparkles   │                          │
│  │ Working      │ │ Solo         │                          │
│  └──────────────┘ └──────────────┘                          │
│                                                             │
│  Baby's date of birth / due date   [ 2026-06-14 ]           │
│                                                             │
│                                   [ Save changes ]          │
│  ─────────────────────────────────────────────              │
│  Danger zone          [ Delete my account ]  (red, ghost)   │
└────────────────────────────────────────────────────────────┘
```
**Notes**
- Reuse the `.type-card` selectable cards from the register page for consistency.
- The date field enables W2's "Has your baby arrived?" prompt and makes milestones age-aware.

---

## W2 — "Has your baby arrived?" prompt (dashboard banner)
**Fixes:** the expecting → new parent transition (Journey B).
**Shown when:** the user is `expecting` and today is on or after their due date.

```
┌────────────────────────────────────────────────────────────┐
│ ▢ baby   Has your baby arrived? 🎉                          │
│          Update your profile to get newborn tips and        │
│          milestones.                                        │
│                     [ Yes, switch to New Parent ]  [ Not yet ]│
└────────────────────────────────────────────────────────────┘
```
**Notes**
- One click switches `parent_type` to `new_parent`. "Not yet" snoozes the banner for 7 days.
- Pink/purple tint (`--purple-bg`). The banner appears above the welcome block.

---

## W3 — Milestones for expecting parents
**Fixes:** Expecting parents are shown 0–9 month baby milestones (priority #3).

```
┌───────────────────────────────┐
│ Pregnancy                     │
│ Week 28 of 40                 │
│ ████████████████░░░░░░  70%   │
│                               │
│ THIRD TRIMESTER               │
│ [x] Glucose screening         │
│ [ ] Tour the hospital         │
│ [ ] Pack hospital bag (wk 36) │
│ [ ] Install car seat          │
│ [ ] Choose a paediatrician    │
│                               │
│ After birth you'll see baby   │
│ milestones here.              │
└───────────────────────────────┘
```
**Notes**
- Same panel slot and styling as the current Milestones panel, so only the content changes.
- The week number comes from the due date in W1.
- Ticks must be **saved to the database**, not `localStorage` (priority #2). This applies to baby milestones too.

---

## W4 — Empty journal with a first-entry prompt
**Fixes:** the empty state gives no guidance (priority #5).

```
┌────────────────────────────────────────────────────────────┐
│ Journal  PRIVATE                                            │
│ ( 😊 Happy ) ( 😌 Okay ) ( 😴 Tired ) ( 😰 Overwhelmed )     │
│ ┌────────────────────────────────────────────────────────┐ │
│ │ How are you feeling today?…                            │ │
│ └────────────────────────────────────────────────────────┘ │
│                                                             │
│                ▢ notebook-pen                               │
│         Your first entry starts here.                       │
│      Not sure what to write? Try one:                       │
│                                                             │
│  ( What made you smile today? )                             │
│  ( One thing your baby did for the first time )            │
│  ( What's worrying you right now? )                         │
│                                                             │
└────────────────────────────────────────────────────────────┘
```
**Notes**
- Clicking a prompt chip fills the textarea and focuses it.
- Prompts change by parent type (for example, expecting: "How are you feeling about the birth?").

---

## W5 — "Book a Consultation" → join waitlist (modal)
**Fixes:** the dead `href="#"` button (priority #4).

```
            ┌──────────────────────────────────────┐
            │                                   ✕  │
            │  ▢ stethoscope                        │
            │  Expert consultations are coming      │
            │  soon                                 │
            │                                       │
            │  We'll email you as soon as you can   │
            │  book a licensed specialist.          │
            │                                       │
            │  What do you need help with?          │
            │  [ ] Sleep   [ ] Feeding              │
            │  [ ] Behaviour  [ ] Development       │
            │                                       │
            │  maria@example.com (prefilled)        │
            │           [ Notify me ]               │
            └──────────────────────────────────────┘
```
**Notes**
- Replaces a broken promise with an honest one. The topic checkboxes also give you demand data for Phase 2.
- After submitting, show: "You're on the list ✓".

---

## Build order
1. **W1 Profile** → unlocks W2 and W3 (needs `due_date`/`birth_date` column)
2. **Milestones to DB** (no new screen, but required by W3)
3. **W5 Waitlist** (smallest, fixes a dead end)
4. **W4 Empty-state prompts** (small, front-end only)
5. **W2 Arrival banner** + **W3 Pregnancy tracker**
