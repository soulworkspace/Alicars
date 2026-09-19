@extends('layouts.app')

@section('title', 'إضافة سيارة جديدة للبيع | MB MOTORS')

@section('content')
<!-- تخصيص الألوان الداكنة والزمردية المتوافقة مع الهوية البصرية وضبط Nice Select لدعم RTL -->
<style>
    :root {
        --emerald-light: #10b981;
        --card-bg: #14171c;
        --input-bg: #0f1115;
        --select-bg: #1a1d23;
        --border-color: #2d3139;
    }
    body {
        background-color: #0b0c10;
        color: #ffffff;
    }
    .form-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    .custom-input, .custom-select, .custom-textarea {
        background-color: var(--input-bg) !important;
        border: 1px solid var(--border-color) !important;
        color: #ffffff !important;
        border-radius: 12px;
        padding: 12px;
    }
    .custom-input:focus, .custom-select:focus, .custom-textarea:focus {
        border-color: var(--emerald-light) !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25) !important;
    }
    .section-indicator {
        background-color: var(--emerald-light);
        width: 6px;
        height: 30px;
        display: inline-block;
        border-radius: 4px;
    }
    .inner-block {
        background-color: var(--input-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
    }
    .upload-box {
        border: 2px dashed var(--border-color);
        border-radius: 16px;
        position: relative;
        transition: all 0.3s ease;
    }
    .upload-box:hover {
        border-color: var(--emerald-light);
    }
    .btn-premium {
        background-color: var(--emerald-light);
        color: #fff;
        font-weight: bold;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-premium:hover {
        background-color: #059669;
        color: #fff;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    /* ==========================================
       إصلاح جذري لتوافق Nice Select مع نظام RTL والثيم الداكن
    ============================================ */
    .nice-select {
        width: 100% !important;
        float: none !important;
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        background-color: var(--input-bg) !important;
        border: 1px solid var(--border-color) !important;
        color: #ffffff !important;
        border-radius: 12px !important;
        height: 48px !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
        text-align: right !important;
    }

    /* نقل السهم لليسار ليتوافق مع الواجهة العربية */
    .nice-select:after {
        left: 15px !important;
        right: auto !important;
        margin-top: 0 !important;
        transform: translateY(-50%) !important;
        border-bottom: 2px solid #6c757d !important;
        border-right: 2px solid #6c757d !important;
    }

    .nice-select.open:after {
        transform: translateY(-50%) rotate(-180deg) !important;
    }

    /* تخصيص صندوق القائمة المنسدلة */
    .nice-select .list {
        background-color: var(--select-bg) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 12px !important;
        width: 100% !important;
        left: auto !important;
        right: 0 !important;
        margin-top: 5px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.6) !important;
        max-height: 260px !important;
        overflow-y: auto !important;
        padding: 5px 0 !important;
        z-index: 999;
    }

    /* تخصيص خيارات القائمة باللغة العربية */
    .nice-select .option {
        text-align: right !important;
        padding-right: 20px !important;
        padding-left: 20px !important;
        color: #e2e8f0 !important;
        line-height: 40px !important;
        min-height: 40px !important;
        transition: all 0.2s ease;
    }

    /* تأثيرات التمرير النشط والاختيار */
    .nice-select .option:hover, 
    .nice-select .option.focus, 
    .nice-select .option.selected.focus {
        background-color: rgba(16, 185, 129, 0.15) !important;
        color: var(--emerald-light) !important;
    }

    .nice-select .current {
        color: #ffffff !important;
    }

    .nice-select .optgroup {
        padding: 5px 10px !important;
        font-weight: bold;
        color: var(--emerald-light) !important;
        font-size: 0.85em;
        border-bottom: 1px solid var(--border-color);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10 col-md-12">
            
            {{-- Header Section --}}
            <div class="text-center mb-5">
                <h1 class="fw-bold text-white mb-3 display-5 px-2">
                    عرض <span style="color: var(--emerald-light);">سيارة</span> للبيع
                </h1>
                <p class="text-muted fw-medium px-3">قم بملء مواصفات السيارة بدقة لعرضها في منصة MB MOTORS لبيع السيارات</p>
            </div>

            {{-- Main Form Card --}}
            <form action="{{ route('ads.store') }}" method="POST" enctype="multipart/form-data" class="form-card p-4 p-md-5 mx-2">
                @csrf

                {{-- 1. المعلومات الأساسية للمركبة --}}
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4">
                        <span class="section-indicator ml-3 me-3"></span>
                        <h3 class="h4 fw-bold text-white mb-0">المعلومات الأساسية للمركبة</h3>
                    </div>
                    
                    <div class="row g-4">
                        {{-- عنوان الإعلان --}}
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary mb-2">عنوان الإعلان *</label>
                            <input type="text" name="title" required
                                   class="form-control custom-input"
                                   placeholder="مثال: مرسيدس غلاس 2024 فل كامل / تويوتا هايلوكس دبل"
                                   value="{{ old('title') }}">
                            @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        {{-- الماركة والفئة --}}
                        <div class="col-md-6 col-sm-12">
                            <label class="form-label small fw-bold text-secondary mb-2">الماركة والفئة *</label>
                            <select name="category_id" required class="form-select custom-select">
                                <option value="">اختر الشركة المصنعة</option>
                                @foreach($categories as $category)
                                    <optgroup label="{{ $category->name }}" style="background-color: var(--select-bg); color: var(--emerald-light);">
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }} class="text-white">
                                                {{ $child->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        {{-- سنة الصنع --}}
                        <div class="col-md-6 col-sm-12">
                            <label class="form-label small fw-bold text-secondary mb-2">سنة الصنع (الموديل) *</label>
                            <select name="year" required class="form-select custom-select">
                                <option value="">اختر السنة</option>
                                @for ($year = date('Y') + 1; $year >= 2015; $year--)
                                    <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- 2. المواصفات الفنية والحالة --}}
                <div class="mb-5 p-4 inner-block">
                    <div class="d-flex align-items-center mb-4">
                        <span class="section-indicator ml-3 me-3"></span>
                        <h3 class="h4 fw-bold text-white mb-0">المواصفات الفنية والحالة</h3>
                    </div>
                    
                    <div class="row g-4">
                        {{-- المسافة المقطوعة --}}
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label small fw-bold text-secondary mb-2">المسافة المقطوعة (كم) *</label>
                            <div class="input-group" dir="ltr">
                                <span class="input-group-text bg-dark text-secondary border-0 small fw-bold">KM</span>
                                <input type="number" name="mileage" required min="0"
                                       class="form-control custom-input text-end"
                                       placeholder="0" value="{{ old('mileage') }}">
                            </div>
                        </div>

                        {{-- ناقل الحركة --}}
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label small fw-bold text-secondary mb-2">ناقل الحركة *</label>
                            <select name="transmission" required class="form-select custom-select">
                                <option value="automatic">أوتوماتيك</option>
                                <option value="manual">يدوي (عادي)</option>
                                <option value="cvt">سي في تي</option>
                            </select>
                        </div>

                        {{-- نوع الوقود --}}
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label class="form-label small fw-bold text-secondary mb-2">نوع الوقود *</label>
                            <select name="fuel_type" required class="form-select custom-select">
                                <option value="gasoline">بنزين</option>
                                <option value="diesel">ديزل (مازوت)</option>
                                <option value="electric">كهربائي بالكامل</option>
                                <option value="hybrid">هجين</option>
                            </select>
                        </div>

                        {{-- حالة السيارة العامة --}}
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary mb-2">حالة المركبة *</label>
                            <select name="condition" required class="form-select custom-select">
                                <option value="new">جديدة تماماً (أصفار)</option>
                                <option value="excellent">مستعملة - بحالة ممتازة (شبه جديدة)</option>
                                <option value="good">مستعملة - بحالة جيدة</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- 3. تفاصيل السعر والمعاملة --}}
                <div class="mb-5 p-4 inner-block">
                    <div class="d-flex align-items-center mb-4">
                        <span class="section-indicator ml-3 me-3"></span>
                        <h3 class="h4 fw-bold text-white mb-0">تفاصيل السعر والمعاملة</h3>
                    </div>
                    <div class="row g-4">
                        {{-- السعر بالدينار الجزائري --}}
                        <div class="col-md-6 col-sm-12">
                            <label class="form-label small fw-bold text-secondary mb-2">السعر المطلـوب (د.ج)</label>
                            <div class="input-group" dir="ltr">
                                <span class="input-group-text bg-dark text-secondary border-0 fw-bold">DA</span>
                                <input type="number" name="price"
                                       class="form-control custom-input text-end"
                                       placeholder="اتركه فارغاً إذا كان السعر غير محدد" value="{{ old('price') }}">
                            </div>
                        </div>

                        {{-- خيارات التسعير --}}
                        <div class="col-md-6 col-sm-12">
                            <label class="form-label small fw-bold text-secondary mb-2">حالة السعر *</label>
                            <select name="price_type" required class="form-select custom-select">
                                <option value="fixed">سعر ثابت وغير قابل للنقاش</option>
                                <option value="negotiable">قابل للتفاوض (للنقاش)</option>
                                <option value="offered">عطاو (أعلى سومة وصلت)</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- 4. ألبوم الصور والوصف الفني للمركبة --}}
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4">
                        <span class="section-indicator ml-3 me-3"></span>
                        <h3 class="h4 fw-bold text-white mb-0">المواصفات الإضافية وألبوم الصور</h3>
                    </div>
                    
                    {{-- الوصف --}}
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary mb-2">الوصف التفصيلي (الخيارات والعيوب إن وجدت) *</label>
                        <textarea name="description" rows="5" required
                                  class="form-control custom-textarea"
                                  placeholder="اذكر هنا مواصفات السيارة (مثل: نوع المحرك، فتحة سقف، كاميرات، نظام الملاحة، حالة الطلاء والبدن، الصيانة الدورية...)">{{ old('description') }}</textarea>
                    </div>

                    {{-- رفع الصور المتعددة للسيارة --}}
                    <div class="upload-box p-4 p-md-5 text-center position-relative mx-1">
                        <input type="file" name="images[]" id="vehicle-images" multiple accept="image/*" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;">
                        <i class="fas fa-car display-5 text-muted mb-3"></i>
                        <p class="text-secondary fw-medium mb-1">اسحب صور السيارة هنا أو اضغط للاختيار من جهازك</p>
                        <p id="upload-feedback" class="small text-muted mb-0">يرجى رفع صور واضحة (الواجهة، الخلفية، والداخلية) - الأقصى 3 ميجابايت لكل صورة</p>
                    </div>
                </div>

                {{-- أزرار الإجراءات --}}
                <div class="pt-4 border-top border-secondary d-flex flex-column flex-md-row gap-3 align-items-center justify-content-between">
                    <p class="small text-muted mb-0 text-center text-md-start col-md-5">
                        بنشرك للإعلان، أنت تتعهد بصحة البيانات والمواصفات المدرجة للمركبة أمام المشتري.
                    </p>
                    
                    <div class="d-flex gap-3 w-100 w-md-auto justify-content-center justify-content-md-end">
                        <a href="{{ route('home') }}" class="btn btn-link text-secondary text-decoration-none fw-bold px-4 py-3">
                            إلغاء
                        </a>
                        <button type="submit" class="btn btn-premium px-5 py-3 rounded-3 shadow">
                            نشر السيارة للبيع
                        </button>
                    </div>
                </div>

            </form>

            {{-- Verification Note --}}
            <div class="mt-4 d-flex align-items-center justify-content-center text-muted small text-center px-3">
                <i class="fas fa-shield-alt text-success me-2 ms-2"></i>
                <span>تخضع الإعلانات للفحص الفني والرقابي قبل ظهورها لضمان خلو المنصة من الإعلانات الوهمية.</span>
            </div>
        </div>
    </div>
</div>

{{-- سكربت تفاعلي لحساب عدد الصور المرفوعة فورياً --}}
<script>
    document.getElementById('vehicle-images').addEventListener('change', function(e) {
        const filesCount = e.target.files.length;
        const feedback = document.getElementById('upload-feedback');
        if(filesCount > 0) {
            feedback.textContent = `✓ تم اختيار ${filesCount} صور للمركبة بنجاح وسيتم رفعها عند النشر`;
            feedback.style.color = "var(--emerald-light)";
            feedback.style.fontWeight = "bold";
        }
    });
</script>
@endsection