<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class AdController extends Controller
{
    /**
     * عرض المتجر العالمي (دمج الحقيقي والوهمي)
     */
    public function index(Request $request)
{
    // جلب الإعلانات النشطة مع العلاقات (Category) لتحسين الأداء (Eager Loading)
    $ads = Ad::with('category')
        ->where('status', 'active') // عرض الإعلانات النشطة فقط
        ->latest() // الأحدث أولاً
        ->paginate(12); // تقسيم الصفحات (Pagination)

    return view('ads.index', compact('ads'));
}

    /**
     * صفحة إنشاء إعلان جديد
     */
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // التحقق من صلاحية المستخدم للنشر (الحد الأقصى 30 كما في المودل)
        if (!$user->canCreateMoreAds()) {
            return redirect()->route('ads.index')
                ->with('error', 'لقد وصلت للحد الأقصى من الإعلانات المسموح بها (30 إعلاناً).');
        }

        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('ads.create', compact('categories'));
    }

    /**
     * حفظ الإعلان في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'required|in:fixed,negotiable,free',
            'condition' => 'required|in:new,used,refurbished',
            'location' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_whatsapp' => 'nullable|string|max:20',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $ad = Ad::create([
            ...$validated,
            'slug' => Str::slug($validated['title']),
            'user_id' => Auth::id(),
            'store_id' => $user->store?->id,
            'status' => 'pending', // يحتاج مراجعة الإدارة أولاً
            'template' => $this->getTemplateForCategory($request->category_id),
        ]);

        // معالجة الصور المرفوعة
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('ads/' . $ad->id, 'public');
                $ad->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('ads.show', $ad->slug)
            ->with('success', 'تم نشر إعلانك بنجاح! سيظهر للجميع بعد مراجعة الإدارة.');
    }

    /**
     * عرض تفاصيل منتج معين
     */
    public function show($slug)
    {
        $ad = Ad::where('slug', $slug)
            ->with(['user', 'store', 'category', 'images', 'attributes'])
            ->firstOrFail();

        $ad->incrementViews();

        return view('ads.show', compact('ad'));
    }

    /**
     * تعديل إعلان موجود
     */
    public function edit(Ad $ad)
    {
        $this->authorize('update', $ad);
        $categories = Category::active()->root()->with('children')->get();
        return view('ads.edit', compact('ad', 'categories'));
    }

    /**
     * تحديث البيانات في قاعدة البيانات
     */
    public function update(Request $request, Ad $ad)
{
    // 1. التحقق من الصلاحية (Security Check)
    // نضمن أن البائع الحالي هو فقط من يمكنه تعديل إعلانه
    if (auth()->id() !== $ad->user_id) {
        return redirect()->route('my-ads')->with('error', 'غير مسموح لك بتعديل هذا الإعلان.');
    }

    // 2. التحقق من البيانات المدخلة (Validation)
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|min:10',
        'price' => 'nullable|numeric|min:0',
        'city' => 'nullable|string|max:100',
        'condition' => 'required|in:new,used',
        'contact_phone' => 'nullable|string|max:20',
        'is_negotiable' => 'nullable', // سنتعامل معه كـ boolean بالأسفل
    ]);

    // 3. معالجة الـ Checkbox (لأن الـ checkbox لا يرسل قيمة إذا لم يتم تحديده)
    $validated['is_negotiable'] = $request->has('is_negotiable');

    // 4. تنفيذ التحديث في قاعدة البيانات
    try {
        $ad->update($validated);
        
        // إذا نجح التحديث، نعود لصفحة التعديل مع رسالة نجاح
        return redirect()->route('ads.edit', $ad->id)->with('success', 'تم تحديث بيانات الإعلان بنجاح ✨');
    } catch (\Exception $e) {
        // في حال حدوث خطأ تقني غير متوقع
        return back()->with('error', 'حدث خطأ أثناء التحديث، يرجى المحاولة لاحقاً.');
    }
}

    /**
     * حذف الإعلان
     */
    public function destroy(Ad $ad)
    {
        $this->authorize('delete', $ad);
        $ad->delete();

        return redirect()->route('my-ads')
            ->with('success', 'تم حذف الإعلان نهائياً.');
    }

    /**
     * عرض إعلانات المستخدم الحالي
     */
    public function myAds()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $ads = $user->ads()
            ->with('category', 'images')
            ->latest()
            ->paginate(20);

        return view('ads.my-ads', compact('ads'));
    }

    /**
     * دالة داخلية لتوليد منتجات وهمية (Fake Ads) بستايل TRICO العالمي
     */
    private function generateGlobalFakeAds()
    {
        $fakes = collect();
        $brands = ['Gucci', 'Nike Air', 'Zara Man', 'Adidas Original', 'Prada Sport', 'Louis Vuitton', 'H&M Trend', 'Balenciaga'];
        $cities = ['الجزائر العاصمة', 'وهران', 'سطيف', 'قسنطينة', 'بجاية', 'عنابة'];
        $categories = ['قمصان فاخرة', 'أحذية رياضية', 'ساعات يد', 'بدلات رسمية', 'حقائب جلدية'];
        
        for ($i = 1; $i <= 35; $i++) {
            $brand = $brands[array_rand($brands)];
            $catName = $categories[array_rand($categories)];
            
            $fakes->push((object)[
                'id' => 9000 + $i,
                'title' => "$brand - $catName إصدار " . (2025 + (rand(0,1))),
                'slug' => "global-trico-product-$i",
                'description' => "قطعة أصلية من مجموعة $brand الجديدة. جودة عالمية مضمونة.",
                'price' => rand(5500, 120000),
                'price_type' => 'fixed',
                'condition' => 'new',
                'condition_text' => 'جديد',
                'city' => $cities[array_rand($cities)],
                'status' => 'active',
                // استخدام صور عشوائية عالية الجودة
                'primary_image_url' => "https://picsum.photos/seed/trico" . ($i + 100) . "/600/800",
                'category' => (object)['name' => $catName],
                'user' => (object)['name' => 'Verified Global Seller'],
                'store' => (object)['name' => 'TRICO Global'],
                'created_at' => now()->subDays(rand(1, 15)),
                'views_count' => rand(100, 5000)
            ]);
        }
        return $fakes;
    }

    /**
     * تحديد القالب المناسب بناءً على الفئة
     */
    private function getTemplateForCategory($categoryId)
    {
        $category = Category::find($categoryId);
        return $category?->type ?? 'general';
    }
}