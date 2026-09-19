<?php

/**
 * 🏎️ MB MOTORS - Ultimate Executive Live MVC & Diagnostics Tool
 * Domain: mbmotors.ilyasmaidi.com
 * Year: 2026
 * 
 * تحذير أمني: يرجى تحديد كلمة مرور مخصصة بالأسفل أو حذف هذا الملف فور الانتهاء!
 */

// 1. نظام الحماية الذكي
define('ACCESS_PASSWORD', 'MB_MOTORS_2026'); // كلمة المرور الافتراضية للوصول الآمن

// 2. تفعيل معالجة الأخطاء
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 3. تهيئة بيئة عمل Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

session_start();

// التحقق من حالة تسجيل الدخول
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

// 4. معالجة العمليات البرمجية والأوامر
if ($isAuthenticated && isset($_GET['action'])) {
    $action = $_GET['action'];
    try {
        switch ($action) {
            // توليد الـ MVC بنقرة واحدة
            case 'generate_mvc':
                $modelName = trim($_POST['model_name'] ?? '');
                if (empty($modelName)) {
                    throw new \Exception("اسم الموديل مطلوب لتوليد البنية!");
                }
                
                // تطهير المدخلات لضمان أمان النظام
                $modelName = preg_replace('/[^a-zA-Z0-9_\/]/', '', $modelName);
                $modelName = Str::studly($modelName);
                
                $params = ['name' => $modelName];
                $flags = [];
                
                if (isset($_POST['opt_all'])) {
                    $params['--all'] = true;
                    $flags[] = 'Full Boilerplate (Model, Migration, Controller, Factory, Seeder, Policy, Form Requests)';
                } else {
                    if (isset($_POST['opt_migration'])) { $params['--migration'] = true; $flags[] = 'Migration'; }
                    if (isset($_POST['opt_factory'])) { $params['--factory'] = true; $flags[] = 'Factory'; }
                    if (isset($_POST['opt_seeder'])) { $params['--seeder'] = true; $flags[] = 'Seeder'; }
                    if (isset($_POST['opt_policy'])) { $params['--policy'] = true; $flags[] = 'Policy'; }
                    
                    if (isset($_POST['opt_controller'])) {
                        $params['--controller'] = true;
                        $flags[] = 'Controller';
                        if (isset($_POST['opt_resource'])) {
                            $params['--resource'] = true;
                            $flags[] = 'Resource Methods';
                        }
                        if (isset($_POST['opt_requests'])) {
                            $params['--requests'] = true;
                            $flags[] = 'Form Requests';
                        }
                    }
                }
                
                $action_title = "توليد بنية MVC للموديل: [{$modelName}]";
                Artisan::call('make:model', $params);
                $console_out .= Artisan::output();
                $console_out .= "\n✅ تم توليد الملفات المطلوبة بنجاح داخل نظام ملفات Laravel الخاص بك.\n";
                $status_type = "success";
                break;

            case 'storage_link':
                $action_title = "إعادة بناء رابط التخزين الرمزي (Storage Link)";
                $shortcut = public_path('storage');
                if (file_exists($shortcut)) {
                    if (is_link($shortcut)) {
                        unlink($shortcut);
                    } else {
                        File::deleteDirectory($shortcut);
                    }
                }
                Artisan::call('storage:link');
                $console_out .= Artisan::output() ?: "تم إنشاء الرابط الرمزي بنجاح للصور والملفات.";
                $status_type = "success";
                break;

            case 'migrate':
                $action_title = "تنفيذ الهجرات وترحيل قواعد البيانات (Migrate)";
                Artisan::call('migrate', ['--force' => true]);
                $console_out .= Artisan::output() ?: "تم فحص قاعدة البيانات، لا توجد جداول جديدة معلقة.";
                $status_type = "success";
                break;

            case 'migrate_rollback':
                $action_title = "التراجع عن الترحيل الأخير (Rollback)";
                Artisan::call('migrate:rollback', ['--force' => true]);
                $console_out .= Artisan::output();
                $status_type = "warning";
                break;

            case 'db_seed':
                $action_title = "حقن البيانات الأساسية والتجريبية (Database Seeding)";
                Artisan::call('db:seed', ['--force' => true]);
                $console_out .= Artisan::output();
                $status_type = "success";
                break;

            case 'clear_cache':
                $action_title = "مسح الكاش والملفات المؤقتة بشكل كامل";
                Artisan::call('optimize:clear');
                $console_out .= Artisan::output();
                $status_type = "success";
                break;

            case 'optimize':
                $action_title = "تفعيل الـ Cache الفائق لبيئة الإنتاج (Production Optimize)";
                Artisan::call('config:cache');
                Artisan::call('route:cache');
                Artisan::call('view:cache');
                $console_out .= "🚀 تم بنجاح كشبرة الإعدادات والموجّهات ومستندات العرض لضمان أقصى سرعة استجابة للموقع.";
                $status_type = "success";
                break;

            case 'fix_permissions':
                $action_title = "ضبط وإصلاح أذونات الملفات الحيوية";
                $paths = [
                    storage_path(),
                    storage_path('framework/cache'),
                    storage_path('framework/sessions'),
                    storage_path('framework/views'),
                    storage_path('logs'),
                    base_path('bootstrap/cache')
                ];
                foreach ($paths as $path) {
                    if (file_exists($path)) {
                        @chmod($path, 0775);
                        $console_out .= "🛡️ تم ضبط الصلاحية 0775 للمسار: " . str_replace(base_path(), '', $path) . "\n";
                    }
                }
                $console_out .= "\n✅ تم ضبط الصلاحيات بنجاح لتجنب أخطاء HTTP 500.";
                $status_type = "success";
                break;

            case 'run_custom':
                $custom_cmd = $_POST['custom_command'] ?? '';
                $action_title = "أمر مخصص منفذ: " . htmlspecialchars($custom_cmd);
                $banned = ['tinker', 'migrate:fresh', 'db:wipe'];
                $clean_cmd = explode(' ', trim($custom_cmd))[0];
                
                if (in_array($clean_cmd, $banned)) {
                    $console_out .= "🛑 تم حظر هذا الأمر لدواعي أمان البيانات الإستراتيجية للموقع.";
                    $status_type = "danger";
                } else {
                    Artisan::call($custom_cmd);
                    $console_out .= Artisan::output();
                    $status_type = "success";
                }
                break;
        }
    } catch (\Exception $e) {
        $console_out = "⚠️ حدث خطأ أثناء تنفيذ العملية:\n" . $e->getMessage();
        $status_type = "danger";
    }
}

