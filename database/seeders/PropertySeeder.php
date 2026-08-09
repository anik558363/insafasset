<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyImage;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'title' => 'Premium Land Plot in Bashundhara R/A',
                'description' => 'Excellent residential plot in one of Dhaka\'s most prestigious areas. Fully developed with all utilities available including gas, electricity, and water supply. Surrounded by high-end residential buildings and close to Jamuna Future Park.',
                'category_id' => 1, 'type' => 'land', 'listing_type' => 'sale',
                'price' => 12500000, 'price_unit' => 'per katha',
                'size' => 5, 'size_unit' => 'katha',
                'location_text' => 'Block-C, Bashundhara R/A, Dhaka',
                'division' => 'Dhaka', 'district' => 'Dhaka', 'area' => 'Bashundhara',
                'status' => 'available', 'featured' => true,
                'meta_title' => 'Premium Land Plot in Bashundhara R/A | LandMark Realty',
                'meta_description' => 'Buy prime residential land in Bashundhara R/A, Dhaka. 5 katha plot with all utilities.',
            ],
            [
                'title' => 'Luxurious 3BHK Apartment in Gulshan-2',
                'description' => 'Stunning 3 bedroom luxury flat in the heart of Gulshan-2. Floor to ceiling windows with city views, modular kitchen, premium finishing throughout. Building has 24/7 security, generator backup, and covered parking.',
                'category_id' => 2, 'type' => 'flat', 'listing_type' => 'sale',
                'price' => 18500000, 'price_unit' => 'total',
                'size' => 2200, 'size_unit' => 'sft',
                'bedrooms' => 3, 'bathrooms' => 3,
                'location_text' => 'Road-54, Gulshan-2, Dhaka-1212',
                'division' => 'Dhaka', 'district' => 'Dhaka', 'area' => 'Gulshan',
                'status' => 'available', 'featured' => true,
                'youtube_link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'meta_title' => 'Luxury 3BHK Flat for Sale in Gulshan-2 Dhaka',
                'meta_description' => '2200 sqft luxury apartment for sale in Gulshan-2. 3 beds, 3 baths, premium finishing.',
            ],
            [
                'title' => 'Modern Duplex House in Dhanmondi',
                'description' => 'Beautiful 4-bedroom duplex house in prime Dhanmondi location. Ground and first floor with rooftop access. Spacious drawing room, separate dining, master bedroom with attached bath. Close to hospitals, schools and shopping malls.',
                'category_id' => 3, 'type' => 'house', 'listing_type' => 'sale',
                'price' => 45000000, 'price_unit' => 'total',
                'size' => 3, 'size_unit' => 'katha',
                'bedrooms' => 4, 'bathrooms' => 4,
                'location_text' => 'Road-8A, Dhanmondi, Dhaka-1209',
                'division' => 'Dhaka', 'district' => 'Dhaka', 'area' => 'Dhanmondi',
                'status' => 'available', 'featured' => true,
                'meta_title' => 'Duplex House for Sale in Dhanmondi Dhaka',
                'meta_description' => '4-bed duplex house in Dhanmondi. 3 katha land, prime location.',
            ],
            [
                'title' => 'Commercial Space in Banani',
                'description' => 'Prime commercial space in Banani commercial area. Perfect for corporate office, showroom or retail. Ground floor unit with excellent street visibility. Air-conditioned with false ceiling and modern electrical fittings.',
                'category_id' => 4, 'type' => 'commercial', 'listing_type' => 'rent',
                'price' => 180000, 'price_unit' => 'per month',
                'size' => 3500, 'size_unit' => 'sft',
                'location_text' => 'Kamal Ataturk Ave, Banani, Dhaka-1213',
                'division' => 'Dhaka', 'district' => 'Dhaka', 'area' => 'Banani',
                'status' => 'available', 'featured' => true,
                'meta_title' => 'Commercial Space for Rent in Banani Dhaka',
                'meta_description' => '3500 sqft commercial space for rent in Banani. Ground floor with street visibility.',
            ],
            [
                'title' => 'Residential Land in Uttara Sector-11',
                'description' => 'Flat and clean residential land in Uttara sector-11. Ready to build. Close to Diabari Lake, easy access to Uttara Model Town. All amenities nearby including schools, hospitals, and shopping centers.',
                'category_id' => 1, 'type' => 'land', 'listing_type' => 'sale',
                'price' => 8500000, 'price_unit' => 'per katha',
                'size' => 3, 'size_unit' => 'katha',
                'location_text' => 'Sector-11, Uttara, Dhaka',
                'division' => 'Dhaka', 'district' => 'Dhaka', 'area' => 'Uttara',
                'status' => 'available', 'featured' => false,
            ],
            [
                'title' => '2BHK Flat for Rent in Mirpur-12',
                'description' => 'Cozy and well-maintained 2-bedroom apartment in Mirpur-12. Tiled floors, clean bathrooms, gas supply available. 6th floor with good natural light and ventilation. Close to Metro Rail station.',
                'category_id' => 2, 'type' => 'flat', 'listing_type' => 'rent',
                'price' => 22000, 'price_unit' => 'per month',
                'size' => 950, 'size_unit' => 'sft',
                'bedrooms' => 2, 'bathrooms' => 2,
                'location_text' => 'Section-2, Mirpur-12, Dhaka-1216',
                'division' => 'Dhaka', 'district' => 'Dhaka', 'area' => 'Mirpur',
                'status' => 'available', 'featured' => false,
            ],
            [
                'title' => 'Agricultural Land in Narsingdi',
                'description' => 'Fertile agricultural land in Narsingdi, suitable for farming, fish cultivation, or future residential development. Good road access and close to local market. Legal documents clear and ready for registration.',
                'category_id' => 1, 'type' => 'land', 'listing_type' => 'sale',
                'price' => 950000, 'price_unit' => 'per bigha',
                'size' => 10, 'size_unit' => 'bigha',
                'location_text' => 'Raypur Union, Narsingdi Sadar, Narsingdi',
                'division' => 'Dhaka', 'district' => 'Narsingdi', 'area' => 'Raypur',
                'status' => 'available', 'featured' => false,
            ],
            [
                'title' => 'Office Space in Mohammadpur',
                'description' => 'Furnished office space suitable for small to medium businesses. Features include built-in workstations, conference room, reception area, and high-speed internet infrastructure. Central A/C and IPS backup.',
                'category_id' => 4, 'type' => 'commercial', 'listing_type' => 'rent',
                'price' => 65000, 'price_unit' => 'per month',
                'size' => 1200, 'size_unit' => 'sft',
                'location_text' => 'Nurjahan Road, Mohammadpur, Dhaka-1207',
                'division' => 'Dhaka', 'district' => 'Dhaka', 'area' => 'Mohammadpur',
                'status' => 'available', 'featured' => false,
            ],
        ];

        foreach ($properties as $data) {
            $property = Property::create(array_merge($data, ['user_id' => 1]));

            // Create placeholder image record (using a placehold URL path marker)
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path'  => 'properties/placeholder-' . $property->id . '.jpg',
                'is_primary'  => true,
                'sort_order'  => 0,
                'created_at'  => now(),
            ]);
        }
    }
}
