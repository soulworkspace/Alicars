<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إعادة تعيين الكاش الخاص بالصلاحيات (ضروري جداً قبل البدء)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. تعريف الصلاحيات
        $permissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view stores', 'create stores', 'edit stores', 'delete stores',
            'view ads', 'create ads', 'edit ads', 'delete ads', 'approve ads',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view settings', 'edit settings',
            'manage staff', 'view staff',
            'view statistics',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 3. إنشاء الرتب (Roles)
        // ملاحظة: تأكد أن الأسماء تطابق الـ ENUM في migration المستخدمين
        $adminRole  = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $vendorRole = Role::firstOrCreate(['name' => 'vendor', 'guard_name' => 'web']);
        $staffRole  = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $buyerRole  = Role::firstOrCreate(['name' => 'buyer', 'guard_name' => 'web']);

        // تعيين الصلاحيات للرتب
        $adminRole->syncPermissions(Permission::all());

        $vendorRole->syncPermissions([
            'view stores', 'create stores', 'edit stores',
            'view ads', 'create ads', 'edit ads', 'delete ads',
            'view categories', 'manage staff', 'view staff', 'view statistics',
        ]);

        $staffRole->syncPermissions(['view ads', 'create ads', 'edit ads', 'view stores']);
        
        $buyerRole->syncPermissions(['view ads']);

        // 4. إنشاء المستخدمين الافتراضيين (البيانات الأساسية للنظام)
        
        // حساب المدير العام (Admin)
        $admin = User::updateOrCreate(
            ['phone' => '0550112233'], // البحث برقم الهاتف كونه الفريد الأساسي
            [
                'name'      => 'Admin Ilias',
                'email'     => 'admin@trico.dz',
                'password'  => Hash::make('password'),
                'role'      => 'admin', // للحقل العادي في جدول users
                'is_active' => true,
            ]
        );
        $admin->assignRole('admin');

        // حساب بائع تجريبي (Vendor)
        $vendor = User::updateOrCreate(
            ['phone' => '0660112233'],
            [
                'name'      => 'Oasis Vendor',
                'email'     => 'vendor@trico.dz',
                'password'  => Hash::make('password'),
                'role'      => 'vendor',
                'is_active' => true,
            ]
        );
        $vendor->assignRole('vendor');

        // حساب مشتري تجريبي (Buyer)
        $buyer = User::updateOrCreate(
            ['phone' => '0770112233'],
            [
                'name'      => 'Test Buyer',
                'email'     => 'buyer@trico.dz',
                'password'  => Hash::make('password'),
                'role'      => 'buyer',
                'is_active' => true,
            ]
        );
        $buyer->assignRole('buyer');

        $this->command->info('✅ TRICO System: Roles & Permissions Loaded Successfully!');
    }
}