// 5. جلب بيانات الفحص التشخيصي المباشر للوحة
$diagnostics = [
    'php_version' => PHP_VERSION,
    'env_exists' => file_exists(base_path('.env')),
    'app_key_set' => !empty(config('app.key')),
    'db_connection' => false,
    'db_name' => 'لا يوجد اتصال',
    'storage_writable' => is_writable(storage_path()),
    'bootstrap_cache_writable' => is_writable(base_path('bootstrap/cache')),
    'symlink_valid' => false
];

try {
    DB::connection()->getPdo();
    $diagnostics['db_connection'] = true;
    $diagnostics['db_name'] = DB::connection()->getDatabaseName();
} catch (\Exception $e) {
    $diagnostics['db_error'] = $e->getMessage();
}

$storage_link_path = public_path('storage');
if (file_exists($storage_link_path) && is_link($storage_link_path)) {
    $diagnostics['symlink_valid'] = true;
}

// جلب آخر 30 سطر من ملف الأخطاء لمراقبته بشكل لحظي
$laravel_logs = "سجل الأخطاء فارغ أو غير متوفر حالياً.";
$log_file_path = storage_path('logs/laravel.log');
if (file_exists($log_file_path)) {
    $file_content = file($log_file_path);
    $last_lines = array_slice($file_content, -30);
    $laravel_logs = implode("", $last_lines);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MB MOTORS | لوحة التطوير السريع وتهيئة النظام</title>
    <!-- استيراد واجهة التنسيق الأنيقة والحديثة -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --dark-bg: #0b0c10;
            --slate-card: #1f2833;
            --gold: #c18f54;
            --gold-hover: #a4753f;
            --text-primary: #f8f9fa;
            --text-secondary: #c5c6c7;
        }
        body {
            background-color: var(--dark-bg);
            color: var(--text-secondary);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #000000 0%, #1f2833 100%);
            border-bottom: 2px solid var(--gold);
        }
        .luxury-card {
            background-color: var(--slate-card);
            border: 1px solid rgba(193, 143, 84, 0.25);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .luxury-card:hover {
            border-color: var(--gold);
            box-shadow: 0 8px 24px rgba(193, 143, 84, 0.1);
        }
        .gold-title {
            color: var(--gold);
            font-weight: 700;
        }
        .terminal-box {
            background-color: #020202;
            color: #39ff14;
            font-family: 'Courier New', Courier, monospace;
            padding: 18px;
            border-radius: 10px;
            max-height: 380px;
            overflow-y: auto;
            white-space: pre-wrap;
            border: 1px solid #222;
            font-size: 0.9rem;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.8);
        }
        .btn-gold {
            background-color: var(--gold);
            color: #000;
            font-weight: 600;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-gold:hover {
            background-color: var(--gold-hover);
            color: #fff;
            transform: translateY(-1px);
        }
        .form-check-input:checked {
            background-color: var(--gold);
            border-color: var(--gold);
        }
        .modern-input {
            background-color: #0c1015 !important;
            border: 1px solid #3a4149;
            color: #fff !important;
        }
        .modern-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.25rem rgba(193, 143, 84, 0.25);
        }
        .log-container {
            background-color: #040404;
            color: #f8d7da;
            font-family: 'Courier New', monospace;
            font-size: 0.8rem;
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #842029;
            border-radius: 8px;
            padding: 12px;
        }
    </style>
