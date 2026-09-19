<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'OuedKniss Clone', 'group' => 'general', 'type' => 'text', 'description' => 'اسم الموقع'],
            ['key' => 'site_logo', 'value' => null, 'group' => 'general', 'type' => 'image', 'description' => 'شعار الموقع'],
            ['key' => 'site_favicon', 'value' => null, 'group' => 'general', 'type' => 'image', 'description' => 'أيقونة الموقع'],

            // UI Settings
            ['key' => 'primary_color', 'value' => '#ef4444', 'group' => 'ui', 'type' => 'color', 'description' => 'اللون الأساسي'],
            ['key' => 'secondary_color', 'value' => '#3b82f6', 'group' => 'ui', 'type' => 'color', 'description' => 'اللون الثانوي'],
            ['key' => 'hero_title', 'value' => 'ابحث عن ما تحتاجه', 'group' => 'ui', 'type' => 'text', 'description' => 'عنوان الصفحة الرئيسية'],
            ['key' => 'hero_subtitle', 'value' => 'آلاف الإعلانات بانتظارك في جميع المجالات', 'group' => 'ui', 'type' => 'text', 'description' => 'عنوان فرعي'],
            ['key' => 'hero_image', 'value' => null, 'group' => 'ui', 'type' => 'image', 'description' => 'صورة الخلفية'],

            // Section Settings
            ['key' => 'show_featured_section', 'value' => '1', 'group' => 'sections', 'type' => 'boolean', 'description' => 'إظهار قسم الإعلانات المميزة'],
            ['key' => 'show_popular_categories', 'value' => '1', 'group' => 'sections', 'type' => 'boolean', 'description' => 'إظهار الفئات الشائعة'],
            ['key' => 'show_recent_ads', 'value' => '1', 'group' => 'sections', 'type' => 'boolean', 'description' => 'إظهار أحدث الإعلانات'],

            // Contact Settings
            ['key' => 'contact_email', 'value' => 'contact@ouedkniss.clone', 'group' => 'contact', 'type' => 'text', 'description' => 'بريد التواصل'],
            ['key' => 'contact_phone', 'value' => '+213000000000', 'group' => 'contact', 'type' => 'text', 'description' => 'هاتف التواصل'],
            ['key' => 'footer_text', 'value' => '© 2024 OuedKniss Clone. جميع الحقوق محفوظة.', 'group' => 'contact', 'type' => 'textarea', 'description' => 'نص الفوتر'],

            // Social Settings
            ['key' => 'social_facebook', 'value' => null, 'group' => 'social', 'type' => 'text', 'description' => 'فيسبوك'],
            ['key' => 'social_instagram', 'value' => null, 'group' => 'social', 'type' => 'text', 'description' => 'انستغرام'],
            ['key' => 'social_twitter', 'value' => null, 'group' => 'social', 'type' => 'text', 'description' => 'تويتر'],

            // Ad Settings
            ['key' => 'max_ads_per_user', 'value' => '30', 'group' => 'ads', 'type' => 'number', 'description' => 'الحد الأقصى للإعلانات لكل مستخدم'],
            ['key' => 'ad_expiry_days', 'value' => '30', 'group' => 'ads', 'type' => 'number', 'description' => 'مدة صلاحية الإعلان بالأيام'],
            ['key' => 'featured_ads_limit', 'value' => '30', 'group' => 'ads', 'type' => 'number', 'description' => 'الحد الأقصى للإعلانات المميزة في الصدر'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        $this->command->info('Settings created successfully!');
    }
}
