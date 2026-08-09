<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $dhaka = Location::create(['name' => 'Dhaka', 'type' => 'division', 'parent_id' => null]);
        $chittagong = Location::create(['name' => 'Chittagong', 'type' => 'division', 'parent_id' => null]);

        $dhakaDistrict = Location::create(['name' => 'Dhaka', 'type' => 'district', 'parent_id' => $dhaka->id]);
        $gazipur = Location::create(['name' => 'Gazipur', 'type' => 'district', 'parent_id' => $dhaka->id]);
        $narsingdi = Location::create(['name' => 'Narsingdi', 'type' => 'district', 'parent_id' => $dhaka->id]);
        $ctgDistrict = Location::create(['name' => 'Chittagong', 'type' => 'district', 'parent_id' => $chittagong->id]);

        $areas = [
            ['name' => 'Gulshan',      'parent_id' => $dhakaDistrict->id],
            ['name' => 'Banani',       'parent_id' => $dhakaDistrict->id],
            ['name' => 'Dhanmondi',    'parent_id' => $dhakaDistrict->id],
            ['name' => 'Uttara',       'parent_id' => $dhakaDistrict->id],
            ['name' => 'Mirpur',       'parent_id' => $dhakaDistrict->id],
            ['name' => 'Bashundhara',  'parent_id' => $dhakaDistrict->id],
            ['name' => 'Mohammadpur',  'parent_id' => $dhakaDistrict->id],
            ['name' => 'Tongi',        'parent_id' => $gazipur->id],
            ['name' => 'Joydebpur',    'parent_id' => $gazipur->id],
            ['name' => 'Nasirabad',    'parent_id' => $ctgDistrict->id],
        ];

        foreach ($areas as $area) {
            Location::create(array_merge($area, ['type' => 'area']));
        }
    }
}
