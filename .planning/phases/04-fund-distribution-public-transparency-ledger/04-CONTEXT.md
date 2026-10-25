# Phase 4: Fund Distribution & Public Transparency Ledger - Context

**Gathered:** 2026-10-25  
**Status:** Ready for planning  
**Mode:** MVP (Vertical Slice)

<domain>
## Phase Boundary

Phase 4 delivers 100% financial transparency by providing back-office fund distribution recording paired with a public transparency ledger and cause-specific fund utilization breakdowns:
1. Administrative fund distribution recording engine supporting linked campaigns, beneficiary identification, amounts, dates, payment reference, bill/invoice upload, impact photos gallery, and public visibility toggle.
2. Mandatory `DB::transaction()` with pessimistic locking to automatically synchronize the linked campaign's `distributed_amount`.
3. Public transparency ledger page (`/transparency`) displaying high-level financial reconciliation (Total Verified Donations Raised vs. Total Funds Disbursed, Reserve Balance), category breakdown, and an itemized public ledger with proof documents.
4. Interactive modal/lightbox allowing public inspection of verified bills and impact photos.
5. Cause-specific fund utilization view displaying campaign goal, verified collections, disbursements, and expenditure items.
</domain>

<decisions>
## Implementation Decisions

### Administrative Fund Distribution Engine
- **D-01:** Admin routes under `/admin/distributions`:
  - `GET /admin/distributions` — Paginated list of all distributions with metrics (Total Distributed, Direct Beneficiaries Count, Linked Campaigns Count), status filters (public/internal), campaign filter, and date search.
  - `GET /admin/distributions/create` — Entry form for logging a disbursement.
  - `POST /admin/distributions` — Store disbursement, validate files, and update campaign balances.
  - `GET /admin/distributions/{distribution}` — Detail modal or inspection view showing bill invoice and impact photo gallery.
- **D-02:** File uploads:
  - `proof_bill_image`: Required or optional receipt/bill image stored in `storage/app/public/distributions/bills` (max 2MB, jpeg/png/webp/pdf).
  - `impact_photos`: Optional array of on-the-ground photos stored in `storage/app/public/distributions/impact` (max 2MB per image).

### Transactional Balance Synchronization
- **D-03:** Domain service `app/Services/FundDistributionService.php`:
  - `recordDistribution(array $data, ?UploadedFile $billFile = null, array $impactFiles = [], ?int $userId = null): FundDistribution`
  - Runs in `DB::transaction()`.
  - When `campaign_id` is present, executes `Campaign::lockForUpdate()->findOrFail($campaign_id)` and increments `distributed_amount` by `$amount_spent`.
  - Enforces non-negative expenditure amounts (`amount_spent > 0`).

### Public Transparency Ledger UX (`/transparency`)
- **D-04:** Public transparency page `GET /transparency`:
  - Live verified financial summary cards:
    - **Total Funds Raised**: Sum of verified donations (`Donation::where('status', 'verified')->sum('amount')`).
    - **Total Funds Distributed**: Sum of public distributions (`FundDistribution::where('is_public', true)->sum('amount_spent')`).
    - **Current Net Reserve / Active Balance**: `Total Raised - Total Distributed`.
    - **Direct Lives Impacted / Beneficiaries Count**: `FundDistribution::where('is_public', true)->count()`.
  - Fund Utilization Ratio (Visual progress bar / gauge showing % of collected funds disbursed directly to causes).
  - Categorized cause breakdown (e.g., Medical relief, Child education, Food kits, Disaster relief).
  - Itemized audit log table/cards with date, purpose, beneficiary, amount, and "View Proof" action.
  - Lightbox / modal popup for viewing bill invoices and impact photos without leaving the page.
- **D-05:** Campaign-specific utilization breakdown:
  - Route `GET /campaigns/{campaign:slug}/transparency` or integrated component on `/transparency?campaign={id}`.
  - Shows campaign target, verified collections, funds deployed, remaining balance, and itemized bills.
</decisions>

<canonical_refs>
## Canonical References
- Requirements: DIS-01, DIS-02, DIS-03, DIS-04 in `.planning/REQUIREMENTS.md`
- Project conventions: Financial precision (`decimal:2`), mandatory `DB::transaction()` for all disbursement mutations.
</canonical_refs>
