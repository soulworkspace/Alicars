<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * عرض قائمة السيارات (أحدث السيارات أولاً مع دعم التقسيم)
     */
    public function index()
    {
        // استخدام latest() لجلب الأحدث مع تقسيم الصفحات بدلاً من جلب الكل دفعة واحدة
        $cars = Car::latest()->paginate(15);

        return response()->json($cars);
    }

    /**
     * إضافة سيارة جديدة مع مرونة رفع الملفات المحلية أو استخدام رابط خارجي
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'brand'        => 'required|string|max:255',
            'year'         => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price'        => 'required|numeric|min:0',
            'fuel_type'    => 'required|string|max:50',
            'transmission' => 'required|string|max:50',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url'    => 'nullable|url|max:2048',
            'description'  => 'nullable|string',
        ]);

        // معالجة الصورة: إذا قام المستخدم برفع ملف محلي يتم تخزينه، وإلا يُستغل الرابط الخارجي
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cars', 'public');
            $validated['image_url'] = Storage::disk('public')->url($path);
        }

        // إزالة الحقل المؤقت الخاص بالملف لتفادي مشاكل الحفظ المباشر
        unset($validated['image']);

        $car = Car::create($validated);

        return response()->json([
            'message' => 'Car uploaded successfully!',
            'car'     => $car,
        ], 201);
    }

    /**
     * عرض تفاصيل سيارة معينة
     */
    public function show($id)
    {
        $car = Car::findOrFail($id);

        return response()->json($car);
    }

    /**
     * المعاينة السريعة للسيارة (دعم الـ Hover / AJAX Preview مع الكاش)
     */
    public function preview($id)
    {
        $preview = Cache::remember("car-preview:{$id}", now()->addMinutes(10), function () use ($id) {
            $car = Car::findOrFail($id);

            return [
                'id'           => $car->id,
                'title'        => $car->title,
                'brand'        => $car->brand,
                'year'         => $car->year,
                'price'        => number_format((float) $car->price) . ' DZD',
                'fuel_type'    => $car->fuel_type,
                'transmission' => $car->transmission,
                'image_url'    => $this->resolveImageUrl($car->image_url),
                'description'  => str($car->description ?: '')->squish()->limit(140)->toString(),
            ];
        });

        return response()->json($preview);
    }

    /**
     * تحديث بيانات السيارة
     */
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'sometimes|required|string|max:255',
            'brand'        => 'sometimes|required|string|max:255',
            'year'         => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
            'price'        => 'sometimes|required|numeric|min:0',
            'fuel_type'    => 'sometimes|required|string|max:50',
            'transmission' => 'sometimes|required|string|max:50',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url'    => 'nullable|url|max:2048',
            'description'  => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cars', 'public');
            $validated['image_url'] = Storage::disk('public')->url($path);
        }

        unset($validated['image']);

        $car->update($validated);

        // مسح الكاش لإظهار التعديلات فوراً في المعاينة
        Cache::forget("car-preview:{$id}");

        return response()->json([
            'message' => 'Car updated successfully!',
            'car'     => $car,
        ]);
    }

    /**
     * حذف السيارة
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        
        Cache::forget("car-preview:{$id}");
        $car->delete();

        return response()->json(['message' => 'Car deleted successfully!']);
    }

    /**
     * دالة مساعدة لمعالجة مسار الصورة وإتاحة صورة افتراضية في حال الغياب
     */
    private function resolveImageUrl(?string $path): string
    {
        if (blank($path)) {
            return asset('bgg.jfif');
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return asset('bgg.jfif');
    }
}