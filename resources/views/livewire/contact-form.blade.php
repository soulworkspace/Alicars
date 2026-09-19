<div>
    @if($success)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            تم إرسال رسالتك بنجاح! سيتواصل معك البائع قريباً.
        </div>
    @endif

    @if(!$showForm)
        <button wire:click="toggleForm" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700">
            @if($type === 'offer')
                <i class="fas fa-hand-holding-usd ml-2"></i> تقديم عرض
            @else
                <i class="fas fa-envelope ml-2"></i> إرسال رسالة
            @endif
        </button>
    @else
        <form wire:submit.prevent="submit" class="mt-4 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
                <input type="text" wire:model="senderName"
                       class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                       placeholder="اسمك الكامل">
                @error('senderName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف</label>
                <input type="tel" wire:model="senderPhone"
                       class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                       placeholder="05xxxxxxxx">
                @error('senderPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني (اختياري)</label>
                <input type="email" wire:model="senderEmail"
                       class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                       placeholder="example@email.com">
                @error('senderEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            @if($type === 'offer')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">مبلغ العرض (د.ج)</label>
                    <input type="number" wire:model="offerAmount"
                           class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                           placeholder="10000">
                    @error('offerAmount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">الرسالة</label>
                <textarea wire:model="message" rows="4"
                          class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                          placeholder="اكتب رسالتك هنا..."></textarea>
                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                    <i class="fas fa-paper-plane ml-2"></i> إرسال
                </button>
                <button type="button" wire:click="toggleForm"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    إلغاء
                </button>
            </div>
        </form>
    @endif
</div>
