# Roadmap: Milestone v1.2 — Public Frontend UI/UX Polish & Visual Parity

## Milestone Summary

- **Milestone**: v1.2
- **Focus**: Audit, redesign, and polish all public Laravel Blade pages against the 11 high-fidelity mockups in `docs/ui/`. Fix typography, spacing, navigation, mobile drawer, hero sections, card layouts, donation flow, volunteer registration, transparency ledger, and legal pages to ensure visual excellence and design parity.
- **Previous Milestones**:
  - [Milestone v1.0 (Core MVP)](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/milestones/v1.0-ROADMAP.md) — Shipped 2026-10-25 (8 phases, 86 tests passed).
  - [Milestone v1.1 (Native Filament Migration)](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/milestones/v1.1-ROADMAP.md) — Shipped 2026-10-26 (4 phases, 125 tests passed).

---

## Phase Summary

| Phase | Name | Goal | Requirements | Success Criteria |
|---|---|---|---|---|
| 13 | Global Shell & Flagship Homepage Polish | Elevate global header, mobile drawer, footer, and homepage to match `Hope Foundation_ Together for Tomorrow.png` | PUB-01, PUB-02 | 4 |
| 14 | Institutional About, Contact & Legal Portals | Polish About Us, Contact Us, and Legal/Privacy pages to match `Hope Foundation About Us Mockup.png`, `Contact Us Mockup.png`, and `Privacy Policy Showcase.png` | PUB-03, PUB-04, PUB-05 | 4 |
| 15 | Campaigns, Events & Volunteer Portals | Align Campaigns directory, Cause detail, Events RSVP, and Volunteer join with their respective mockups | PUB-06, PUB-07, PUB-08 | 4 |
| 16 | Donation Flow, Status Lookup & Transparency Ledger | Polish manual donation UI, status verification portal, and transparency ledger against reference mockups | PUB-09, PUB-10, PUB-11 | 4 |
| 17 | End-to-End Browser Audit & Verification | Perform complete desktop, tablet, and mobile visual audit, verify zero console errors, and confirm test suite integrity | PUB-01 through PUB-11 | 3 |

---

## Phase Details

### Phase 13: Global Shell & Flagship Homepage Polish
**Status:** Completed  
**Goal:** Align the global layout (header, mobile navigation drawer, institutional footer) and the flagship homepage with `docs/ui/Hope Foundation_ Together for Tomorrow.png`.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** PUB-01, PUB-02  
**Success Criteria:**
1. Global navigation features clean brand logo, responsive navigation links, emergency donate button, and a smooth mobile slide-out drawer.
2. Institutional footer displays legal certifications (80G, 12A, PAN, Darpan), tax disclaimer, quick links, contact info, and social credentials matching the mockup.
3. Homepage hero showcases dynamic headline, dual CTAs, and live verified impact counters (raised, distributed, volunteers, active causes).
4. Urgent causes spotlight and mission pillars reflect the layout, typography, cards, and spacing from the reference mockup.

---

### Phase 14: Institutional About, Contact & Legal Portals
**Status:** Planned  
**Goal:** Polish the About Us, Contact Us, and Privacy/Legal pages to match `Hope Foundation About Us Mockup.png`, `Hope Foundation Contact Us Mockup.png`, and `Hope Foundation Privacy Policy Showcase.png`.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** PUB-03, PUB-04, PUB-05  
**Plans:**
- [ ] [14-01-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/14-institutional-about-contact-legal-portals/14-01-PLAN.md) — Wave 1: About Us Institutional Parity (`about.blade.php`, `TeamMember` leadership grid, impact numbers, journey timeline, and registration credentials) (PUB-03)
- [ ] [14-02-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/14-institutional-about-contact-legal-portals/14-02-PLAN.md) — Wave 1: Contact Us Portal & Interactive Inquiries (`contact.blade.php`, 2-column layout, office coordinates, Google Map embed, Alpine FAQ accordion) (PUB-04)
- [ ] [14-03-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/14-institutional-about-contact-legal-portals/14-03-PLAN.md) — Wave 2: Legal, Privacy & Compliance Showcase (`legal.blade.php`, multi-tab policy sidebar, 80G tax terms, print capability, and footer routing) (PUB-05)
**Success Criteria:**
1. About Us page displays organizational story, vision/mission, leadership team cards, and verified tax credentials banner.
2. Contact Us page features clean 2-column layout with direct office address, helpline, email, interactive map, and inquiry submission form.
3. Privacy policy and legal pages feature standardized typography, section navigation, and clear 80G tax exemption clauses.
4. Form inputs across institutional pages include responsive focus rings, validation error states, and rate-limiting feedback.

---

### Phase 15: Campaigns, Events & Volunteer Portals
**Status:** Pending Phase 14  
**Goal:** Refine the Campaigns directory, Cause Story detail page, Events directory with RSVP, and Volunteer registration portal against their mockups in `docs/ui/`.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** PUB-06, PUB-07, PUB-08  
**Success Criteria:**
1. Campaigns directory supports category filtering tabs, search bar, and cause cards with financial progress bars and urgent tags.
2. Campaign story page features full narrative formatting, goal vs raised progress indicator, recent donor list, and floating donate CTA.
3. Events directory renders upcoming and past events with date badges, venue, and attendee RSVP registration modal.
4. Volunteer registration portal features engaging hero pitch, skills checkbox/tag selection, availability selection, and ID proof upload zone.

---

### Phase 16: Donation Flow, Status Lookup & Transparency Ledger
**Status:** Pending Phase 15  
**Goal:** Upgrade the manual donation submission flow, donation verification status portal, and public transparency ledger to match `docs/ui/Hope Foundation Donation UI Mockup.png`, `Donation Status Portal.png`, and `Transparency Dashboard.png`.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** PUB-09, PUB-10, PUB-11  
**Success Criteria:**
1. Donation page provides amount preset pills, donor details, dynamic UPI QR code generator/display, bank account toggle, and screenshot dropzone.
2. Donation status portal allows donors to enter UTR or phone number to see a multi-stage status tracker with 1-click 80G PDF receipt download.
3. Transparency dashboard displays public fund utilization ledger with verified bills and ground impact photo viewer.
4. Zero regressions in donation verification service, 80G numbering, or financial transaction synchronization.

---

### Phase 17: End-to-End Browser Audit & Verification
**Status:** Pending Phase 16  
**Goal:** Conduct systematic visual and functional audit across all public pages in desktop, tablet, and mobile viewports, comparing each against `docs/ui/` screenshots and ensuring 100% test passing.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** PUB-01 through PUB-11  
**Success Criteria:**
1. All public routes load without browser console errors, broken images, or layout shifts.
2. Direct comparison confirms visual alignment with `docs/ui/` mockups in layout, typography, colors, and responsive behavior.
3. Full automated test suite passes with zero regressions.

---
*Roadmap defined: 2026-10-26 for Milestone v1.2*
