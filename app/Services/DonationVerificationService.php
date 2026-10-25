<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Donation;
use DomainException;
use Illuminate\Support\Facades\DB;

class DonationVerificationService
{
    /**
     * Atomically approve a pending donation and increment linked campaign balance.
     *
     * @throws DomainException
     */
    public function approve(Donation $donation, ?int $verifiedById = null): Donation
    {
        return DB::transaction(function () use ($donation, $verifiedById) {
            /** @var Donation $locked */
            $locked = Donation::lockForUpdate()->findOrFail($donation->id);

            if ($locked->status !== 'pending') {
                throw new DomainException("Cannot approve donation #{$locked->id} because its current status is '{$locked->status}'.");
            }

            $receiptNumber = $this->generateNextReceiptNumber();

            $locked->update([
                'status' => 'verified',
                'receipt_number' => $receiptNumber,
                'verified_by' => $verifiedById,
                'verified_at' => now(),
            ]);

            // Increment campaign raised_amount if linked to a campaign
            if ($locked->campaign_id) {
                Campaign::where('id', $locked->campaign_id)->increment('raised_amount', $locked->amount);
            }

            return $locked;
        });
    }

    /**
     * Reject a donation with admin explanation remarks.
     */
    public function reject(Donation $donation, string $remarks, ?int $verifiedById = null): Donation
    {
        return DB::transaction(function () use ($donation, $remarks, $verifiedById) {
            /** @var Donation $locked */
            $locked = Donation::lockForUpdate()->findOrFail($donation->id);

            if ($locked->status === 'verified') {
                throw new DomainException("Cannot reject already verified donation #{$locked->id}.");
            }

            $locked->update([
                'status' => 'rejected',
                'admin_remarks' => $remarks,
                'verified_by' => $verifiedById,
                'verified_at' => now(),
            ]);

            return $locked;
        });
    }

    /**
     * Record an offline/cash/direct donation directly marked as verified.
     */
    public function createDirectVerified(array $data, ?int $createdById = null): Donation
    {
        return DB::transaction(function () use ($data, $createdById) {
            $receiptNumber = $this->generateNextReceiptNumber();

            $utrNumber = ! empty($data['utr_number'])
                ? trim($data['utr_number'])
                : 'OFFLINE-'.strtoupper(uniqid());

            $donation = Donation::create([
                'campaign_id' => $data['campaign_id'] ?? null,
                'receipt_number' => $receiptNumber,
                'donor_name' => $data['donor_name'],
                'donor_email' => $data['donor_email'] ?? null,
                'donor_phone' => $data['donor_phone'] ?? '0000000000',
                'donor_pan' => ! empty($data['donor_pan']) ? strtoupper(trim($data['donor_pan'])) : null,
                'donor_address' => $data['donor_address'] ?? null,
                'amount' => $data['amount'],
                'payment_mode' => $data['payment_mode'] ?? 'cash',
                'utr_number' => $utrNumber,
                'payment_screenshot' => $data['payment_screenshot'] ?? null,
                'donor_message' => $data['donor_message'] ?? null,
                'is_anonymous' => ! empty($data['is_anonymous']),
                'status' => 'verified',
                'admin_remarks' => $data['admin_remarks'] ?? 'Direct offline entry verified by administrator.',
                'verified_by' => $createdById,
                'verified_at' => now(),
            ]);

            if ($donation->campaign_id) {
                Campaign::where('id', $donation->campaign_id)->increment('raised_amount', $donation->amount);
            }

            return $donation;
        });
    }

    /**
     * Generate the next unique sequential receipt number in format: {PREFIX}-{YEAR}-{0001}.
     */
    public function generateNextReceiptNumber(): string
    {
        $prefix = setting('receipt_prefix', 'KSF');
        $year = date('Y');
        $pattern = "{$prefix}-{$year}-%";

        $lastNumber = Donation::whereNotNull('receipt_number')
            ->where('receipt_number', 'LIKE', $pattern)
            ->count();

        $nextSequence = $lastNumber + 1;

        return sprintf('%s-%s-%04d', $prefix, $year, $nextSequence);
    }
}
