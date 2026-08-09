<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Arif Hossain',
                'designation' => 'Property Buyer',
                'message' => 'LandMark Realty helped me find my dream home in Dhanmondi within my budget. The team was professional, transparent, and guided me through every step. Highly recommended!',
                'rating' => 5,
            ],
            [
                'name' => 'Nusrat Jahan',
                'designation' => 'Land Investor',
                'message' => 'I have purchased two land plots through LandMark Realty. Their documentation process is impeccable and all properties are legally verified. Excellent service!',
                'rating' => 5,
            ],
            [
                'name' => 'Kamal Uddin',
                'designation' => 'Business Owner',
                'message' => 'Found the perfect commercial space for my showroom in Banani. The team understood my requirements and showed only relevant options. Saved a lot of time!',
                'rating' => 4,
            ],
            [
                'name' => 'Rashida Begum',
                'designation' => 'First-time Buyer',
                'message' => 'As a first-time buyer, I was nervous about the process. LandMark\'s team explained everything clearly and patiently. Very trustworthy company.',
                'rating' => 5,
            ],
            [
                'name' => 'Tanvir Ahmed',
                'designation' => 'NRB Investor',
                'message' => 'Being an NRB, I needed a reliable partner to invest in Dhaka real estate. LandMark Realty handled everything remotely and I was very impressed with their professionalism.',
                'rating' => 5,
            ],
            [
                'name' => 'Farhana Islam',
                'designation' => 'Tenant',
                'message' => 'Rented a flat in Mirpur through LandMark. The whole process from viewing to signing was smooth and fast. The flat is exactly as described. Great experience!',
                'rating' => 4,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }
    }
}
