<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,           // users (admin, agent, customers)
            CategorySeeder::class,       // land, flat, house, commercial
            LocationSeeder::class,       // divisions → districts → areas
            PropertySeeder::class,       // properties + primary images
            BookingSeeder::class,        // bookings (depends on properties + users)
            PaymentSeeder::class,        // payments (depends on bookings)
            TestimonialSeeder::class,    // client testimonials
            ContactMessageSeeder::class, // contact form messages
            SettingSeeder::class,        // site settings
        ]);
    }
}
