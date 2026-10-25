<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\FundDistribution;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class FundDistributionService
{
    /**
     * Atomically record a fund distribution entry, store proof files, and synchronize campaign balances.
     *
     * @param  array<string, mixed>  $data
     * @param  array<UploadedFile>  $impactFiles
     */
    public function recordDistribution(
        array $data,
        ?UploadedFile $billFile = null,
        array $impactFiles = [],
        ?int $userId = null
    ): FundDistribution {
        return DB::transaction(function () use ($data, $billFile, $impactFiles, $userId) {
            // 1. Process bill / invoice upload
            if ($billFile instanceof UploadedFile) {
                $data['proof_bill_image'] = $billFile->store('distributions/bills', 'public');
            }

            // 2. Process impact photo gallery uploads
            if (! empty($impactFiles)) {
                $storedPhotos = [];
                foreach ($impactFiles as $photo) {
                    if ($photo instanceof UploadedFile) {
                        $storedPhotos[] = $photo->store('distributions/impact', 'public');
                    }
                }
                $data['impact_photos'] = $storedPhotos;
            }

            // 3. Resolve creator ID
            $data['created_by'] = $userId ?? auth()->id() ?? User::where('role', 'super_admin')->first()?->id ?? User::first()?->id;

            // 4. Update campaign distributed_amount if linked
            if (! empty($data['campaign_id'])) {
                $campaign = Campaign::lockForUpdate()->findOrFail($data['campaign_id']);
                $newDistributed = (float) $campaign->distributed_amount + (float) $data['amount_spent'];
                $campaign->distributed_amount = round($newDistributed, 2);
                $campaign->save();
            }

            // 5. Persist distribution record
            return FundDistribution::create($data);
        });
    }
}
