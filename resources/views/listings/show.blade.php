<form action="{{ route('cart.add', $listing->id) }}" method="POST" class="mt-4">
    @csrf
    
    <div class="mb-3">
        <label class="form-label fw-bold">اختر المقاس:</label>
        <div class="d-flex gap-2">
            @foreach(json_decode($listing->sizes) as $size)
                <input type="radio" class="btn-check" name="size" id="size-{{ $size }}" value="{{ $size }}" required>
                <label class="btn btn-outline-dark" for="size-{{ $size }}">{{ $size }}</label>
            @endforeach
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">اختر اللون:</label>
        <select name="color" class="form-select" required>
            <option value="">اختر لونك المفضل...</option>
            @foreach(json_decode($listing->colors) as $color)
                <option value="{{ $color }}">{{ $color }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary btn-lg w-100">
        <i class="bi bi-cart-plus"></i> إضافة إلى سلة تريكو
    </button>
</form>