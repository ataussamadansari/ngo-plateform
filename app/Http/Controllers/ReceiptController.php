<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\ReceiptPdfService;

class ReceiptController extends Controller
{
    /**
     * Download the official 80G PDF receipt for a verified donation.
     */
    public function download(Donation $donation, ReceiptPdfService $pdfService)
    {
        if ($donation->status !== 'verified') {
            abort(404, 'Receipt is only available for verified donations.');
        }

        $pdf = $pdfService->generatePdf($donation);

        return $pdf->download("Receipt-{$donation->receipt_number}.pdf");
    }

    /**
     * Stream/preview the 80G PDF receipt inline in the browser.
     */
    public function preview(Donation $donation, ReceiptPdfService $pdfService)
    {
        if ($donation->status !== 'verified') {
            abort(404, 'Receipt is only available for verified donations.');
        }

        $pdf = $pdfService->generatePdf($donation);

        return $pdf->stream("Receipt-{$donation->receipt_number}.pdf");
    }
}
