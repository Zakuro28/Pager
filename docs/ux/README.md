# PAGER — UX Workstream

| # | Task | Status | Doc |
|---|---|---|---|
| 1 | User journey mapping | ✅ Done | [01-user-journey-map.md](01-user-journey-map.md) |
| 2 | Wireframe creation | ✅ Done (new screens W1–W5) | [03-wireframes.md](03-wireframes.md) |
| 3 | UI design system (colors, fonts, icons) | ✅ Done; tokens and icons shared in code | [02-design-system.md](02-design-system.md) |
| 4 | Interactive prototype | ✅ Live app is the prototype | [04-interactive-prototype.md](04-interactive-prototype.md) |
| 5 | Usability testing with caregivers | 📝 Plan ready; sessions need real participants | [05-usability-test-plan.md](05-usability-test-plan.md) |

## Top findings and status
| # | Finding | Status |
|---|---|---|
| 1 | No way to change parent type after sign-up (breaks expecting → new parent) | ✅ Fixed: Profile page (W1) + "Has your baby arrived?" banner (W2) |
| 2 | Milestone ticks saved only in the browser | ✅ Fixed: saved to the account; old browser ticks are moved over automatically |
| 3 | Expecting parents shown baby milestones | ✅ Fixed: pregnancy week + trimester checklist (W3) |
| 4 | "Book a Consultation" dead link | ✅ Fixed: expert waitlist with topics (W5) |
| 5 | Empty journal gives no prompt | ✅ Fixed: writing prompts by parent type (W4) |
| 6 | No email verification | ✅ Fixed: verification email on sign-up + dashboard reminder (not blocking) |
| 7 | Hard-coded admin login | ✅ Fixed: admins are real accounts (`is_admin`); create with `php artisan pager:create-admin` |
| 8 | No "forgot password" | ✅ Fixed: reset-by-email flow on the login page |
