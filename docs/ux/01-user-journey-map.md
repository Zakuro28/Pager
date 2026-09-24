# PAGER — User Journey Map

**Scope:** Phase 1 (live) product — landing page, sign-up, dashboard (journal, milestones, AI tips, resources, experts).
**Method:** Walkthrough of the running app (Sept 2026) with a test account, plus review of the code behind each screen. Pain points marked 🔎 were verified directly in the product, not assumed.

---

## Personas

### Persona A — Maria, new parent
- 29, first baby (3 months old), on maternity leave, returns to work in 2 months
- Uses her phone one-handed, often at night during feeds
- **Goal:** know if her baby is developing normally, and remember the small moments
- **Worry:** "Am I doing this right?" — anxious, time-poor, tired

### Persona B — Joy, expecting parent
- 32, 28 weeks pregnant, works full-time
- Plans ahead, researches a lot, trusts expert sources over forums
- **Goal:** prepare for birth and the first weeks, keep a record of the pregnancy
- **Worry:** information overload; not knowing what matters *right now*

---

## Journey A — Maria (new parent): discover → first value → habit

| Stage | Discover | Sign up | First use | Come back | Seek help |
|---|---|---|---|---|---|
| **Doing** | Lands on the homepage from a friend's link; skims hero and features | Clicks "Get started free", fills in 4 fields, picks "New Parent" | Sees the dashboard; writes first journal entry with a mood; ticks a few milestones | Opens PAGER during a night feed to log a moment and read today's tip | Worried about sleep; looks at Experts |
| **Touchpoints** | Hero, feature cards, "How it works" (8 steps), roadmap | Register form, parent-type cards | Journal, mood picker, tags, milestones checklist, AI tips | Dashboard on phone | Expert Guidance section, "Book a Consultation" |
| **Thinking / feeling** | 🙂 "This looks calm and trustworthy." | 🙂 Quick — no long questionnaire | 😊 "Oh, the tips are for *my* stage." | 😐 "Where did my milestone ticks go?" (new phone) | 😟 "I clicked Book and nothing happened." |
| **Pain points** | 8-step "How it works" is long for a tired parent; Phase labels (1/2/3) are internal language | 🔎 No email verification — every account shows "Unverified" in admin | 🔎 Empty journal state only says "No entries yet" — no prompt for *what* to write | 🔎 Milestone ticks are saved in the browser only (localStorage), not the account — lost on a new device or browser | 🔎 "Book a Consultation" links to `#` — a dead end at the moment of highest need |
| **Opportunities** | Shorten "How it works" to 3 steps; replace "Phase 2" with "Coming soon" | Add email verification (trust + account recovery) | Add a first-entry prompt ("What made you smile today?") | Save milestones to the database | Replace the dead button with a waitlist / "Notify me" form |

**Emotional curve:** high at discovery and sign-up → peaks at first tip ("this is for me") → dips when data goes missing → lowest at the dead "Book" button.

---

## Journey B — Joy (expecting parent): the mismatch problem

| Stage | Sign up | First use | 3 months later (baby is born) |
|---|---|---|---|
| **Doing** | Picks "Expecting" | Reads prenatal tips; opens Milestones | Wants to switch to "New Parent" |
| **Feeling** | 🙂 "Nice, there's a card for me." | 😕 "Why am I being asked if my baby rolls over?" | 😠 "I can't find where to change this." |
| **Pain points** | — | 🔎 AI tips adapt to parent type, but the **Milestones checklist does not** — expecting parents see 0–9 month baby milestones | 🔎 There is **no profile/settings page** — parent type can never be changed after sign-up |
| **Opportunities** | — | Show a pregnancy week tracker (or hide milestones) for expecting parents | Add a Profile page; prompt "Has your baby arrived?" after the due date |

This is the most important finding: PAGER's core promise is *personalisation by stage*, but the one life transition every expecting parent goes through (expecting → new parent) is not supported.

---

## Priority list (from this map)

| # | Issue | Impact | Effort |
|---|---|---|---|
| 1 | No way to change parent type (no Profile page) | High — breaks personalisation for every expecting user | Medium |
| 2 | Milestones stored in browser only | High — silent data loss | Medium |
| 3 | Milestones not adapted for expecting parents | High — first-use confusion | Medium |
| 4 | "Book a Consultation" dead link | Medium — trust hit at a stressful moment | Low |
| 5 | Empty journal state has no prompt | Medium — first-entry drop-off | Low |
| 6 | No email verification | Medium — trust, account recovery | Medium |
| 7 | Long 8-step "How it works", internal "Phase" wording | Low | Low |

Items 1, 3 and 5 are wireframed in [`03-wireframes.md`](03-wireframes.md).
