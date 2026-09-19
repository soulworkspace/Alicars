<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. تعطيل التحقق من القيود (Foreign Key Checks) لمسح الجدول بأمان
        Schema::disableForeignKeyConstraints();
        Category::truncate(); // مسح كل البيانات القديمة تماماً
        Schema::enableForeignKeyConstraints();

        $categories = [
            [
                'name' => 'سيارات رياضية متعددة الاستخدامات (SUV)',
                'slug' => 'suv',
                'type' => 'general',
                'icon' => 'heroicon-o-truck', // يمكنك تغيير الأيقونات حسب مكتبتك
                'children' => [
                    ['name' => 'كروس أوفر مدمجة', 'slug' => 'compact-crossover', 'type' => 'general'],
                    ['name' => 'SUV عائلية 7 مقاعد', 'slug' => 'family-suv-7-seats', 'type' => 'general'],
                    ['name' => 'SUV فاخرة', 'slug' => 'luxury-suv', 'type' => 'general'],
                ],
            ],
            [
                'name' => 'سيارات سيدان وهاتشباك',
                'slug' => 'sedan-hatchback',
                'type' => 'general',
                'icon' => 'heroicon-o-key',
                'children' => [
                    ['name' => 'سيدان اقتصادية', 'slug' => 'economy-sedan', 'type' => 'general'],
                    ['name' => 'سيدان فاخرة / رياضية', 'slug' => 'luxury-sedan', 'type' => 'general'],
                    ['name' => 'هاتشباك شبابية', 'slug' => 'hatchback', 'type' => 'general'],
                ],
            ],
            [
                'name' => 'سيارات الطاقة الجديدة (NEV)',
                'slug' => 'electric-hybrid',
                'type' => 'general',
                'icon' => 'heroicon-o-bolt',
                'children' => [
                    ['name' => 'كهربائية بالكامل (BEV)', 'slug' => 'full-electric', 'type' => 'general'],
                    ['name' => 'هجينة قابلة للشحن (PHEV)', 'slug' => 'plug-in-hybrid', 'type' => 'general'],
                ],
            ],
            [
                'name' => 'سيارات تجارية ونقل',
                'slug' => 'commercial-vehicles',
                'type' => 'general',
                'icon' => 'heroicon-o-shield-check',
                'children' => [
                    ['name' => 'بيك أب (شاحنات خفيفة)', 'slug' => 'pickup-trucks', 'type' => 'general'],
                    ['name' => 'فان نقل بضائع / ركاب', 'slug' => 'cargo-vans', 'type' => 'general'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            // فصل الأبناء عن البيانات الأساسية للأب
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            // إنشاء القسم الرئيسي (Parent)
            $parent = Category::create($categoryData);

            // إنشاء الأقسام الفرعية (Children) وربطها بالـ parent_id
            foreach ($children as $childData) {
                $childData['parent_id'] = $parent->id;
                Category::create($childData);
            }
        }

        $this->command->info('✅ CHINESE CARS Categories: Seeding completed successfully!');
    }
}