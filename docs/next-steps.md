# PAGER — Next Steps

## UI & interaction (doing now)

- [x] Orchid Bloom gradient in the landing hero only
- [x] Honest wording: "AI-driven advice" replaced by "Tips for your stage" (landing and dashboard)
- [x] UI kit page rebuilt as a living style guide (`/ui-kit`)
- [x] Journal search (text, mood, tag), timeline grouped by month, "Show older entries"
- [x] Milestone reminders: "Coming up" card for the child's age or trimester, overdue items in amber
- [x] Feedback and animation: toasts instead of pop-up alerts, animated ticks, confetti when a group is done, delete asks first, reduced-motion support
- [ ] Next UI ideas: journal entry editing, dark mode, onboarding tour for first login

## Decisions still open

- [ ] Real AI tips later? (Roadmap Phase 2 still lists "AI personalization")

## To build later

- [ ] Real AI tips
- [ ] Expert booking, which builds on the waitlist
- [ ] Email or push reminders (today's reminders show only on the dashboard)

## Your part (last, when there are participants)

- [ ] **1. Deploy to Render.** Follow `docs/deploy.md`.
- [ ] **2. Recruit 5 participants.** Use the recruiting message in `docs/ux/usability-kit/`.
- [ ] **3. Create test accounts.** Run `php artisan pager:participant p1 --type=new_parent` (or `--type=expecting`).
- [ ] **4. Run the sessions.** Use the consent form, moderator checklist, task cards and SUS questionnaire.
- [ ] **5. Bring back the results**, then fix whatever the sessions show is confusing.
