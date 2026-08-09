<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = [
            [
                'property_id'    => 1,
                'user_id'        => 2,
                'customer_name'  => 'Rahim Ahmed',
                'phone'          => '01700000002',
                'email'          => 'customer@example.com',
                'preferred_date' => '2026-07-10',
                'message'        => 'I am interested in this land plot. Please confirm availability.',
                'status'         => 'confirmed',
                'advance_amount' => 500000,
                'payment_status' => 'partial',
                'admin_note'     => 'Advance received via bKash. Full payment due on registration day.',
            ],
            [
                'property_id'    => 2,
                'user_id'        => 2,
                'customer_name'  => 'Rahim Ahmed',
                'phone'          => '01700000002',
                'email'          => 'customer@example.com',
                'preferred_date' => '2026-07-15',
                'message'        => 'Looking for a luxury flat for my family. Would like to visit.',
                'status'         => 'pending',
                'advance_amount' => null,
                'payment_status' => 'unpaid',
                'admin_note'     => null,
            ],
            [
                'property_id'    => 3,
                'user_id'        => null,
                'customer_name'  => 'Karim Miah',
                'phone'          => '01811223344',
                'email'          => 'karim@example.com',
                'preferred_date' => '2026-06-25',
                'message'        => 'Interested in buying this duplex house. Can we schedule a visit?',
                'status'         => 'confirmed',
                'advance_amount' => 1000000,
                'payment_status' => 'partial',
                'admin_note'     => 'Customer visited on 2026-06-20. Advance taken.',
            ],
            [
                'property_id'    => 4,
                'user_id'        => null,
                'customer_name'  => 'Selina Akter',
                'phone'          => '01955667788',
                'email'          => 'selina@business.com',
                'preferred_date' => '2026-07-01',
                'message'        => 'Need the commercial space from next month for our garment showroom.',
                'status'         => 'rejected',
                'advance_amount' => null,
                'payment_status' => 'unpaid',
                'admin_note'     => 'Space already committed to another tenant.',
            ],
            [
                'property_id'    => 6,
                'user_id'        => null,
                'customer_name'  => 'Mahmud Hassan',
                'phone'          => '01622334455',
                'email'          => null,
                'preferred_date' => '2026-07-05',
                'message'        => 'Want to rent this flat. Family of 4 persons.',
                'status'         => 'pending',
                'advance_amount' => null,
                'payment_status' => 'unpaid',
                'admin_note'     => null,
            ],
            [
                'property_id'    => 5,
                'user_id'        => null,
                'customer_name'  => 'Nasrin Begum',
                'phone'          => '01733445566',
                'email'          => 'nasrin@gmail.com',
                'preferred_date' => '2026-08-01',
                'message'        => 'I want to purchase this land for building a house.',
                'status'         => 'confirmed',
                'advance_amount' => 300000,
                'payment_status' => 'paid',
                'admin_note'     => 'Full advance paid. Registration scheduled for August.',
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }
    }
}
