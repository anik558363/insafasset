<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── Website / Branding ─────────────────────────────────────────
            ['key' => 'site_name',       'group' => 'website', 'type' => 'text',     'label' => 'Site Name',           'value' => 'LandMark Realty'],
            ['key' => 'site_tagline',    'group' => 'website', 'type' => 'text',     'label' => 'Site Tagline',        'value' => 'Your Trusted Real Estate Partner in Bangladesh'],
            ['key' => 'site_logo',       'group' => 'website', 'type' => 'image',    'label' => 'Logo',                'value' => 'logo.jpeg'],
            ['key' => 'site_favicon',    'group' => 'website', 'type' => 'image',    'label' => 'Favicon',             'value' => ''],
            ['key' => 'copyright_text',  'group' => 'website', 'type' => 'text',     'label' => 'Footer Copyright',    'value' => 'LandMark Realty. All rights reserved.'],

            // ── Company / Contact Info ─────────────────────────────────────
            ['key' => 'company_phone',   'group' => 'company', 'type' => 'text',     'label' => 'Primary Phone',       'value' => '+880 1700-000000'],
            ['key' => 'company_phone2',  'group' => 'company', 'type' => 'text',     'label' => 'Secondary Phone',     'value' => ''],
            ['key' => 'company_email',   'group' => 'company', 'type' => 'email',    'label' => 'Email Address',       'value' => 'info@landmarkrealty.com'],
            ['key' => 'company_address', 'group' => 'company', 'type' => 'textarea', 'label' => 'Office Address',      'value' => 'House-12, Road-5, Gulshan-1, Dhaka-1212'],
            ['key' => 'company_hours',   'group' => 'company', 'type' => 'text',     'label' => 'Office Hours',        'value' => 'Sun–Thu: 9AM – 6PM'],
            ['key' => 'company_whatsapp','group' => 'company', 'type' => 'text',     'label' => 'WhatsApp Number',     'value' => '+8801700000000'],
            ['key' => 'company_map_url', 'group' => 'company', 'type' => 'textarea', 'label' => 'Google Maps (paste full embed code or the embed URL)','value' => ''],

            // ── Social Media ───────────────────────────────────────────────
            ['key' => 'social_facebook',  'group' => 'social', 'type' => 'url',  'label' => 'Facebook URL',   'value' => 'https://facebook.com/landmarkrealty'],
            ['key' => 'social_instagram', 'group' => 'social', 'type' => 'url',  'label' => 'Instagram URL',  'value' => 'https://instagram.com/landmarkrealty'],
            ['key' => 'social_youtube',   'group' => 'social', 'type' => 'url',  'label' => 'YouTube URL',    'value' => 'https://youtube.com/@landmarkrealty'],
            ['key' => 'social_linkedin',  'group' => 'social', 'type' => 'url',  'label' => 'LinkedIn URL',   'value' => ''],

            // ── Home Page ──────────────────────────────────────────────────
            ['key' => 'home_hero_badge',      'group' => 'home', 'type' => 'text',     'label' => 'Hero Badge Text',      'value' => "Bangladesh's Trusted Real Estate Platform"],
            ['key' => 'home_hero_title',      'group' => 'home', 'type' => 'text',     'label' => 'Hero Title',           'value' => 'Find Your Perfect Property in Bangladesh'],
            ['key' => 'home_hero_subtitle',   'group' => 'home', 'type' => 'textarea', 'label' => 'Hero Subtitle',        'value' => 'Explore thousands of verified land, flats, houses and commercial properties for sale and rent. Your dream property is just a search away.'],
            ['key' => 'home_stats_properties','group' => 'home', 'type' => 'text',     'label' => 'Stats: Properties Label','value' => 'Available Properties'],
            ['key' => 'home_stats_sold_label','group' => 'home', 'type' => 'text',     'label' => 'Stats: Deals Label',   'value' => 'Successful Deals'],
            ['key' => 'home_stats_clients',   'group' => 'home', 'type' => 'number',   'label' => 'Stats: Happy Clients', 'value' => '500'],
            ['key' => 'home_stats_years',     'group' => 'home', 'type' => 'number',   'label' => 'Stats: Years Experience','value' => '10'],
            ['key' => 'home_why_title',       'group' => 'home', 'type' => 'text',     'label' => 'Why Us Section Title', 'value' => 'Why Choose LandMark Realty?'],
            ['key' => 'home_why_subtitle',    'group' => 'home', 'type' => 'textarea', 'label' => 'Why Us Section Subtitle','value' => 'We stand apart with our commitment to transparency, verified listings, and exceptional customer care.'],
            ['key' => 'home_why_card1_icon',  'group' => 'home', 'type' => 'text',     'label' => 'Why Card 1 Icon',      'value' => 'bi-shield-check'],
            ['key' => 'home_why_card1_title', 'group' => 'home', 'type' => 'text',     'label' => 'Why Card 1 Title',     'value' => 'Verified Listings'],
            ['key' => 'home_why_card1_text',  'group' => 'home', 'type' => 'textarea', 'label' => 'Why Card 1 Text',      'value' => 'Every property is personally verified by our team. No fraud, no fake listings — only authentic, legally clear properties.'],
            ['key' => 'home_why_card2_icon',  'group' => 'home', 'type' => 'text',     'label' => 'Why Card 2 Icon',      'value' => 'bi-people'],
            ['key' => 'home_why_card2_title', 'group' => 'home', 'type' => 'text',     'label' => 'Why Card 2 Title',     'value' => 'Expert Guidance'],
            ['key' => 'home_why_card2_text',  'group' => 'home', 'type' => 'textarea', 'label' => 'Why Card 2 Text',      'value' => 'Our experienced team guides you from property search to final registration, making the process smooth and stress-free.'],
            ['key' => 'home_why_card3_icon',  'group' => 'home', 'type' => 'text',     'label' => 'Why Card 3 Icon',      'value' => 'bi-clock-history'],
            ['key' => 'home_why_card3_title', 'group' => 'home', 'type' => 'text',     'label' => 'Why Card 3 Title',     'value' => 'Fast & Efficient'],
            ['key' => 'home_why_card3_text',  'group' => 'home', 'type' => 'textarea', 'label' => 'Why Card 3 Text',      'value' => 'We respect your time. From first inquiry to deal close, we ensure the fastest possible turnaround without cutting corners.'],
            ['key' => 'home_why_card4_icon',  'group' => 'home', 'type' => 'text',     'label' => 'Why Card 4 Icon',      'value' => 'bi-hand-thumbs-up'],
            ['key' => 'home_why_card4_title', 'group' => 'home', 'type' => 'text',     'label' => 'Why Card 4 Title',     'value' => 'After-Sale Support'],
            ['key' => 'home_why_card4_text',  'group' => 'home', 'type' => 'textarea', 'label' => 'Why Card 4 Text',      'value' => "Our relationship doesn't end at the deal. We provide ongoing support including documentation and mutation assistance."],
            ['key' => 'home_cta_title',       'group' => 'home', 'type' => 'text',     'label' => 'CTA Banner Title',     'value' => 'Ready to Find Your Dream Property?'],
            ['key' => 'home_cta_subtitle',    'group' => 'home', 'type' => 'textarea', 'label' => 'CTA Banner Subtitle',  'value' => 'Talk to our experts today. Free consultation, no obligation.'],

            // ── About Page ─────────────────────────────────────────────────
            ['key' => 'about_hero_title',    'group' => 'about', 'type' => 'text',     'label' => 'Hero Title',           'value' => 'About LandMark Realty'],
            ['key' => 'about_hero_subtitle', 'group' => 'about', 'type' => 'textarea', 'label' => 'Hero Subtitle',        'value' => "Bangladesh's most trusted real estate company, dedicated to helping families and businesses find their perfect space."],
            ['key' => 'about_story_label',   'group' => 'about', 'type' => 'text',     'label' => 'Story Section Label',  'value' => 'Our Story'],
            ['key' => 'about_story_title',   'group' => 'about', 'type' => 'text',     'label' => 'Story Title',          'value' => 'A Decade of Building Dreams'],
            ['key' => 'about_story_para1',   'group' => 'about', 'type' => 'textarea', 'label' => 'Story Paragraph 1',   'value' => 'Founded in 2014, LandMark Realty began with a simple mission: to make property transactions in Bangladesh transparent, trustworthy, and accessible to everyone.'],
            ['key' => 'about_story_para2',   'group' => 'about', 'type' => 'textarea', 'label' => 'Story Paragraph 2',   'value' => 'Today, we are one of the leading real estate platforms operating across Dhaka, Chittagong, and beyond — having facilitated over 500 successful property transactions for satisfied clients.'],
            ['key' => 'about_story_para3',   'group' => 'about', 'type' => 'textarea', 'label' => 'Story Paragraph 3',   'value' => 'Our team of licensed agents and property experts brings unmatched market knowledge, ensuring every client gets the best value and a seamless experience from property search to key handover.'],
            ['key' => 'about_stat1_value',   'group' => 'about', 'type' => 'text',     'label' => 'Stat 1 Value',         'value' => '10+'],
            ['key' => 'about_stat1_label',   'group' => 'about', 'type' => 'text',     'label' => 'Stat 1 Label',         'value' => 'Years in Business'],
            ['key' => 'about_stat2_value',   'group' => 'about', 'type' => 'text',     'label' => 'Stat 2 Value',         'value' => '500+'],
            ['key' => 'about_stat2_label',   'group' => 'about', 'type' => 'text',     'label' => 'Stat 2 Label',         'value' => 'Deals Completed'],
            ['key' => 'about_stat3_value',   'group' => 'about', 'type' => 'text',     'label' => 'Stat 3 Value',         'value' => '1200+'],
            ['key' => 'about_stat3_label',   'group' => 'about', 'type' => 'text',     'label' => 'Stat 3 Label',         'value' => 'Happy Clients'],
            ['key' => 'about_stat4_value',   'group' => 'about', 'type' => 'text',     'label' => 'Stat 4 Value',         'value' => '50+'],
            ['key' => 'about_stat4_label',   'group' => 'about', 'type' => 'text',     'label' => 'Stat 4 Label',         'value' => 'Expert Agents'],
            ['key' => 'about_values_title',  'group' => 'about', 'type' => 'text',     'label' => 'Core Values Title',    'value' => 'Our Core Values'],
            ['key' => 'about_value1_icon',   'group' => 'about', 'type' => 'text',     'label' => 'Value 1 Icon',         'value' => 'bi-shield-check'],
            ['key' => 'about_value1_title',  'group' => 'about', 'type' => 'text',     'label' => 'Value 1 Title',        'value' => 'Integrity'],
            ['key' => 'about_value1_text',   'group' => 'about', 'type' => 'textarea', 'label' => 'Value 1 Text',         'value' => 'We never compromise on honesty. Every property listed is verified, every price is fair, and every transaction is transparent.'],
            ['key' => 'about_value2_icon',   'group' => 'about', 'type' => 'text',     'label' => 'Value 2 Icon',         'value' => 'bi-star'],
            ['key' => 'about_value2_title',  'group' => 'about', 'type' => 'text',     'label' => 'Value 2 Title',        'value' => 'Excellence'],
            ['key' => 'about_value2_text',   'group' => 'about', 'type' => 'textarea', 'label' => 'Value 2 Text',         'value' => 'We hold ourselves to the highest standard in every interaction — from the way we present properties to how we handle negotiations.'],
            ['key' => 'about_value3_icon',   'group' => 'about', 'type' => 'text',     'label' => 'Value 3 Icon',         'value' => 'bi-people-fill'],
            ['key' => 'about_value3_title',  'group' => 'about', 'type' => 'text',     'label' => 'Value 3 Title',        'value' => 'Client-First'],
            ['key' => 'about_value3_text',   'group' => 'about', 'type' => 'textarea', 'label' => 'Value 3 Text',         'value' => 'Your goals are our goals. We listen, understand your requirements deeply, and match you only with properties that truly fit.'],
            ['key' => 'about_value4_icon',   'group' => 'about', 'type' => 'text',     'label' => 'Value 4 Icon',         'value' => 'bi-lightbulb'],
            ['key' => 'about_value4_title',  'group' => 'about', 'type' => 'text',     'label' => 'Value 4 Title',        'value' => 'Innovation'],
            ['key' => 'about_value4_text',   'group' => 'about', 'type' => 'textarea', 'label' => 'Value 4 Text',         'value' => 'We continuously adopt new technologies and processes to make property search and purchase faster and more convenient.'],

            // ── Contact Page ───────────────────────────────────────────────
            ['key' => 'contact_hero_title',    'group' => 'contact', 'type' => 'text',     'label' => 'Hero Title',        'value' => 'Get In Touch'],
            ['key' => 'contact_hero_subtitle', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Hero Subtitle',     'value' => 'Our team is ready to help you find your perfect property.'],
            ['key' => 'contact_form_title',    'group' => 'contact', 'type' => 'text',     'label' => 'Form Section Title','value' => 'Send Us a Message'],
            ['key' => 'contact_info_title',    'group' => 'contact', 'type' => 'text',     'label' => 'Info Section Title','value' => 'Contact Information'],

            // ── SEO ─────────────────────────────────────────────────────────
            ['key' => 'seo_meta_description','group' => 'seo', 'type' => 'textarea', 'label' => 'Default Meta Description','value' => 'LandMark Realty — Find land, flats, houses and commercial properties for sale and rent across Bangladesh.'],
            ['key' => 'seo_meta_keywords',   'group' => 'seo', 'type' => 'text',     'label' => 'Default Meta Keywords',  'value' => 'land for sale Bangladesh, flat rent Dhaka, real estate Bangladesh'],
            ['key' => 'seo_google_analytics','group' => 'seo', 'type' => 'text',     'label' => 'Google Analytics ID',    'value' => ''],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(
                ['key' => $s['key']],
                ['group' => $s['group'], 'type' => $s['type'], 'label' => $s['label'], 'value' => $s['value']]
            );
        }
    }
}
