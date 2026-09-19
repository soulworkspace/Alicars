<footer class="bg-black py-24 mt-40 border-t border-[#c18f54]/10">
    <div class="container mx-auto px-4 grid md:grid-cols-4 gap-16">
        <div class="col-span-1 md:col-span-1">
            <span class="font-international text-4xl font-black text-white uppercase tracking-tighter">TRI<span class="text-[#c18f54]">CO</span></span>
            <p class="mt-8 text-gray-500 leading-relaxed text-sm font-medium">
                المنصة العربية الأولى للسيارات الصينية. جودة، ثقة، وأمان يفوق التوقعات. نحن نغير مفهوم سوق السيارات الرقمي.
            </p>
            <div class="flex gap-4 mt-8 text-xl text-gray-400">
                <a href="#" class="hover:text-[#c18f54] transition-colors"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="hover:text-[#c18f54] transition-colors"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#" class="hover:text-[#c18f54] transition-colors"><i class="fa-brands fa-facebook"></i></a>
            </div>
        </div>
        <div>
            <h4 class="font-black text-white mb-8 uppercase tracking-widest text-sm">عن TRICO</h4>
            <ul class="space-y-4 text-gray-500 text-sm font-bold">
                <li><a href="{{ route('help') }}" class="hover:text-[#c18f54] transition-colors uppercase">مركز المساعدة</a></li>
                <li><a href="{{ route('safety') }}" class="hover:text-[#c18f54] transition-colors uppercase">دليل الأمان</a></li>
                <li><a href="{{ route('terms') }}" class="hover:text-[#c18f54] transition-colors uppercase">الشروط والأحكام</a></li>
                <li><a href="{{ route('privacy') }}" class="hover:text-[#c18f54] transition-colors uppercase">سياسة الخصوصية</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-black text-white mb-8 uppercase tracking-widest text-sm">حسابي</h4>
            <ul class="space-y-4 text-gray-500 text-sm font-bold uppercase">
                @auth
                    <li><a href="{{ route('dashboard') }}" class="hover:text-[#c18f54] transition-colors">لوحة التحكم</a></li>
                    <li><a href="{{ route('my-ads') }}" class="hover:text-[#c18f54] transition-colors">إعلاناتي</a></li>
                    <li><a href="{{ route('favorites.index') }}" class="hover:text-[#c18f54] transition-colors">المفضلة</a></li>
                    <li><a href="{{ route('messages.index') }}" class="hover:text-[#c18f54] transition-colors">الرسائل</a></li>
                    <li><a href="{{ route('profile.show') }}" class="hover:text-[#c18f54] transition-colors">إعدادات الحساب</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-[#c18f54] transition-colors">تسجيل الدخول</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-[#c18f54] transition-colors">فتح متجر</a></li>
                @endauth
            </ul>
        </div>
        <div>
            <h4 class="font-black text-white mb-8 uppercase tracking-widest text-sm">النشرة الدولية</h4>
            <p class="text-gray-500 text-xs mb-6 font-bold uppercase tracking-tighter">كن أول من يعرف عن أحدث العروض والسيارات الحصرية</p>
            <form class="flex bg-white/5 rounded-full p-1 border border-white/10 focus-within:border-[#c18f54] transition-all">
                <input type="email" placeholder="البريد الإلكتروني" class="bg-transparent px-6 py-2 w-full outline-none text-xs text-white">
                <button type="submit" class="bg-[#c18f54] hover:bg-[#a87943] text-white px-6 py-2 rounded-full font-black text-[10px] uppercase transition-colors">انضم</button>
            </form>
        </div>
    </div>
    <div class="container mx-auto px-4 mt-24 pt-8 border-t border-white/5 text-center">
        <p class="text-[10px] font-black text-gray-600 uppercase tracking-[0.5em] font-international">© 2026 TRICO GLOBAL SYSTEM - ALL RIGHTS RESERVED</p>
    </div>
</footer>