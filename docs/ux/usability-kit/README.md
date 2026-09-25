# Usability Kit: running PAGER sessions with caregivers

Everything you need to run the 5 sessions described in the [test plan](../05-usability-test-plan.md).

| File | Use it for | When |
|---|---|---|
| [01-recruiting-message.md](01-recruiting-message.md) | Post in parent groups / send to friends | 1–2 weeks before |
| [02-consent-form.md](02-consent-form.md) | Participant reads and agrees | Start of each session |
| [03-moderator-checklist.md](03-moderator-checklist.md) | Your step-by-step run sheet | During each session |
| [04-task-cards.md](04-task-cards.md) | Tasks to read aloud (or print and hand over) | During each session |
| [05-sus-questionnaire.md](05-sus-questionnaire.md) | 10-question usability score | End of each session |
| [06-results-template.csv](06-results-template.csv) | Notes, one row per task per person | During / after |

## Set up a participant account (optional)
Sign-up is part of the test (task T2), so normally participants create their own account. If a session runs short on time, or you're doing it remotely, you can prepare a clean account in advance:

```bash
php artisan pager:participant P3 --type=expecting
#   Email:    p3@test.pager
#   Password: pager-p3
```
Running the command again for the same code **wipes and recreates** the account, so each session starts clean. Types: `expecting`, `new_parent`, `working_parent`, `solo_parent`.

## Suggested schedule
| When | What |
|---|---|
| Week 1 | Post the recruiting message and pick 5 people using the screener |
| Week 2 | Run 5 sessions (40 min each, leave 15 min between them for notes) |
| Week 2, end | Fill in the results CSV, score SUS, rank issues ([test plan → After testing](../05-usability-test-plan.md#after-testing)) |
