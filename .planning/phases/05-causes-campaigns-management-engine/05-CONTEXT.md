# Phase 5: Causes & Campaigns Management Engine - Context

**Gathered:** 2026-10-25  
**Status:** Ready for planning  
**Mode:** MVP (Vertical Slice)

<domain>
## Phase Boundary

Phase 5 delivers the causes and fundraising campaigns management engine, providing both back-office campaign orchestration and public discovery/detail experiences:
1. Cause Category management (Medical, Child Education, Ration & Nutrition, Disaster Relief, etc.) with active/inactive toggles.
2. Comprehensive administrative campaign management: title, slug auto-generation, category association, target goal amount, rich narrative/story, thumbnail upload, gallery photos, start/end dates, urgent flag, featured flag, and status transitions (`draft`, `active`, `completed`, `paused`).
3. Public causes directory (`/campaigns`) with category pill filters, search, urgent cause highlights, and live financial progress bars.
4. High-conversion cause detail view (`/campaigns/{slug}`) featuring full narrative story, photo gallery lightbox, live progress bar (Target vs. Verified Raised), recent verified donors stream, fund utilization preview, and direct donation CTA linking to `/donate?campaign_id={id}`.
5. Strict financial consistency: campaign `raised_amount` and `distributed_amount` remain synchronized exclusively with verified donations and verified disbursements.
</domain>

<decisions>
## Implementation Decisions

### Category & Campaign Administration
- **D-01:** Admin routes under `/admin/categories` and `/admin/campaigns`:
  - `GET /admin/categories` & `POST /admin/categories` — Category list & inline creation.
  - `PUT /admin/categories/{category}` & `DELETE /admin/categories/{category}` — Category editing & deletion.
  - `GET /admin/campaigns` — Listing of all campaigns with status tabs (`All`, `Active`, `Draft`, `Completed`, `Paused`), progress bars, and search.
  - `GET /admin/campaigns/create` & `POST /admin/campaigns` — Campaign builder form.
  - `GET /admin/campaigns/{campaign}/edit` & `PUT /admin/campaigns/{campaign}` — Campaign editing.
  - `PATCH /admin/campaigns/{campaign}/status` — Quick status toggle (`active`, `completed`, `paused`, `draft`).
- **D-02:** File uploads:
  - `thumbnail_image`: Main card image stored in `storage/app/public/campaigns/thumbnails` (max 2MB, jpeg/png/webp).
  - `gallery_images`: Array of story photos stored in `storage/app/public/campaigns/galleries` (max 2MB per image, up to 8 images).

### Public Causes & Story Experience
- **D-03:** Public routes:
  - `GET /campaigns` — Causes directory with category filtering, urgent badges, and pagination.
  - `GET /campaigns/{campaign:slug}` — Rich campaign story page.
- **D-04:** Cause detail page layout:
  - Left column: Campaign hero banner, category badge, urgent badge, full story, photo gallery lightbox, cause utilization audit link, and verified donors stream.
  - Right sticky column: Financial goal card, live progress bar (% funded, ₹ raised of ₹ goal), remaining amount, direct "Donate Now" CTA button pre-selecting this campaign, and 80G tax benefit reminder.
- **D-05:** Verified donors stream on cause page:
  - Only donations where `status = 'verified'` are displayed.
  - Respects donor privacy: if `is_anonymous = true`, displays as *"Anonymous Supporter"*.
</decisions>

<canonical_refs>
## Canonical References
- Requirements: CMP-01, CMP-02, CMP-03, CMP-04 in `.planning/REQUIREMENTS.md`
- Database schema: `cause_categories` and `campaigns` tables created in Phase 1.
</canonical_refs>
