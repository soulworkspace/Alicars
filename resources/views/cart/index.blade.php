@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-white font-black"><i class="bi bi-cart3 text-primary me-2"></i> سلة مشتريات تريكو</h2>

    @if(session('success'))
        <div class="alert alert-success border-0 bg-success text-white rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @if(count($cart) > 0)
            <div class="col-lg-8">
                <div class="card bg-dark border-gray-800 shadow-sm rounded-2xl overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0 align-middle">
                            <thead class="bg-black/50">
                                <tr>
                                    <th class="ps-4 py-3 text-gray-400 fw-normal">المنتج</th>
                                    <th class="py-3 text-gray-400 fw-normal">المواصفات</th>
                                    <th class="py-3 text-gray-400 fw-normal">السعر</th>
                                    <th class="py-3 text-gray-400 fw-normal">الكمية</th>
                                    <th class="py-3 text-center text-gray-400 fw-normal">إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $key => $item)
                                    <tr class="border-gray-800">
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                                     class="rounded-lg object-cover" style="width: 60px; height: 60px;" alt="">
                                                <div class="ms-3">
                                                    <h6 class="mb-0 text-white">{{ $item['title'] }}</h6>
                                                    <small class="text-muted">بواسطة: بائع تريكو</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary/20 text-white rounded-pill px-3">{{ $item['size'] }}</span>
                                            <span class="badge bg-primary/20 text-primary rounded-pill px-3">{{ $item['color'] }}</span>
                                        </td>
                                        <td class="text-white">{{ number_format($item['price']) }} دج</td>
                                        <td class="text-white">× {{ $item['quantity'] }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-trash3 fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-dark border-primary/20 shadow-lg rounded-2xl p-4 sticky-top" style="top: 20px;">
                    <h5 class="text-white mb-4 border-bottom border-gray-800 pb-3">إتمام عملية الشراء</h5>
                    
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="text-gray-400 text-xs mb-1">رقم الهاتف (ضروري للتوصيل)</label>
                            <div class="input-group bg-black border-gray-800 rounded-xl overflow-hidden">
                                <span class="input-group-text bg-transparent border-0 text-primary"><i class="bi bi-phone"></i></span>
                                <input type="text" name="phone" class="form-control bg-transparent border-0 text-white py-2" 
                                       placeholder="مثلاً: 0661000000" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-gray-400 text-xs mb-1">عنوان التوصيل (الأغواط، الحي، رقم البيت)</label>
                            <textarea name="shipping_address" class="form-control bg-black border-gray-800 text-white rounded-xl" 
                                      rows="3" placeholder="اكتب عنوانك بالتفصيل هنا..." required></textarea>
                        </div>

                        <div class="bg-black/30 p-3 rounded-xl mb-4 border border-gray-800">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-gray-400">عدد القطع:</span>
                                <span class="text-white">{{ count($cart) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="text-white mb-0">الإجمالي:</h5>
                                <h5 class="text-primary mb-0">{{ number_format($total) }} دج</h5>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-xl shadow-lg shadow-primary/20 fw-bold">
                            تأكيد طلب الشراء الآن <i class="bi bi-send-check ms-2"></i>
                        </button>
                    </form>
                    
                    <p class="text-center text-gray-500 text-[10px] mt-3">
                        بالضغط على تأكيد، سيتم إرسال طلبك مباشرة للبائع لتجهيزه.
                    </p>
                </div>
            </div>
        @else
            <div class="col-12 text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-bag-x text-gray-800" style="font-size: 5rem;"></i>
                </div>
                <h4 class="text-white">سلة تريكو فارغة حالياً</h4>
                <p class="text-gray-500 mb-4">لم تقم بإضافة أي ملابس بعد، استمتع بالتسوق واكتشف أحدث الموديلات.</p>
                <a href="{{ route('ads.index') }}" class="btn btn-primary px-5 py-2 rounded-pill">تصفح الملابس</a>
            </div>
        @endif
    </div>
</div>
@endsection