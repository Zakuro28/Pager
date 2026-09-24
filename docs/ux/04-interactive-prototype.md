# PAGER — Interactive Prototype

**Decision:** we use the **running Laravel app** as the interactive prototype, not a separate Figma prototype.

Why: every Phase 1 flow already exists and works end to end with real data (sign-up, journal, milestones, tips, resources, admin). A Figma copy would be less realistic and would drift from the product. Usability sessions (see [05](05-usability-test-plan.md)) run against the real app.

## Running it locally

```bash
cd Pager
php artisan serve --port=8000      # uses Herd's PHP 8.4 on this machine
```
Open http://127.0.0.1:8000. The database is SQLite (`database/database.sqlite`), so no DB server is needed.

For sessions with remote participants, deploy the existing Dockerfile to Render, or expose the local server with Herd's `expose` tool.

## What's clickable vs. stubbed

| Flow | State | Notes |
|---|---|---|
| Landing page → sign up | ✅ Real | |
| Register with parent type | ✅ Real | |
| Log in / log out | ✅ Real | |
| Journal: write, mood, tags, delete | ✅ Real | Saved to DB |
| Milestones checklist | ✅ Real | Saved to DB; pregnancy checklist + week for expecting parents |
| AI tips | ⚠️ Rule-based | Fixed tips per parent type, no AI yet |
| Resources search/filter | ✅ Real | |
| Expert Guidance | ⚠️ Waitlist | "Book a Consultation" opens a waitlist (consultations are Phase 2) |
| Profile / change parent type | ✅ Real | `/profile`, plus the arrival banner after the due date |
| Admin panel | ✅ Real | Login `admin` / `admin123` |

## Before running sessions
- **Reset data:** use a fresh test account for each participant so no one sees another person's entries.
- **Pick the parent type** that matches the participant, so the tips make sense to them.
- ⚠️ **Security:** the admin login is hard-coded (`admin` / `admin123` in `AdminController`). That's fine locally, but it **must** change before any public deploy.
