<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Donation Receipt - {{ $donation->receipt_number }}</title>
    <style>
        @page {
            margin: 24px 30px;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .receipt-container {
            border: 2px solid #0f172a;
            padding: 24px 28px;
            position: relative;
            background: #ffffff;
        }
        .inner-border {
            border: 1px solid #cbd5e1;
            padding: 16px 20px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #16a34a;
            padding-bottom: 12px;
            margin-bottom: 14px;
        }
        .ngo-name {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .ngo-tagline {
            font-size: 11px;
            color: #16a34a;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .ngo-meta {
            font-size: 10px;
            color: #475569;
            line-height: 1.35;
        }
        .receipt-title-box {
            background-color: #f0fdf4;
            border: 1px solid #86efac;
            text-align: center;
            padding: 8px 12px;
            margin-bottom: 16px;
            border-radius: 4px;
        }
        .receipt-title {
            font-size: 13px;
            font-weight: bold;
            color: #166534;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .receipt-subtitle {
            font-size: 10px;
            color: #15803d;
            margin-top: 2px;
        }
        .meta-grid-table {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }
        .meta-grid-table td {
            padding: 4px 8px;
            font-size: 11px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .meta-label {
            font-weight: bold;
            color: #475569;
            width: 25%;
        }
        .meta-val {
            color: #0f172a;
            font-weight: 600;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 14px;
            margin-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .details-table th, .details-table td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            font-size: 11px;
        }
        .details-table th {
            background-color: #f1f5f9;
            color: #334155;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .amount-highlight {
            font-size: 14px;
            font-weight: bold;
            color: #166534;
        }
        .words-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            padding: 8px 12px;
            font-style: italic;
            color: #334155;
            margin-bottom: 16px;
            font-size: 11px;
        }
        .undertaking {
            font-size: 9.5px;
            color: #64748b;
            line-height: 1.4;
            margin-bottom: 20px;
            text-align: justify;
        }
        .signature-table {
            width: 100%;
            margin-top: 20px;
        }
        .signature-box {
            text-align: center;
            width: 45%;
        }
        .signature-line {
            border-top: 1px solid #475569;
            margin-top: 40px;
            padding-top: 4px;
            font-size: 10px;
            font-weight: bold;
            color: #0f172a;
        }
        .seal-box {
            border: 2px dashed #94a3b8;
            padding: 8px;
            border-radius: 50%;
            width: 65px;
            height: 65px;
            display: inline-block;
            text-align: center;
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            line-height: 1.1;
            margin: 0 auto;
        }
        .footer-note {
            text-align: center;
            font-size: 8.5px;
            color: #94a3b8;
            margin-top: 18px;
            border-top: 1px solid #f1f5f9;
            padding-top: 6px;
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <div class="inner-border">

        <!-- NGO Header -->
        <table class="header-table">
            <tr>
                <td style="width: 70%; vertical-align: top;">
                    <div class="ngo-name">{{ $ngoName }}</div>
                    <div class="ngo-tagline">{{ $ngoTagline }}</div>
                    <div class="ngo-meta">
                        {{ $contactAddress }}<br>
                        Phone: {{ $contactPhone }} | Email: {{ $contactEmail }}<br>
                        NGO Reg. No: <strong>{{ $ngoRegNumber }}</strong> | PAN: <strong>{{ $ngoPanNumber }}</strong>
                    </div>
                </td>
                <td style="width: 30%; text-align: right; vertical-align: top;">
                    <div style="font-size: 26px; font-weight: 900; color: #16a34a; letter-spacing: -1px; text-transform: uppercase;">
                        80G TAX EXEMPT
                    </div>
                    <div style="font-size: 10px; color: #475569; font-weight: bold; margin-top: 2px;">
                        Income Tax Act, 1961
                    </div>
                </td>
            </tr>
        </table>

        <!-- 80G Exemption Notice Box -->
        <div class="receipt-title-box">
            <div class="receipt-title">DONATION RECEIPT & 80G CERTIFICATE</div>
            <div class="receipt-subtitle">
                Donations are 50% tax exempt under Section 80G(5)(vi) of the Income Tax Act, 1961.<br>
                Registration / URN Number: <strong>{{ $reg80gNumber }}</strong>
            </div>
        </div>

        <!-- Receipt & Date Metadata -->
        <table class="meta-grid-table">
            <tr>
                <td class="meta-label">Receipt Number:</td>
                <td class="meta-val" style="font-family: monospace; font-size: 12px; color: #166534;">{{ $donation->receipt_number }}</td>
                <td class="meta-label">Date of Issue:</td>
                <td class="meta-val">{{ $donation->verified_at ? $donation->verified_at->format('d/m/Y') : date('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="meta-label">Payment Mode:</td>
                <td class="meta-val">{{ strtoupper(str_replace('_', ' ', $donation->payment_mode)) }}</td>
                <td class="meta-label">Financial Year:</td>
                <td class="meta-val">{{ (date('m') >= 4 ? date('Y') : date('Y')-1) . '-' . (date('m') >= 4 ? date('y')+1 : date('y')) }}</td>
            </tr>
        </table>

        <!-- Donor Particulars -->
        <div class="section-title">Donor Particulars</div>
        <table class="meta-grid-table" style="margin-bottom: 14px;">
            <tr>
                <td class="meta-label">Received With Thanks From:</td>
                <td class="meta-val" colspan="3" style="font-size: 12px;">{{ $donation->donor_name }}</td>
            </tr>
            <tr>
                <td class="meta-label">Donor PAN:</td>
                <td class="meta-val" style="font-family: monospace;">{{ $donation->donor_pan ?? 'NOT PROVIDED' }}</td>
                <td class="meta-label">Mobile Number:</td>
                <td class="meta-val">{{ $donation->donor_phone }}</td>
            </tr>
            @if($donation->donor_address)
            <tr>
                <td class="meta-label">Postal Address:</td>
                <td class="meta-val" colspan="3">{{ $donation->donor_address }}</td>
            </tr>
            @endif
        </table>

        <!-- Contribution Particulars Table -->
        <div class="section-title">Contribution Breakdown</div>
        <table class="details-table">
            <thead>
                <tr>
                    <th style="width: 45%;">Particulars / Purpose</th>
                    <th style="width: 30%;">UTR / Transaction Ref No.</th>
                    <th style="width: 25%; text-align: right;">Amount (INR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $donation->campaign->title ?? 'General Humanitarian Relief Fund' }}</strong><br>
                        <span style="font-size: 9.5px; color: #64748b;">Direct charitable relief with complete transparency</span>
                    </td>
                    <td style="font-family: monospace; font-size: 11px;">
                        {{ $donation->utr_number }}
                    </td>
                    <td style="text-align: right;" class="amount-highlight">
                        ₹{{ number_format($donation->amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right; font-weight: bold; background: #f8fafc;">
                        TOTAL DONATION RECEIVED:
                    </td>
                    <td style="text-align: right; font-weight: bold; font-size: 13px; color: #166534; background: #f8fafc;">
                        ₹{{ number_format($donation->amount, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Amount in Words Box -->
        <div class="words-box">
            <strong>Amount in Words:</strong> {{ $amountInWords }}
        </div>

        <!-- Statutory Undertaking -->
        <div class="undertaking">
            <strong>Declaration:</strong> We hereby certify that the donation described above has been received and credited to our non-profit bank account. This organization is registered under relevant Societies/Trusts Acts and holds a valid certificate of exemption under Section 80G of the Income Tax Act, 1961. This receipt is issued electronically as a verified document for the purpose of claiming tax deduction.
        </div>

        <!-- Signatures & Authority -->
        <table class="signature-table">
            <tr>
                <td class="signature-box" style="text-align: left;">
                    <div style="font-size: 10px; color: #64748b;">Verified Transaction Record</div>
                    <div style="font-size: 9px; font-family: monospace; color: #0f172a; margin-top: 4px;">
                        Hash: {{ hash('sha256', $donation->receipt_number . $donation->utr_number . $donation->amount) }}
                    </div>
                    <div style="font-size: 9px; color: #16a34a; font-weight: bold; margin-top: 4px;">
                        &check; Verified Against Bank Credit
                    </div>
                </td>
                <td style="width: 10%;"></td>
                <td class="signature-box" style="text-align: right;">
                    <div style="height: 40px; margin-bottom: 4px;">
                        <!-- Digital Signature Stamp -->
                        <span style="font-family: 'Brush Script MT', cursive, sans-serif; font-size: 22px; color: #1e3a8a;">
                            {{ $authorizedSignName }}
                        </span>
                    </div>
                    <div class="signature-line" style="text-align: right;">
                        For {{ $ngoName }}<br>
                        <span style="font-size: 9px; color: #64748b;">{{ $authorizedSignName }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer-note">
            This is an authentic computer-generated official receipt. To verify authenticity, visit {{ url('/donation-status') }} and enter UTR {{ $donation->utr_number }}.
        </div>

    </div>
</div>

</body>
</html>
