<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Payments for booking_id 1 (confirmed, partial — 500,000 paid)
        Payment::create([
            'booking_id'     => 1,
            'transaction_id' => 'TXN-BK-2026-0001',
            'amount'         => 500000.00,
            'payment_method' => 'bkash',
            'status'         => 'success',
            'paid_at'        => '2026-06-15 10:30:00',
            'created_at'     => '2026-06-15 10:30:00',
        ]);

        // Payment for booking_id 3 (confirmed, partial — 1,000,000 paid)
        Payment::create([
            'booking_id'     => 3,
            'transaction_id' => 'TXN-BK-2026-0002',
            'amount'         => 1000000.00,
            'payment_method' => 'nagad',
            'status'         => 'success',
            'paid_at'        => '2026-06-20 14:00:00',
            'created_at'     => '2026-06-20 14:00:00',
        ]);

        // Payment for booking_id 6 (confirmed, fully paid — 300,000)
        Payment::create([
            'booking_id'     => 6,
            'transaction_id' => 'TXN-BK-2026-0003',
            'amount'         => 300000.00,
            'payment_method' => 'sslcommerz',
            'status'         => 'success',
            'paid_at'        => '2026-06-18 11:15:00',
            'created_at'     => '2026-06-18 11:15:00',
        ]);
    }
}