</head>
<body>

<!-- شريط التنقل الرئيسي الفاخر -->
<nav class="navbar navbar-custom py-3 shadow-lg">
    <div class="container">
        <span class="navbar-brand m-0 h1 text-white">
            <i class="fa-solid fa-cube gold-title me-2"></i> MB MOTORS <span class="text-white-50">| Pro MVC & Live Workspace</span>
        </span>
        @if($isAuthenticated && ACCESS_PASSWORD !== '')
            <a href="?logout=true" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-power-off me-1"></i> خروج آمن</a>
        @endif
    </div>
</nav>

<div class="container my-5">

    <!-- نافذة تسجيل الدخول -->
    @if(!$isAuthenticated)
        <div class="row justify-content-center py-5">
            <div class="col-md-5">
                <div class="card luxury-card p-4 shadow-lg text-center">
                    <i class="fa-solid fa-shield-halved gold-title fs-1 mb-3"></i>
                    <h4 class="text-white mb-3">بوابة الصيانة الآمنة</h4>
                    <p class="text-white-50 small mb-4">هذه اللوحة تحتوي على واجهات لإدارة الهياكل والملفات مباشرة على الخادم.</p>
                    
                    @if(isset($login_error))
                        <div class="alert alert-danger py-2 small">{{ $login_error }}</div>
                    @endif

                    <form method="POST">
                        <input type="password" name="login_password" class="form-control text-center modern-input mb-3" placeholder="أدخل كلمة مرور التطبيق" required>
                        <button type="submit" class="btn btn-gold w-100 py-2">دخول لوحة التحكم</button>
                    </form>
                </div>
            </div>
        </div>
    @else

        <div class="row g-4">
            
            <!-- العمود الأيمن: نظام بناء الـ MVC الذكي ونقرة صيانة الخادم -->
            <div class="col-lg-8">
                
                <!-- لوحة بناء الـ MVC بنقرة واحدة (One-Click Pro MVC Generator) -->
                <div class="card luxury-card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-3 mb-4">
                        <h5 class="text-white mb-0">
                            <i class="fa-solid fa-circle-nodes gold-title me-2"></i> 
                            توليد بنية MVC المتكاملة بنقرة واحدة
                        </h5>
                        <span class="badge bg-black text-warning border border-warning px-3 py-1.5 small">
                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i> ذكاء اصطناعي مدمج
                        </span>
                    </div>

                    <form action="?action=generate_mvc" method="POST" id="mvcForm">
                        <div class="mb-4">
                            <label class="form-label text-white fw-bold">اسم الموديل (Model Name):</label>
                            <div class="input-group">
                                <span class="input-group-text bg-black border-secondary text-secondary">App\Models\</span>
                                <input type="text" name="model_name" class="form-control modern-input" placeholder="مثال: Car, Service, Booking, Article" required>
                            </div>
                            <div class="form-text text-muted small mt-1">سيتم تدوير الحروف تلقائياً لأسلوب الـ CamelCase (مثال: ClientPayment).</div>
                        </div>

                        <label class="form-label text-white fw-bold mb-2">الملحقات المطلوب توليدها مبرمجة تلقائياً:</label>
                        <div class="row g-3 mb-4">
                            <!-- خيار توليد الكل -->
                            <div class="col-12">
                                <div class="p-3 bg-black rounded-3 border border-secondary d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-warning mb-0 fw-bold">توليد الهيكل الكامل (Full Suite - `--all`)</h6>
                                        <p class="text-muted small mb-0">إنشاء الموديل، الترحيل، الكونترولر، الـ Factory، الـ Seeder، الـ Policy وبطاقات الفاليديشن.</p>
                                    </div>
                                    <div class="form-check form-switch fs-5">
                                        <input class="form-check-input" type="checkbox" name="opt_all" id="opt_all" onchange="toggleAllOptions(this)">
                                    </div>
                                </div>
                            </div>

                            <!-- الخيارات المخصصة والمنفردة -->
                            <div class="col-md-4 custom-opt">
                                <div class="form-check p-2 rounded bg-black-50 border border-secondary-subtle px-4">
                                    <input class="form-check-input" type="checkbox" name="opt_migration" id="opt_migration" checked>
                                    <label class="form-check-label text-white-50 small" for="opt_migration">
                                        قاعدة بيانات (Migration)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 custom-opt">
                                <div class="form-check p-2 rounded bg-black-50 border border-secondary-subtle px-4">
                                    <input class="form-check-input" type="checkbox" name="opt_controller" id="opt_controller" onchange="toggleControllerSubOpts(this)" checked>
                                    <label class="form-check-label text-white-50 small" for="opt_controller">
                                        متحكم (Controller)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 custom-opt">
                                <div class="form-check p-2 rounded bg-black-50 border border-secondary-subtle px-4">
                                    <input class="form-check-input" type="checkbox" name="opt_factory" id="opt_factory" checked>
                                    <label class="form-check-label text-white-50 small" for="opt_factory">
                                        بيانات وهمية (Factory)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 custom-opt">
                                <div class="form-check p-2 rounded bg-black-50 border border-secondary-subtle px-4">
                                    <input class="form-check-input" type="checkbox" name="opt_seeder" id="opt_seeder" checked>
                                    <label class="form-check-label text-white-50 small" for="opt_seeder">
                                        مغذي (Seeder)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 custom-opt">
                                <div class="form-check p-2 rounded bg-black-50 border border-secondary-subtle px-4">
                                    <input class="form-check-input" type="checkbox" name="opt_policy" id="opt_policy">
                                    <label class="form-check-label text-white-50 small" for="opt_policy">
                                        سياسة أمان (Policy)
                                    </label>
                                </div>
                            </div>
                            
                            <!-- تفاصيل متحكم الموارد -->
                            <div class="col-md-12 controller-sub-options">
                                <div class="p-3 bg-dark rounded border border-secondary-subtle d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="opt_resource" id="opt_resource" checked>
                                        <label class="form-check-label text-white-50 small" for="opt_resource">
                                            تحويل لمتحكم موارد (Resource Controller with CRUD)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="opt_requests" id="opt_requests">
                                        <label class="form-check-label text-white-50 small" for="opt_requests">
                                            توليد ملفات التحقق (Request Validation Classes)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-gold w-100 py-3" onclick="showLoader()">
                            <i class="fa-solid fa-code me-1"></i> توليد الملفات بنقرة واحدة (One-Click Generate)
                        </button>
                    </form>
                </div>

                <!-- مخرجات الـ Terminal للمكتبة التفاعلية -->
                @if(!empty($console_out))
                    <div class="card luxury-card p-4 mb-4">
                        <h6 class="text-white border-bottom border-secondary pb-2 mb-3">
                            <i class="fa-solid fa-terminal text-success me-2"></i> 
                            تغذية كونسول النظام الحالية: <span class="text-info">{{ $action_title }}</span>
                        </h6>
                        <div class="terminal-box">
                            {{ $console_out }}
                        </div>
                    </div>
                @endif

                <!-- لوحة أوامر Artisan وجسور صيانة المخزن والمشروع -->
                <div class="card luxury-card p-4">
                    <h5 class="text-white border-bottom border-secondary pb-3 mb-3"><i class="fa-solid fa-screwdriver-wrench gold-title me-2"></i> أدوات وجسور صيانة بيئة العمل المباشرة</h5>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <a href="?action=storage_link" class="btn btn-outline-light w-100 text-start py-2.5 small">
                                <i class="fa-solid fa-folder-open text-info me-1"></i> تحديث رابط الـ Storage
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="?action=migrate" class="btn btn-outline-light w-100 text-start py-2.5 small">
                                <i class="fa-solid fa-database text-warning me-1"></i> ترحيل قاعدة البيانات (Migrate)
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="?action=clear_cache" class="btn btn-outline-light w-100 text-start py-2.5 small">
                                <i class="fa-solid fa-broom text-danger me-1"></i> مسح شامل للكاش والمؤقتات
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="?action=optimize" class="btn btn-outline-light w-100 text-start py-2.5 small">
                                <i class="fa-solid fa-bolt text-success me-1"></i> تحسين وتكشيف بيئة الإنتاج
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="?action=db_seed" class="btn btn-outline-light w-100 text-start py-2.5 small text-primary">
                                <i class="fa-solid fa-seedling me-1"></i> حقن بيانات المغذيات اليدوية
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="?action=fix_permissions" class="btn btn-outline-light w-100 text-start py-2.5 small text-secondary">
                                <i class="fa-solid fa-key me-1"></i> إصلاح صلاحيات المجلدات (500)
                            </a>
                        </div>
                    </div>

                    <!-- إدخال أمر مخصص حر -->
                    <form method="POST" action="?action=run_custom" class="mt-4 pt-3 border-top border-secondary">
                        <div class="input-group">
                            <span class="input-group-text bg-black text-secondary border-secondary">php artisan</span>
                            <input type="text" name="custom_command" class="form-control modern-input" placeholder="مثال: config:clear, make:policy PostPolicy" required>
                            <button type="submit" class="btn btn-gold">نفذ الأمر</button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- العمود الأيسر: تشخيص سلامة النظام وسجل الأخطاء الفني -->
            <div class="col-lg-4">
                
                <!-- لوحة سلامة الخادم الفورية -->
                <div class="card luxury-card p-3 mb-4">
                    <h5 class="text-white border-bottom border-secondary pb-2 mb-3"><i class="fa-solid fa-gauge-high gold-title me-2"></i> فحص سلامة البيئة</h5>
                    <ul class="list-group list-group-flush bg-transparent">
                        <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center border-secondary py-2 small">
                            <span>نسخة بيئة PHP:</span>
                            <span class="badge bg-secondary">{{ $diagnostics['php_version'] }}</span>
                        </li>
                        <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center border-secondary py-2 small">
                            <span>ملف الـ <code>.env</code>:</span>
                            @if($diagnostics['env_exists'])
                                <span class="badge bg-success">متوفر ونشط</span>
                            @else
                                <span class="badge bg-danger">مفقود تماماً!</span>
                            @endif
                        </li>
                        <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center border-secondary py-2 small">
                            <span>اتصال قاعدة البيانات:</span>
                            @if($diagnostics['db_connection'])
                                <span class="badge bg-success">متصل: {{ $diagnostics['db_name'] }}</span>
                            @else
                                <span class="badge bg-danger">فشل في الاتصال!</span>
                            @endif
                        </li>
                        <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center border-secondary py-2 small">
                            <span>رابط مجلد الـ <code>storage</code>:</span>
                            @if($diagnostics['symlink_valid'])
                                <span class="badge bg-success">سليم ويعمل</span>
                            @else
                                <span class="badge bg-warning">معطل أو معزول</span>
                            @endif
                        </li>
                    </ul>
                </div>

                <!-- مسار سجل أخطاء لارافيل المباشر (Laravel Logs Stream) -->
                <div class="card luxury-card p-3">
                    <h5 class="text-white border-bottom border-secondary pb-2 mb-3"><i class="fa-solid fa-bug gold-title me-2"></i> سجل أخطاء لارافيل الأخير</h5>
                    <div class="log-container">
                        <pre class="m-0 text-wrap">{{ $laravel_logs }}</pre>
                    </div>
                </div>

            </div>

        </div>

    @endif
