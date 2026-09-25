# PAGER — Usability Test Plan (Caregivers)

## Goals
1. Can a first-time caregiver sign up and write a first journal entry **without help**?
2. Do caregivers understand that PAGER is personalised to their stage, and do they trust the tips?
3. Check whether the fixes for the [journey map](01-user-journey-map.md) pain points actually work for real caregivers:
   - Writing prompts in the empty journal (W4)
   - Pregnancy view for expecting parents (W3)
   - Expert waitlist instead of the dead "Book" button (W5)
   - Changing your stage on the Profile page (W1)

> **Materials:** everything needed to run sessions is in [`usability-kit/`](usability-kit/README.md).

## Participants
**5 caregivers.** Five sessions typically surface most major usability issues.

| # | Profile | Why |
|---|---|---|
| P1–P2 | New parents (baby 0–12 months) | Core audience |
| P3 | Expecting parent (2nd–3rd trimester) | Tests the milestones mismatch |
| P4 | Working parent | Time-poor, phone-first |
| P5 | Solo parent | Tests the tone of the tips |

**Screener:** a primary caregiver of a child 0–3 or currently pregnant; uses a smartphone daily; has **not** seen PAGER before.
**Mix:** at least 2 sessions on a **phone** (the real use context is one-handed, often at night).

## Setup
- **Format:** 30–40 min, moderated, think-aloud. In person or video call with screen share.
- **Prototype:** the live app (see [04](04-interactive-prototype.md)), starting on the landing page, logged out.
- **Recording:** screen and audio, with consent.
- **Roles:** 1 moderator, 1 note-taker if possible.

## Script

### Intro (3 min)
> "Thanks for helping. We're testing the app, not you. There are no wrong answers. Please think out loud: say what you're looking at, what you expect, and anything confusing. I can't help during tasks, but I'll answer questions at the end."

### Warm-up questions (3 min)
- How do you keep track of your child's development or special moments today?
- Where do you go when you have a parenting question?

### Tasks (20–25 min)
Read each task aloud. Don't use the words on the buttons.

| # | Task | Success looks like | Watch for |
|---|---|---|---|
| T1 | "From this page, tell me what you think this app is for." | Explains journal + advice + experts | First impression, trust, the "Phase 1/2" wording |
| T2 | "Create an account for yourself." | Account created, correct parent type | Hesitation at the parent type choice |
| T3 | "Write down something that happened today, and how you felt." | Entry saved with a mood | Do they use a **writing prompt**? Mood picker use |
| T4 | "Find out what milestones your child should be reaching." | Opens Milestones and understands it | **Expecting parent (P3):** do they understand "Week 28 of 40" and the trimester list? |
| T5 | "Find a tip that's useful for you right now. Would you trust it?" | Opens a tip and gives a reason | Trust, relevance |
| T6 | "You're worried about your baby's sleep and want to talk to a professional. What would you do?" | Finds Experts → Book → joins the waitlist | Is "coming soon + notify me" acceptable, or disappointing? |
| T7 | "Your situation changed, for example your baby was born or you went back to work. Update the app so it knows." | Opens Profile (via their name) and changes stage | **Where do they look first?** Is clicking your name discoverable? |
| T8 | "Delete the entry you wrote earlier." | Entry deleted | Is the trash icon found and understood? |

### Wrap-up (5 min)
- What was the most useful part? The most frustrating?
- On a scale of 1–5, how likely are you to use this again next week? Why?
- Would you feel comfortable writing private things in this journal? Why or why not?
- If you could change one thing, what would it be?

## Metrics
Per task: **completion** (success / with difficulty / fail), **time on task**, **errors**, and a quote.
After the session: **SUS** (System Usability Scale, 10 questions) and the "use again" rating.

## Note-taking template

| Participant | Task | Result | Time | Issue observed | Quote | Severity (1–4) |
|---|---|---|---|---|---|---|
| P1 | T3 | Difficulty | 1:40 | Didn't know what to write | "What am I supposed to put here?" | 2 |

Severity: **1** cosmetic · **2** minor · **3** major (blocks some users) · **4** critical (blocks everyone).

## After testing
1. Group issues across participants and count how many hit each one.
2. Rank by severity × frequency.
3. Compare with the priority list in the journey map: confirm, re-rank, or add issues.
4. Feed the top issues into the wireframes ([03](03-wireframes.md)) and build order.
