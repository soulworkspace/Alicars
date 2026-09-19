@extends('layouts.dashboard')

@section('title', 'تعديل الملف الشخصي')
@section('page-title', 'تعديل الملف الشخصي')

@section('content')
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Profile Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h3 class="font-bold text-lg mb-6">المعلومات الشخصية</h3>
                
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">الاسم</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                class="form-input w-full px-4 py-3 rounded-xl" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-2">البريد الإلكتروني</label>
                            <input type="email" value="{{ $user->email }}" 
                                class="form-input w-full px-4 py-3 rounded-xl bg-white/5" disabled>
                            <p class="text-xs text-gray-500 mt-1">لا يمكن تغيير البريد الإلكتروني</p>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold mb-2">رقم الهاتف</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                                    class="form-input w-full px-4 py-3 rounded-xl">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold mb-2">واتساب</label>
                                <input type="tel" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" 
                                    class="form-input w-full px-4 py-3 rounded-xl">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-2">العنوان</label>
                            <textarea name="address" rows="2" class="form-input w-full px-4 py-3 rounded-xl">{{ old('address', $user->address) }}</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-2">نبذة عني</label>
                            <textarea name="bio" rows="3" class="form-input w-full px-4 py-3 rounded-xl" placeholder="اكتب نبذة قصيرة عن نفسك...">{{ old('bio', $user->bio ?? '') }}</textarea>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="btn-premium px-6 py-3 rounded-xl">
                            <i class="fa-solid fa-save mr-2"></i> حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Change Password -->
            <div class="card p-6">
                <h3 class="font-bold text-lg mb-6">تغيير كلمة المرور</h3>
                
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">كلمة المرور الحالية</label>
                            <input type="password" name="current_password" class="form-input w-full px-4 py-3 rounded-xl" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-2">كلمة المرور الجديدة</label>
                            <input type="password" name="password" class="form-input w-full px-4 py-3 rounded-xl" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-2">تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" class="form-input w-full px-4 py-3 rounded-xl" required>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="btn-outline px-6 py-3 rounded-xl">
                            <i class="fa-solid fa-key mr-2"></i> تغيير كلمة المرور
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Side Column -->
        <div class="space-y-6">
            <!-- Avatar -->
            <div class="card p-6 text-center">
                <h3 class="font-bold mb-4">الصورة الشخصية</h3>
                
                <div class="w-24 h-24 rounded-full bg-emerald-500/20 flex items-center justify-center mx-auto mb-4 overflow-hidden">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-user text-emerald-400 text-3xl"></i>
                    @endif
                </div>
                
                <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <label class="block">
                        <span class="btn-outline px-4 py-2 rounded-lg text-xs inline-block cursor-pointer">
                            <i class="fa-solid fa-camera mr-1"></i> تغيير الصورة
                        </span>
                        <input type="file" name="avatar" class="hidden" accept="image/*" onchange="this.form.submit()">
                    </label>
                </form>
            </div>
            
            <!-- Account Info -->
            <div class="card p-6">
                <h3 class="font-bold mb-4">معلومات الحساب</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">نوع الحساب</span>
                        <span class="font-bold">{{ $user->role === 'vendor' ? 'بائع' : ($user->role === 'admin' ? 'مدير' : 'مستخدم') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">تاريخ الانضمام</span>
                        <span class="font-bold">{{ $user->created_at->format('Y/m/d') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">آخر تسجيل دخول</span>
                        <span class="font-bold">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'غير معروف' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">الحالة</span>
                        <span class="badge {{ $user->is_active ? 'badge-emerald' : 'badge-rose' }}">
                            {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Delete Account -->
            <div class="card p-6 border-rose-500/30">
                <h3 class="font-bold text-rose-400 mb-4">حذف الحساب</h3>
                <p class="text-sm text-gray-500 mb-4">حذف حسابك سيؤدي لإزالة جميع بياناتك وإعلاناتك بشكل دائم.</p>
                
                <button onclick="document.getElementById('deleteModal').classList.remove('hidden')" 
                    class="text-rose-400 text-sm font-bold hover:text-rose-300">
                    <i class="fa-solid fa-trash mr-1"></i> حذف حسابي
                </button>
            </div>
        </div>
    </div>
    
    <!-- Delete Account Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="card p-6 max-w-md w-full mx-4">
            <h3 class="font-bold text-lg mb-4 text-rose-400">تأكيد حذف الحساب</h3>
            <p class="text-sm text-gray-400 mb-4">هل أنت متأكد من رغبتك في حذف حسابك؟ لا يمكن التراجع عن هذا الإجراء.</p>
            
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">أدخل كلمة المرور للتأكيد</label>
                    <input type="password" name="password" class="form-input w-full px-4 py-3 rounded-xl" required>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" 
                        class="flex-1 btn-outline px-4 py-3 rounded-xl">
                        إلغاء
                    </button>
                    <button type="submit" class="flex-1 bg-rose-500 text-white px-4 py-3 rounded-xl font-bold hover:bg-rose-600 transition-colors">
                        حذف الحساب
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