</div>

<footer class="bg-black text-center py-4 border-top border-secondary mt-5">
    <p class="mb-0 text-muted small">&copy; 2026 MB MOTORS Recovery & Professional Dev Tools. جميع الحقوق محفوظة.</p>
</footer>

<!-- أكواد تفاعلية للتحكم بالواجهة -->
<script>
function toggleAllOptions(checkbox) {
    const customOpts = document.querySelectorAll('.custom-opt input[type="checkbox"]');
    const controllerSubOpts = document.querySelector('.controller-sub-options');
    
    customOpts.forEach(opt => {
        opt.disabled = checkbox.checked;
    });
    
    if (checkbox.checked) {
        controllerSubOpts.style.opacity = '0.5';
        controllerSubOpts.querySelectorAll('input').forEach(i => i.disabled = true);
    } else {
        controllerSubOpts.style.opacity = '1';
        controllerSubOpts.querySelectorAll('input').forEach(i => i.disabled = false);
    }
}

function toggleControllerSubOpts(checkbox) {
    const subOpts = document.querySelector('.controller-sub-options');
    if (!checkbox.checked) {
        subOpts.style.opacity = '0.5';
        subOpts.querySelectorAll('input').forEach(i => i.disabled = true);
    } else {
        subOpts.style.opacity = '1';
        subOpts.querySelectorAll('input').forEach(i => i.disabled = false);
    }
}
</script>

</body>
</html>