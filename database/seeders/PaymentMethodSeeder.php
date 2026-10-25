<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. UPI QR Code Method
        PaymentMethod::updateOrCreate(
            ['type' => 'upi_qr'],
            [
                'label' => 'UPI Payment (GPay, PhonePe, Paytm, BHIM)',
                'upi_id' => 'kashiseva@upi',
                'qr_image_path' => 'payment_methods/default_upi_qr.svg',
                'is_active' => true,
                'display_order' => 1,
            ]
        );

        // 2. Direct Bank Transfer Method
        PaymentMethod::updateOrCreate(
            ['type' => 'bank_account'],
            [
                'label' => 'Direct Bank Transfer',
                'bank_name' => 'State Bank of India',
                'account_holder_name' => 'Kashi Seva Foundation',
                'account_number' => '41238901234',
                'ifsc_code' => 'SBIN0001234',
                'branch_name' => 'Assi Ghat Branch, Varanasi',
                'is_active' => true,
                'display_order' => 2,
            ]
        );
    }
}
