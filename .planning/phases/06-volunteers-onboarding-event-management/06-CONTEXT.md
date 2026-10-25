# Phase 6: Volunteers Onboarding & Event Management - Context

**Gathered:** 2026-10-25  
**Status:** Ready for planning  
**Mode:** MVP (Vertical Slice)

<domain>
## Phase Boundary

Phase 6 provides complete volunteer lifecycle management and on-ground event coordination:
1. Public volunteer registration portal (`/volunteer-join`) with skill tags, availability preferences, profile photo, and ID proof upload.
2. Administrative volunteer screening queue (`/admin/volunteers`) with applicant inspection and 1-click approval/rejection.
3. Automated sequential volunteer code generation upon approval (`{prefix}-VOL-{YYYY}-{0001}` using `setting('volunteer_prefix', 'KSF')`).
4. Administrative event management (`/admin/events`) for community relief drives, health camps, and volunteer meetups with location, timing, venue, map links, and participant capacity.
5. Public event discovery directory (`/events`) and event detail/RSVP portal (`/events/{slug}`) with slot capacity enforcement and automated volunteer matching.
6. Event participant roster and live attendance tracking (`/admin/events/{event}/participants`) for marking attendees as `attended` or `absent`.
</domain>

<decisions>
## Implementation Decisions

### Volunteer Registration & Screening (VOL-01, VOL-02, VOL-03)
- **D-01:** Public route `GET /volunteer-join` and `POST /volunteer-join`:
  - Rate-limited with `throttle:5,1` against bot spam.
  - Form validation: `full_name`, `email` (unique), `phone` (unique), `city`, `address`, `occupation`, `skills` (array of selected skills), `availability` (`weekdays`, `weekends`, `flexible`), `profile_photo` (optional, max 2MB image), `id_proof_path` (optional, max 2MB image/pdf).
  - Uploads stored in `storage/app/public/volunteers/photos` and `storage/app/public/volunteers/id_proofs`.
  - Sets initial `status = 'pending'`.
- **D-02:** Admin routes under `/admin/volunteers`:
  - `GET /admin/volunteers` — Listing queue with status tabs (`Pending`, `Approved`, `Rejected`, `Inactive`), city filters, skill filters, and search.
  - `GET /admin/volunteers/{volunteer}` — Profile inspection view showing applicant info and ID proof.
  - `POST /admin/volunteers/{volunteer}/approve` — 1-click approval inside `DB::transaction()`: generates sequential `volunteer_code` (e.g. `KSF-VOL-2026-0001`), marks `status = 'approved'`, and records `joined_at = today()`.
  - `POST /admin/volunteers/{volunteer}/reject` — Rejects application with `status = 'rejected'`.
- **D-03:** Volunteer Code Generation Algorithm:
  - Format: `{PREFIX}-VOL-{YEAR}-{SEQUENCE_4_DIGITS}`
  - Example: `KSF-VOL-2026-0001`
  - Sequence resets or increments based on existing approved volunteers in that year.

### Events & Attendance Management (VOL-04, VOL-05, VOL-06)
- **D-04:** Admin event routes under `/admin/events`:
  - `GET /admin/events` — Event catalog with participant counts, upcoming/past indicators, and status badges.
  - `GET /admin/events/create` & `POST /admin/events` — Event creation form with banner upload.
  - `GET /admin/events/{event}/edit` & `PUT /admin/events/{event}` — Event update form.
  - `GET /admin/events/{event}/participants` — Participant roster and attendance tracker.
  - `PATCH /admin/events/{event}/registrations/{registration}/attendance` — 1-click attendance toggle (`registered`, `attended`, `absent`).
  - `POST /admin/events/{event}/participants` — On-spot manual attendee registration.
- **D-05:** Public event routes:
  - `GET /events` — Public events directory with Upcoming and Past event tabs.
  - `GET /events/{event:slug}` — Rich event detail page with venue map, schedule, speaker/host info, capacity badge, and RSVP form.
  - `POST /events/{event:slug}/register` — Public RSVP registration (rate-limited `throttle:5,1`). Checks if `max_participants` reached; checks if phone/email matches an existing approved volunteer and automatically links `volunteer_id`.
</decisions>

<canonical_refs>
## Canonical References
- Requirements: VOL-01, VOL-02, VOL-03, VOL-04, VOL-05, VOL-06 in `.planning/REQUIREMENTS.md`
- Database schema: `volunteers`, `events`, and `event_registrations` tables created in Phase 1.
- Global helper `setting('volunteer_prefix', 'KSF')` from Phase 1.
</canonical_refs>
