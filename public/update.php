<?php

/**
 * 🏎️ MB MOTORS - Ultimate Unified Enterprise Ecosystem (Workspace, Admin & Showroom)
 * Location: Laghouat / Ghardaïa, Algeria
 * Year: 2026
 * 
 * هذا الملف هو الحل الشامل والنهائي لتوليد وهيكلة وعرض موقع السيارات بالكامل بنقرة زر واحدة.
 */

define('ACCESS_PASSWORD', 'MB_MOTORS_2026'); // كلمة المرور للتحكم الأمني

// تفعيل تقصي الأخطاء الشامل
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// تهيئة بيئة عمل Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

session_start();

// نظام التحقق من الهوية
if (ACCESS_PASSWORD !== '') {
    if (isset($_POST['login_password'])) {
        if ($_POST['login_password'] === ACCESS_PASSWORD) {
            $_SESSION['mb_authenticated'] = true;
        } else {
            $login_error = "كلمة المرور غير صحيحة!";
        }
    }
    if (isset($_GET['logout'])) {
        unset($_SESSION['mb_authenticated']);
        session_destroy();
        header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
        exit;
    }
    $isAuthenticated = isset($_SESSION['mb_authenticated']) && $_SESSION['mb_authenticated'] === true;
} else {
    $isAuthenticated = true;
}

$console_out = "";
$action_title = "";
$status_type = "info";
$alert_message = "";

