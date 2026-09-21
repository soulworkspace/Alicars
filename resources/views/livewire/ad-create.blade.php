<div class="ad-create-page" dir="rtl">
    <style>
        .ad-create-page { --create-accent: #28c79b; --create-bg: #0b1014; --create-card: #121a20; --create-border: #26333b; min-height: 100vh; padding: 3rem 0; color: #f4f7f8; background: radial-gradient(circle at 10% 0%, #17332f 0, transparent 32rem), var(--create-bg); }
        .ad-create-page .create-card { border: 1px solid var(--create-border); border-radius: 1.25rem; background: rgba(18, 26, 32, .92); box-shadow: 0 1.5rem 4rem rgba(0, 0, 0, .24); }
        .ad-create-page .form-control, .ad-create-page .form-select { min-height: 3rem; color: #f4f7f8; background-color: #0e151a; border-color: var(--create-border); }
        .ad-create-page .form-control:focus, .ad-create-page .form-select:focus { color: #fff; background-color: #101a20; border-color: var(--create-accent); box-shadow: 0 0 0 .2rem rgba(40, 199, 155, .16); }
        .ad-create-page .upload-zone { border: 1.5px dashed #3d555e; border-radius: 1rem; background: rgba(255, 255, 255, .025); transition: border-color .2s, background .2s, transform .2s; }
        .ad-create-page .upload-zone:hover, .ad-create-page .upload-zone.is-dragging { border-color: var(--create-accent); background: rgba(40, 199, 155, .08); transform: translateY(-2px); }
        .ad-create-page .preview-card { position: relative; overflow: hidden; border: 1px solid var(--create-border); border-radius: .9rem; background: #0e151a; }
        .ad-create-page .preview-card.is-primary { border-color: var(--create-accent); box-shadow: 0 0 0 .15rem rgba(40, 199, 155, .16); }
        .ad-create-page .preview-card img { width: 100%; height: 8rem; object-fit: cover; }
        .ad-create-page .preview-actions { position: absolute; inset: .5rem .5rem auto; display: flex; justify-content: space-between; }
        .ad-create-page .icon-action { width: 2rem; height: 2rem; padding: 0; border: 0; border-radius: 50%; color: #fff; background: rgba(0, 0, 0, .65); }
        .ad-create-page .icon-action:hover { color: #06120f; background: var(--create-accent); }
        .ad-create-page .primary-label { display: block; padding: .55rem; color: #98a9af; font-size: .75rem; cursor: pointer; text-align: center; }
        .ad-create-page .preview-card.is-primary .primary-label { color: var(--create-accent); font-weight: 700; }
        .ad-create-page .progress { height: .45rem; background: #26333b; }
        .ad-create-page .progress-bar { background: var(--create-accent); transition: width .2s ease; }
        .ad-create-page .btn-create { border: 0; color: #06120f; background: var(--create-accent); font-weight: 800; }
        .ad-create-page .btn-create:hover { color: #06120f; background: #5be0bb; }
        .ad-create-page .section-title { border-right: 3px solid var(--create-accent); padding-right: .75rem; }
    </style>

    <div class="container">
        <div class="mb-5 text-center">
            <span class="text-uppercase small fw-bold" style="color: var(--create-accent); letter-spacing: .18em;">MB MOTORS</span>
            <h1 class="display-6 fw-bold mt-2">أضف سيارتك للبيع</h1>
            <p class="text-secondary mb-0">أدخل البيانات وارفع صوراً واضحة ليظهر إعلانك بأفضل صورة.</p>
        </div>

        <form wire:submit="save" class="create-card p-3 p-md-5" enctype="multipart/form-data">
            <section class="mb-5">
                <h2 class="section-title h5 fw-bold mb-4">المعلومات الأساسية</h2>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label text-secondary">عنوان الإعلان *</label>
                        <input wire:model.blur="title" type="text" class="form-control" placeholder="مثال: مرسيدس C-Class 2022 بحالة ممتازة">
                        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary">الفئة *</label>
                        <select wire:model="category_id" class="form-select">
                            <option value="">اختر الفئة</option>
                            @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach($category->children as $child)<option value="{{ $child->id }}">{{ $child->name }}</option>@endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary">سنة الصنع *</label>
                        <input wire:model="year" type="number" min="1900" max="{{ now()->year + 1 }}" class="form-control" placeholder="2024">
                        @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary">الحالة *</label>
                        <select wire:model="condition" class="form-select">
                            <option value="new">جديدة</option><option value="used">مستعملة</option><option value="refurbished">مجددّة</option>
                        </select>
                    </div>
                </div>
            </section>

            <section class="mb-5">
                <h2 class="section-title h5 fw-bold mb-4">المواصفات والسعر</h2>
                <div class="row g-4">
                    <div class="col-md-3"><label class="form-label text-secondary">الكيلومترات *</label><input wire:model="mileage" type="number" min="0" class="form-control"><small class="text-secondary">KM</small>@error('mileage') <small class="text-danger d-block">{{ $message }}</small> @enderror</div>
                    <div class="col-md-3"><label class="form-label text-secondary">ناقل الحركة *</label><select wire:model="transmission" class="form-select"><option value="automatic">أوتوماتيك</option><option value="manual">يدوي</option><option value="cvt">CVT</option></select></div>
                    <div class="col-md-3"><label class="form-label text-secondary">الوقود *</label><select wire:model="fuel_type" class="form-select"><option value="gasoline">بنزين</option><option value="diesel">ديزل</option><option value="electric">كهربائي</option><option value="hybrid">هجين</option></select></div>
                    <div class="col-md-3"><label class="form-label text-secondary">السعر</label><input wire:model="price" type="number" min="0" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label text-secondary">نوع السعر *</label><select wire:model="price_type" class="form-select"><option value="fixed">ثابت</option><option value="negotiable">قابل للتفاوض</option><option value="free">بدون سعر</option></select></div>
                    <div class="col-md-6"><label class="form-label text-secondary">المدينة</label><input wire:model="city" type="text" class="form-control"></div>
                </div>
            </section>

            <section class="mb-5">
                <h2 class="section-title h5 fw-bold mb-4">الوصف والصور</h2>
                <textarea wire:model="description" rows="5" class="form-control mb-4" placeholder="اذكر المحرك، التجهيزات، تاريخ الصيانة وأي ملاحظات مهمة..."></textarea>
                @error('description') <small class="text-danger d-block mb-3">{{ $message }}</small> @enderror

                <div x-data="{ dragging: false, progress: 0 }" class="upload-zone p-4 text-center" :class="{ 'is-dragging': dragging }" x-on:livewire-upload-progress.window="progress = $event.detail.progress" x-on:livewire-upload-finish.window="progress = 100" x-on:livewire-upload-error.window="progress = 0" x-on:dragover.prevent="dragging = true" x-on:dragleave.prevent="dragging = false" x-on:drop.prevent="dragging = false; $wire.uploadMultiple('images', Array.from($event.dataTransfer.files))">
                    <input id="ad-images" wire:model="images" type="file" multiple accept=".jpg,.jpeg,.png,.webp,.gif,.heic,.svg,.avif,image/*" class="d-none">
                    <label for="ad-images" class="d-block mb-0" style="cursor: pointer;">
                        <i class="fas fa-cloud-arrow-up fs-1 mb-3" style="color: var(--create-accent);"></i>
                        <div class="fw-bold">اسحب الصور هنا أو اضغط للاختيار</div>
                        <small class="text-secondary">حتى 12 صورة، بحد أقصى 5MB للصورة · JPG, PNG, WEBP, GIF, HEIC, SVG, AVIF</small>
                    </label>
                </div>
                @error('images') <small class="text-danger d-block mt-2">{{ $message }}</small> @enderror
                @error('images.*') <small class="text-danger d-block mt-2">{{ $message }}</small> @enderror

                <div wire:loading wire:target="images" class="mt-3" x-show="progress > 0" x-cloak>
                    <div class="d-flex justify-content-between small text-secondary mb-1"><span>جاري رفع الصور...</span><span x-text="`${Math.round(progress)}%`">0%</span></div>
                    <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="`width: ${progress}%`" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div></div>
                </div>

                @if(count($images))
                    <div class="row g-3 mt-3">
                        @foreach($images as $index => $image)
                            <div class="col-6 col-md-3">
                                <div class="preview-card {{ $primaryImage === $index ? 'is-primary' : '' }}">
                                    <img src="{{ $image->temporaryUrl() }}" alt="معاينة الصورة {{ $index + 1 }}">
                                    <div class="preview-actions">
                                        <button type="button" wire:click="removeImage({{ $index }})" class="icon-action" aria-label="حذف الصورة"><i class="fas fa-times"></i></button>
                                        @if($primaryImage === $index)<span class="badge text-bg-success">رئيسية</span>@endif
                                    </div>
                                    <button type="button" wire:click="setPrimaryImage({{ $index }})" class="primary-label w-100 border-0 bg-transparent">{{ $primaryImage === $index ? 'الصورة الرئيسية' : 'تعيين كرئيسية' }}</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="mb-4">
                <h2 class="section-title h5 fw-bold mb-4">الوصف والتواصل</h2>
                <div class="row g-4">
                    <div class="col-md-6"><label class="form-label text-secondary">رقم الهاتف</label><input wire:model="contact_phone" type="text" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label text-secondary">واتساب</label><input wire:model="contact_whatsapp" type="text" class="form-control"></div>
                    <div class="col-12"><label class="form-label text-secondary">الموقع</label><input wire:model="location" type="text" class="form-control"></div>
                </div>
            </section>

            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 border-top pt-4" style="border-color: var(--create-border) !important;">
                <span class="small text-secondary"><i class="fas fa-shield-halved me-1" style="color: var(--create-accent);"></i> يخضع الإعلان للمراجعة قبل النشر</span>
                <button type="submit" class="btn btn-create px-5 py-3" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">نشر الإعلان</span>
                    <span wire:loading wire:target="save"><i class="fas fa-spinner fa-spin me-1"></i> جاري الحفظ...</span>
                </button>
            </div>
        </form>
    </div>
</div>
