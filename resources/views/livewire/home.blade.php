<div>
    @include('components.IBM.header')

    @include('components.IBM.hero')
    @include('components.IBM.services')
    @include('components.IBM.feature')
    <div class="row g-4">
        @forelse($recentAds as $ad)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <x-IBM.car :ad="$ad" />
            </div>
        @empty
            <div class="col-12 text-center text-muted py-4">
                No vehicles available.
            </div>
        @endforelse
    </div>
    @include('components.IBM.chooseus')
    @include('components.IBM.ai')

    
</div>