<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactMessage;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name'       => 'Abdul Karim',
                'email'      => 'akarim@gmail.com',
                'phone'      => '01711223344',
                'subject'    => 'Looking for land in Uttara',
                'message'    => 'I am looking for a 3-5 katha residential plot in Uttara sector 7 or 11. Budget is around 30 lakhs per katha. Please contact me if you have any listings.',
                'is_read'    => true,
                'created_at' => '2026-06-10 09:15:00',
            ],
            [
                'name'       => 'Shahana Islam',
                'email'      => 'shahana.islam@yahoo.com',
                'phone'      => '01833445566',
                'subject'    => 'Inquiry about Gulshan apartment',
                'message'    => 'Hello, I saw your listing for the Gulshan-2 apartment. I would like to know more about the building age and current maintenance charges.',
                'is_read'    => true,
                'created_at' => '2026-06-12 14:30:00',
            ],
            [
                'name'       => 'Jahangir Alam',
                'email'      => 'j.alam@business.net',
                'phone'      => '01955443322',
                'subject'    => 'Commercial space requirement',
                'message'    => 'We are a pharmaceutical company looking for 5000+ sqft warehouse space in Gazipur or Savar area. Ready to sign a 3-year lease. Please get back to us.',
                'is_read'    => false,
                'created_at' => '2026-06-14 11:00:00',
            ],
            [
                'name'       => 'Rumana Khanam',
                'email'      => 'rumana.k@gmail.com',
                'phone'      => null,
                'subject'    => 'Flat for rent inquiry',
                'message'    => 'I need a 2-bedroom flat for rent in Dhanmondi or Mohammadpur area. Maximum budget 25,000 BDT per month. Preferred ground or 1st floor.',
                'is_read'    => false,
                'created_at' => '2026-06-17 16:45:00',
            ],
            [
                'name'       => 'Tariqul Islam',
                'email'      => 'tariq@nrb.com',
                'phone'      => '+44 7700 900123',
                'subject'    => 'NRB investment inquiry',
                'message'    => 'I am an NRB based in UK. Looking to invest in Dhaka real estate. Interested in 2-3 flats or a commercial space. Need help with the legal process for NRB buyers.',
                'is_read'    => false,
                'created_at' => '2026-06-19 08:00:00',
            ],
            [
                'name'       => 'Mofizur Rahman',
                'email'      => 'mofiz.r@hotmail.com',
                'phone'      => '01622001100',
                'subject'    => 'Agricultural land in Narsingdi',
                'message'    => 'I am interested in purchasing agricultural land in Narsingdi district. Do you have more listings in that area? What is the minimum area available?',
                'is_read'    => false,
                'created_at' => '2026-06-21 10:20:00',
            ],
        ];

        foreach ($messages as $msg) {
            ContactMessage::create($msg);
        }
    }
}