// ---------------------------------------------------------
// محرك المعالجة الخلفية والأوامر الذكية (Background Engine)
// ---------------------------------------------------------
if ($isAuthenticated) {
    
    // 1. إعادة بناء قاعدة البيانات وحقن السيارات تلقائياً
    if (isset($_GET['action']) && $_GET['action'] === 'rebuild_all') {
        $action_title = "إعادة بناء بيئة العمل والملفات وقاعدة البيانات بالكامل";
        try {
            // أ) إنشاء أو تحديث جدول السيارات في قاعدة البيانات فوراً
            Schema::dropIfExists('cars');
            Schema::create('cars', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('brand');
                $table->integer('year');
                $table->double('price');
                $table->string('fuel_type'); // Petrol, Diesel, Hybrid, Electric
                $table->string('transmission'); // Automatic, Manual
                $table->string('image_url')->nullable();
                $table->text('description')->nullable();
                $table->boolean('is_featured')->default(false);
                $table->timestamps();
            });
            $console_out .= "⚡ [DB] تم إنشاء جدول السيارات `cars` بنجاح في قاعدة البيانات.\n";

            // ب) حقن سيارات تجريبية فائقة الفخامة لتبدأ العرض فوراً
            DB::table('cars')->insert([
                [
                    'title' => 'Porsche 911 GT3 RS',
                    'brand' => 'Porsche',
                    'year' => 2025,
                    'price' => 225000,
                    'fuel_type' => 'Petrol',
                    'transmission' => 'Automatic',
                    'image_url' => 'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?auto=format&fit=crop&w=800&q=80',
                    'description' => 'النسخة الأكثر رعباً وقوة للحلبات مع هندسة ديناميكية فائقة ومحرك تنفس طبيعي ساحر.',
                    'is_featured' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Mercedes-AMG G63 Black Edition',
                    'brand' => 'Mercedes',
                    'year' => 2026,
                    'price' => 185000,
                    'fuel_type' => 'Petrol',
                    'transmission' => 'Automatic',
                    'image_url' => 'https://images.unsplash.com/photo-1520050206274-a1ae446cb3cc?auto=format&fit=crop&w=800&q=80',
                    'description' => 'أيقونة الطرق الوعرة والقوة المطلقة، تجمع بين الفخامة الأرستقراطية والأداء الرياضي العالي.',
                    'is_featured' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Audi RS e-tron GT',
                    'brand' => 'Audi',
                    'year' => 2026,
                    'price' => 145000,
                    'fuel_type' => 'Electric',
                    'transmission' => 'Automatic',
                    'image_url' => 'https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&w=800&q=80',
                    'description' => 'المستقبل الكهربائي الرياضي الصامت من أودي بأداء خارق وتسارع مذهل وتوجيه ذكي.',
                    'is_featured' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
            $console_out .= "⚡ [DB] تم حقن السيارات التجريبية بنجاح داخل قاعدة البيانات.\n";

            // ج) كتابة كود الموديل Car.php تلقائياً في مجلد التطبيق
            $model_code = '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        \'title\',
        \'brand\',
        \'year\',
        \'price\',
        \'fuel_type\',
        \'transmission\',
        \'image_url\',
        \'description\',
        \'is_featured\'
    ];
}';
            File::ensureDirectoryExists(app_path('Models'));
            File::put(app_path('Models/Car.php'), $model_code);
            $console_out .= "📂 [MVC] تم إنشاء وتحديث ملف الموديل بنجاح في المسار: App/Models/Car.php\n";

            // د) كتابة كود المتحكم CarController.php تلقائياً
            $controller_code = '<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::orderBy(\'created_at\', \'desc\')->get();
        return response()->json($cars);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            \'title\' => \'required|string|max:255\',
            \'brand\' => \'required|string|max:255\',
            \'year\' => \'required|integer\',
            \'price\' => \'required|numeric\',
            \'fuel_type\' => \'required|string\',
            \'transmission\' => \'required|string\',
            \'image_url\' => \'nullable|url\',
            \'description\' => \'nullable|string\'
        ]);

        $car = Car::create($validated);
        return response()->json([\'message\' => \'Car uploaded successfully!\', \'car\' => $car], 201);
    }
}';
            File::ensureDirectoryExists(app_path('Http/Controllers'));
            File::put(app_path('Http/Controllers/CarController.php'), $controller_code);
            $console_out .= "📂 [MVC] تم إنشاء وتحديث ملف المتحكم بنجاح في المسار: App/Http/Controllers/CarController.php\n";
            
            $status_type = "success";
            $alert_message = "تمت إعادة بناء النظام بالكامل بنجاح وحقن البيانات النموذجية!";
        } catch (\Exception $e) {
            $console_out .= "❌ فشلت العملية: " . $e->getMessage();
            $status_type = "danger";
        }
    }

    // 2. معالجة نموذج رفع سيارة جديدة من قبل الآدمن
    if (isset($_POST['admin_upload_car'])) {
        try {
            DB::table('cars')->insert([
                'title' => htmlspecialchars($_POST['car_title']),
                'brand' => htmlspecialchars($_POST['car_brand']),
                'year' => intval($_POST['car_year']),
                'price' => floatval($_POST['car_price']),
                'fuel_type' => htmlspecialchars($_POST['car_fuel']),
                'transmission' => htmlspecialchars($_POST['car_transmission']),
                'image_url' => htmlspecialchars($_POST['car_image'] ?: 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80'),
                'description' => htmlspecialchars($_POST['car_desc']),
                'is_featured' => isset($_POST['car_featured']) ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $alert_message = "✅ تم رفع السيارة بنجاح وإضافتها لقاعدة البيانات ومودل العرض المباشر للعميل!";
            $status_type = "success";
        } catch (\Exception $e) {
            $alert_message = "❌ خطأ أثناء الرفع: " . $e->getMessage();
            $status_type = "danger";
        }
    }

    // 3. مسح كاش النظام لإظهار التعديلات فوراً
    if (isset($_GET['action']) && $_GET['action'] === 'clear_cache') {
        Artisan::call('optimize:clear');
        $console_out .= Artisan::output();
        $status_type = "success";
        $alert_message = "تم مسح جميع ذاكرات الكاش بنجاح لتحديث الموقع!";
    }
}

// جلب السيارات من قاعدة البيانات لعرضها للعميل والآدمن
$all_cars = [];
$db_connected = false;
try {
    DB::connection()->getPdo();
    $db_connected = true;
    if (Schema::hasTable('cars')) {
        $all_cars = DB::table('cars')->orderBy('id', 'desc')->get();
    }
} catch (\Exception $e) {
    $db_error = $e->getMessage();
}

// إحصائيات سريعة للوحة
$total_cars = count($all_cars);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MB MOTORS | المنظومة البرمجية الشاملة للسيارات</title>
    <!-- Tailwind CSS لجمالية التصميم العصري والسرعة -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        obsidian: '#0a0b0d',
                        slateCard: '#15181f',
                        gold: '#d4af37',
                        goldHover: '#f3e5ab'
                    }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0a0b0d;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d4af37;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-obsidian text-gray-200 font-sans antialiased custom-scrollbar">

    <!-- شريط التنقل العلوي الفاخر للعلامة التجارية -->
    <header class="border-b border-gold/20 bg-black/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-gold/10 rounded-xl border border-gold/30">
                    <i class="fa-solid fa-car-rear text-gold text-2xl animate-pulse"></i>
                </div>
                <div>
                    <h1 class="text-xl font-black tracking-widest text-white">MB <span class="text-gold">MOTORS</span></h1>
                    <p class="text-xs text-gray-400">نظام إدارة ومبيعات السيارات الفاخرة الموحد</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-xs px-3 py-1.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                    خادم نشط: mbmotors.ilyasmaidi.com
                </span>
                <?php if ($isAuthenticated): ?>
                    <a href="?logout=true" class="text-xs bg-red-600/20 hover:bg-red-600 text-red-300 hover:text-white px-4 py-2 rounded-lg border border-red-500/30 transition-all">
                        <i class="fa-solid fa-power-off"></i> خروج آمن
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- حالة تسجيل الدخول الأمنية -->
        <?php if (!$isAuthenticated): ?>
            <div class="max-w-md mx-auto my-12 p-8 bg-slateCard rounded-2xl border border-gold/20 shadow-2xl text-center">
                <div class="inline-flex p-4 bg-gold/10 rounded-full border border-gold/20 mb-4">
                    <i class="fa-solid fa-shield-halved text-gold text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">بوابة الصيانة والتحكم الآمنة</h3>
                <p class="text-sm text-gray-400 mb-6">يرجى تسجيل الدخول للوصول لأدوات توليد الـ MVC، قاعدة البيانات، ولوحة الإدارة لرفع السيارات.</p>
                
                <?php if (isset($login_error)): ?>
                    <div class="mb-4 p-3 bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg text-sm">
                        <?= $login_error ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <input type="password" name="login_password" class="w-full bg-black border border-gray-800 rounded-lg py-3 px-4 text-center text-white placeholder-gray-600 focus:outline-none focus:border-gold mb-4" placeholder="أدخل كلمة مرور المسؤول" required>
                    <button type="submit" class="w-full bg-gold hover:bg-gold/80 text-black font-bold py-3 px-6 rounded-lg transition-all">
                        فتح المنظومة الكاملة
                    </button>
                </form>
            </div>
        <?php else: ?>

            <!-- إشعارات وتنبيهات النظام المباشرة -->
            <?php if (!empty($alert_message)): ?>
                <div class="mb-6 p-4 rounded-xl flex items-center gap-3 border <?= $status_type === 'success' ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400' : 'bg-red-500/10 border-red-500/30 text-red-400' ?>">
                    <i class="fa-solid <?= $status_type === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation' ?> text-lg"></i>
                    <p class="font-medium text-sm"><?= $alert_message ?></p>
                </div>
            <?php endif; ?>

            <!-- لوحة التحكم بالأقسام الرئيسية الثلاثة -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="p-4 bg-slateCard border border-gold/10 rounded-xl flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400">إجمالي السيارات المرفوعة</p>
                        <h4 class="text-3xl font-black text-white mt-1"><?= $total_cars ?> سيارات</h4>
                    </div>
                    <div class="p-3 bg-gold/10 rounded-lg text-gold text-2xl">
                        <i class="fa-solid fa-car"></i>
                    </div>
                </div>

                <div class="p-4 bg-slateCard border border-gold/10 rounded-xl flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400">اتصال قاعدة البيانات</p>
                        <h4 class="text-lg font-bold <?= $db_connected ? 'text-emerald-400' : 'text-red-400' ?> mt-1">
                            <?= $db_connected ? 'متصل ومستقر' : 'غير متصل!' ?>
                        </h4>
                    </div>
                    <div class="p-3 bg-emerald-500/10 rounded-lg text-emerald-400 text-2xl">
                        <i class="fa-solid fa-database"></i>
                    </div>
                </div>

                <div class="p-4 bg-slateCard border border-gold/10 rounded-xl flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400">الموديل الفعال حالياً</p>
                        <h4 class="text-lg font-mono text-white mt-1">App\Models\Car</h4>
                    </div>
                    <div class="p-3 bg-blue-500/10 rounded-lg text-blue-400 text-2xl">
                        <i class="fa-solid fa-code"></i>
                    </div>
                </div>
            </div>

            <!-- أزرار الاختصارات السريعة وتحديث الخادم بنقرة واحدة -->
            <div class="bg-gradient-to-r from-slateCard to-black border border-gold/20 p-6 rounded-2xl mb-8 flex flex-col md:flex-row justify-between items-center gap-6 shadow-xl">
                <div>
                    <h3 class="text-lg font-bold text-white mb-1"><i class="fa-solid fa-arrows-rotate text-gold mr-2"></i> زر التهيئة الخارقة وإعادة البناء</h3>
                    <p class="text-xs text-gray-400">سيقوم بمسح الجداول التالفة، إنشاء جدول السيارات، وحقن البيانات النموذجية وبناء ملفات MVC فوراً.</p>
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <a href="?action=rebuild_all" class="w-full md:w-auto bg-gradient-to-r from-gold to-yellow-500 text-black font-black px-6 py-3.5 rounded-xl text-center hover:opacity-90 transition-all flex items-center justify-center gap-2 shadow-lg shadow-gold/15">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> إعادة بناء قاعدة البيانات والـ MVC بنقرة واحدة
                    </a>
                    <a href="?action=clear_cache" class="bg-gray-800 hover:bg-gray-700 text-white font-bold px-5 py-3.5 rounded-xl text-center transition-all flex items-center justify-center gap-2" title="تنظيف الذاكرة المؤقتة للإنتاج">
                        <i class="fa-solid fa-broom text-red-400"></i> مسح كاش الخادم
                    </a>
                </div>
            </div>

            <!-- تقسيم واجهة العمل: اليسار (لوحة المطور والأدمن) | اليمين (معرض العميل والرفع المباشر) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- عمود الآدمن وتوليد ورفع السيارات (5 من 12) -->
                <div class="lg:col-span-5 space-y-8">
                    
                    <!-- واجهة الآدمن: رفع سيارة جديدة وقبول البيانات -->
                    <div class="bg-slateCard border border-gold/10 p-6 rounded-2xl shadow-lg">
                        <div class="flex items-center gap-2 border-b border-gray-800 pb-4 mb-4">
                            <i class="fa-solid fa-circle-plus text-gold text-lg"></i>
                            <h3 class="text-lg font-bold text-white">لوحة المسؤول | رفع سيارة جديدة للموقع</h3>
                        </div>
                        
                        <?php if (!$db_connected || !Schema::hasTable('cars')): ?>
                            <div class="p-4 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-xl text-xs text-center">
                                <i class="fa-solid fa-triangle-exclamation mb-2 text-xl"></i>
                                <p>يجب الضغط على زر "إعادة بناء قاعدة البيانات والـ MVC" أولاً لإنشاء الجداول في الخادم!</p>
                            </div>
                        <?php else: ?>
                            <form method="POST" class="space-y-4">
                                <input type="hidden" name="admin_upload_car" value="1">
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">ماركة السيارة (Brand):</label>
                                        <input type="text" name="car_brand" class="w-full bg-black border border-gray-800 rounded-lg py-2 px-3 text-white focus:outline-none focus:border-gold text-sm" placeholder="مثال: Porsche" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">اسم الموديل (Model/Title):</label>
                                        <input type="text" name="car_title" class="w-full bg-black border border-gray-800 rounded-lg py-2 px-3 text-white focus:outline-none focus:border-gold text-sm" placeholder="مثال: Cayman GT4" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">السعر ($ دولار):</label>
                                        <input type="number" name="car_price" class="w-full bg-black border border-gray-800 rounded-lg py-2 px-3 text-white focus:outline-none focus:border-gold text-sm" placeholder="120000" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">سنة الصنع (Year):</label>
                                        <input type="number" name="car_year" class="w-full bg-black border border-gray-800 rounded-lg py-2 px-3 text-white focus:outline-none focus:border-gold text-sm" value="2026" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">نوع ناقل الحركة:</label>
                                        <select name="car_transmission" class="w-full bg-black border border-gray-800 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:border-gold text-sm">
                                            <option value="Automatic">أوتوماتيك (Automatic)</option>
                                            <option value="Manual">يدوي (Manual)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">نوع المحرك/الوقود:</label>
                                        <select name="car_fuel" class="w-full bg-black border border-gray-800 rounded-lg py-2.5 px-3 text-white focus:outline-none focus:border-gold text-sm">
                                            <option value="Petrol">بنزين (Petrol)</option>
                                            <option value="Electric">كهربائي بالكامل (Electric)</option>
                                            <option value="Hybrid">هجين (Hybrid)</option>
                                            <option value="Diesel">ديزل (Diesel)</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">رابط صورة السيارة (Image URL):</label>
                                    <input type="url" name="car_image" class="w-full bg-black border border-gray-800 rounded-lg py-2 px-3 text-white focus:outline-none focus:border-gold text-sm" placeholder="https://images.unsplash.com/...">
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">وصف موجز للمواصفات والجماليات:</label>
                                    <textarea name="car_desc" rows="3" class="w-full bg-black border border-gray-800 rounded-lg py-2 px-3 text-white focus:outline-none focus:border-gold text-sm" placeholder="اكتب تفاصيل المحرك، السرعة القصوى، وحالة السيارة..."></textarea>
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="car_featured" id="car_featured" class="rounded bg-black border-gray-800 text-gold focus:ring-0">
                                    <label for="car_featured" class="text-xs text-gray-300">عرض كسيارة مميزة وحصرية بمقدمة العرض</label>
                                </div>

                                <button type="submit" class="w-full bg-white hover:bg-gold hover:text-black text-black font-bold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> رفع ونشر السيارة في الحال للجمهور
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <!-- شاشة كونسول المخرجات والتحقق الخلفي للتنفيذ -->
                    <?php if (!empty($console_out)): ?>
                        <div class="bg-black border border-emerald-500/30 p-5 rounded-2xl shadow-inner">
                            <div class="flex items-center gap-2 border-b border-gray-900 pb-3 mb-3 justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                                    <h4 class="text-sm font-mono text-emerald-400 font-bold">Terminal Output Monitor</h4>
                                </div>
                                <span class="text-xs text-gray-600 font-mono"><?= $action_title ?></span>
                            </div>
                            <pre class="text-xs font-mono text-emerald-400 overflow-x-auto whitespace-pre-wrap leading-relaxed custom-scrollbar max-height-[250px]"><?= $console_out ?></pre>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- عمود العرض والعملاء والواجهة الجمالية للموقع (7 من 12) -->
                <div class="lg:col-span-7 space-y-8">
                    
                    <!-- ترويسة معرض السيارات الفاخر للعملاء -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-black text-white tracking-wider"><i class="fa-solid fa-compass text-gold mr-1"></i> معرض السيارات المتوفر للعملاء</h2>
                            <p class="text-xs text-gray-400">تصفح مركبتك الرياضية أو الكهربائية القادمة من MB MOTORS</p>
                        </div>
                        <span class="text-xs bg-slateCard px-3 py-1.5 rounded-lg border border-gold/10 text-gold">
                            <i class="fa-solid fa-eye mr-1"></i> وضع المعاينة العامة للعميل
                        </span>
                    </div>

                    <?php if (empty($all_cars)): ?>
                        <!-- في حال عدم وجود سيارات بعد -->
                        <div class="bg-slateCard border border-dashed border-gray-800 p-12 rounded-2xl text-center">
                            <i class="fa-solid fa-car-side text-gray-600 text-5xl mb-4"></i>
                            <h4 class="text-lg font-bold text-white mb-1">المعرض فارغ حالياً</h4>
                            <p class="text-sm text-gray-500 mb-6">لم يتم تفعيل قاعدة البيانات وحقن السيارات أو رفعها بعد.</p>
                            <a href="?action=rebuild_all" class="inline-block bg-gold hover:bg-gold/80 text-black font-bold px-6 py-2.5 rounded-xl transition-all text-sm">
                                حقن وتوليد السيارات تلقائياً الآن
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- شبكة عرض سيارات العملاء الفاخرة -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php foreach ($all_cars as $car): ?>
                                <div class="bg-slateCard rounded-2xl overflow-hidden border border-gray-800/80 hover:border-gold/30 transition-all flex flex-col justify-between group shadow-lg">
                                    <div class="relative overflow-hidden aspect-video bg-black">
                                        <img src="<?= $car->image_url ?>" alt="<?= $car->title ?>" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500">
                                        <?php if ($car->is_featured): ?>
                                            <span class="absolute top-3 right-3 bg-gold text-black text-[10px] font-black uppercase px-2 py-1 rounded">
                                                حصرية ومميزة
                                            </span>
                                        <?php endif; ?>
                                        <div class="absolute bottom-3 left-3 bg-black/80 backdrop-blur px-2.5 py-1 rounded-lg text-gold font-mono text-xs font-bold border border-gold/10">
                                            $<?= number_format($car->price) ?>
                                        </div>
                                    </div>
                                    
                                    <div class="p-5 flex-1 flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-xs text-gold font-bold uppercase tracking-widest"><?= $car->brand ?></span>
                                                <span class="text-xs text-gray-500 font-mono font-medium"><?= $car->year ?></span>
                                            </div>
                                            <h4 class="text-lg font-bold text-white mb-2 group-hover:text-gold transition-colors"><?= $car->title ?></h4>
                                            <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed mb-4"><?= $car->description ?></p>
                                        </div>

                                        <div class="border-t border-gray-800/60 pt-4 flex items-center justify-between gap-2">
                                            <div class="flex gap-3 text-[11px] text-gray-400 font-medium">
                                                <span><i class="fa-solid fa-gas-pump text-gold/80 me-1"></i> <?= $car->fuel_type ?></span>
                                                <span><i class="fa-solid fa-gauge-high text-gold/80 me-1"></i> <?= $car->transmission ?></span>
                                            </div>
                                            <button onclick="alert('🌟 تم تفعيل نظام الحجز عبر الواقع الافتراضي (VR Preview) بنجاح لموقع Hello Languages و MB MOTORS! سيتم فتح الواجهة ثلاثية الأبعاد قريباً.')" class="text-[11px] font-bold bg-gold/10 hover:bg-gold text-gold hover:text-black border border-gold/30 px-3 py-1.5 rounded-lg transition-all flex items-center gap-1">
                                                <i class="fa-solid fa-vr-cardboard"></i> حجز معاينة VR
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

        <?php endif; ?>
    </main>

    <!-- تذييل المنظومة البرمجية الفخم -->
    <footer class="border-t border-gray-900 bg-black py-8 mt-16 text-center text-xs text-gray-500">
        <div class="max-w-7xl mx-auto px-4">
            <p class="mb-2">هذه المنظومة مخصصة لتجربة البيئة المشتركة وعرض وإصلاح قواعد بيانات وتطوير MVC لمشروع السيارات MB MOTORS.</p>
            <p>&copy; 2026 MB MOTORS Security, Workspace & Production-Ready Catalog. جميع الحقوق محفوظة لجامعة الأغواط وحاضنة الأعمال.</p>
        </div>
    </footer>

</body>
</html>