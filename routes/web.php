<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdController, CategoryController, StoreController,
    DashboardController, MessageController, FavoriteController,
    NotificationController, SearchController, ProfileController,
    StoreSetupController, VendorDashboardController, CartController,
    OrderController, CheckoutController
};
use App\Livewire\{Home, AdListing};
use App\Livewire\Admin\Orders\OrderIndex;
use App\Livewire\Admin\Orders\OrderShow;

/*
|--------------------------------------------------------------------------
| 1. المسارات العامة الثابتة (Public Static Routes)
|--------------------------------------------------------------------------
*/
Route::get('/', Home::class)->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{slug}', [StoreController::class, 'show'])->name('stores.show');

Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
Route::get('/category/{slug}', AdListing::class)->name('ads.by-category');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');



Route::get('/clear-cache', function() {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return "Cache cleared successfully!";
});


/*
|--------------------------------------------------------------------------
| 2. مسارات الأعضاء المسجلين (Authenticated Routes)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- التوجيه الذكي للمستخدم والتاجر والمسؤول ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- نظام المشتري والطلبات الشخصية ---
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/store', [CheckoutController::class, 'store'])->name('store');
        Route::get('/success', [CheckoutController::class, 'success'])->name('success');
    });
    
    Route::get('/my-orders', [CheckoutController::class, 'myOrders'])->name('orders.index');

    // --- إدارة الإعلانات ولوحة التاجر الشخصية ---
    Route::get('/my-ads', [AdController::class, 'myAds'])->name('my-ads');
    
    // يولد تلقائياً مسار ads/create بأمان تام هنا
    Route::resource('ads', AdController::class)->except(['index', 'show']);

    // --- نظام الرسائل والمحادثات الفورية ---
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/conversation', [MessageController::class, 'show'])->name('show');
        Route::post('/', [MessageController::class, 'store'])->name('store');
    });

    // --- نظام المفضلة والتنبيهات ---
    Route::resource('favorites', FavoriteController::class)->only(['index', 'store', 'destroy']);

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/read-all', [NotificationController::class, 'markAllRead'])->name('read-all');
    });

    // --- الملف الشخصي للبائع والمشتري ---
    // --- الملف الشخصي للبائع والمشتري ---
   // --- الملف الشخصي للبائع والمشتري ---
    // --- الملف الشخصي للبائع والمشتري ---
    Route::prefix('profile')->group(function () {
        // المسار الأساسي بالاسم الجديد
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show'); 
        
        // مسار بديل (Alias) بنفس الدالة لحماية وسلامة الملفات المنسية القديمة
        Route::get('/view', [ProfileController::class, 'show'])->name('profile'); 
        
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    });

    // --- إعداد المتجر والوكالة (Store Setup) ---
    Route::prefix('store-setup')->group(function () {
        Route::get('/', [StoreSetupController::class, 'index'])->name('store.setup');
        Route::post('/basic', [StoreSetupController::class, 'storeBasic'])->name('store.setup.basic');
        Route::post('/branding', [StoreSetupController::class, 'storeBranding'])->name('store.setup.branding');
        Route::post('/contact', [StoreSetupController::class, 'storeContact'])->name('store.setup.contact');
    });

    // --- لوحة تحكم التاجر المعززة (Vendor Dashboard) ---
    Route::prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [VendorDashboardController::class, 'analytics'])->name('analytics');
        Route::get('/store/settings', [VendorDashboardController::class, 'storeSettings'])->name('store.settings');
        Route::get('/orders', [CheckoutController::class, 'vendorOrders'])->name('orders.index');
        Route::patch('/orders/{order}', [CheckoutController::class, 'updateStatus'])->name('orders.update');
    });

    // --- لوحة تحكم الإدارة العليا (Admin Management) ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', OrderIndex::class)->name('index');
            Route::get('/{order}', OrderShow::class)->name('show'); 
        });
    });
});

/*
|--------------------------------------------------------------------------
| 3. صفحات المعلومات (Static Pages)
|--------------------------------------------------------------------------
*/
Route::view('/help', 'pages.help')->name('help');
Route::view('/safety', 'pages.safety')->name('safety');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');

/*
|--------------------------------------------------------------------------
| 4. المسارات الديناميكية العامة (توضع في نهاية الملف منعاً للـ Hijacking)
|--------------------------------------------------------------------------
*/
Route::get('/ads/{slug}/preview', [AdController::class, 'preview'])->name('ads.preview');
Route::get('/ads/{slug}', [AdController::class, 'show'])->name('ads.show');

require __DIR__.'/auth.php';