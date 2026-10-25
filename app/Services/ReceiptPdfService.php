<?php

namespace App\Services;

use App\Models\Donation;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdfWrapper;

class ReceiptPdfService
{
    /**
     * Generate an official 80G PDF receipt instance for a verified donation.
     */
    public function generatePdf(Donation $donation): DomPdfWrapper
    {
        $amountInWords = $this->amountToWords((float) $donation->amount);

        $pdf = Pdf::loadView('receipts.80g', [
            'donation' => $donation,
            'amountInWords' => $amountInWords,
            'ngoName' => setting('ngo_name', 'Kashi Seva Foundation'),
            'ngoTagline' => setting('ngo_tagline', 'Serving Humanity with Complete Transparency'),
            'ngoRegNumber' => setting('ngo_reg_number', 'UP/2024/0045891'),
            'ngoPanNumber' => setting('ngo_pan_number', 'AABTK1234F'),
            'has80g' => (bool) setting('has_80g', true),
            'reg80gNumber' => setting('80g_reg_number', 'AABTK1234FF20241'),
            'authorizedSignName' => setting('authorized_sign_name', 'R. K. Sharma (President)'),
            'authorizedSignImage' => setting('authorized_sign_image', 'settings/signature.png'),
            'contactAddress' => setting('contact_address', 'B-12, Assi Ghat Road, Varanasi, UP - 221005'),
            'contactPhone' => setting('contact_phone', '+91 9876543210'),
            'contactEmail' => setting('contact_email', 'contact@kashiseva.org'),
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    /**
     * Convert currency amount to words (Indian English numbering format).
     */
    public function amountToWords(float $amount): string
    {
        $amount = round($amount, 2);
        $rupees = (int) floor($amount);
        $paise = (int) round(($amount - $rupees) * 100);

        $words = 'Rupees '.$this->numberToIndianWords($rupees);

        if ($paise > 0) {
            $words .= ' and '.$this->numberToIndianWords($paise).' Paise';
        }

        return $words.' Only';
    }

    /**
     * Helper to convert integer to Indian numbering format (Crore, Lakh, Thousand, Hundred).
     */
    protected function numberToIndianWords(int $num): string
    {
        if ($num === 0) {
            return 'Zero';
        }

        $ones = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
            18 => 'Eighteen', 19 => 'Nineteen',
        ];

        $tens = [
            2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty',
            6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety',
        ];

        $parts = [];

        // Crores (1,00,00,000)
        if ($num >= 10000000) {
            $crores = (int) floor($num / 10000000);
            $parts[] = $this->numberToIndianWords($crores).' Crore';
            $num %= 10000000;
        }

        // Lakhs (1,00,000)
        if ($num >= 100000) {
            $lakhs = (int) floor($num / 100000);
            $parts[] = $this->numberToIndianWords($lakhs).' Lakh';
            $num %= 100000;
        }

        // Thousands (1,000)
        if ($num >= 1000) {
            $thousands = (int) floor($num / 1000);
            $parts[] = $this->numberToIndianWords($thousands).' Thousand';
            $num %= 1000;
        }

        // Hundreds (100)
        if ($num >= 100) {
            $hundreds = (int) floor($num / 100);
            $parts[] = $ones[$hundreds].' Hundred';
            $num %= 100;
        }

        // Tens and Ones (<100)
        if ($num > 0) {
            if ($num < 20) {
                $parts[] = $ones[$num];
            } else {
                $t = (int) floor($num / 10);
                $o = $num % 10;
                $parts[] = $tens[$t].($o > 0 ? ' '.$ones[$o] : '');
            }
        }

        return implode(' ', $parts);
    }
}
