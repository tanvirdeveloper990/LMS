@php
    $review = \App\Models\CustomerReview::where('status', 1)->get();
@endphp

<style>
    :root {
        --brand-red:   #FF0000;
        --brand-black: #000000;
        --brand-white: #ffffff;
    }

    .review-title-bar {
        width: 70px;
        height: 4px;
        background: var(--brand-red);
        margin: 14px auto 0;
        border-radius: 999px;
    }

    .review-card {
        background: var(--brand-white);
        border-radius: 1rem;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        padding: 1rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: box-shadow .25s ease, transform .25s ease;
        border: 1px solid #f1f1f1;
    }
    .review-card:hover {
        box-shadow: 0 10px 24px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .review-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid #f3f4f6;
    }

    .review-text-box {
        background: #DEEAF1;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        flex: 1;
    }
</style>

<section class="w-100 py-5" style="background:#f7f7f8;">
    <div class="container">

        <h2 class="fw-bold text-dark text-center mb-2" style="font-size:1.75rem;">
            Pleasures From Our Honorable Customers
        </h2>
        <div class="review-title-bar mb-4"></div>

        @if($review->count() > 0)
        <div class="row g-3 mt-2">
            @foreach($review as $item)
            <div class="col-6 col-lg-4 col-xl-3">
                <div class="review-card">

                    {{-- Reviewer Info --}}
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $item->image ? Storage::url($item->image) : 'https://via.placeholder.com/56x56/e5e7eb/6b7280?text=U' }}"
                            alt="{{ $item->name }}"
                            class="review-avatar">
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size:.85rem;">{{ $item->name }}</h4>
                            <div class="d-flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star" style="font-size:.8rem; color:{{ $i <= $item->star ? '#facc15' : '#d1d5db' }};"></i>
                                @endfor
                            </div>
                        </div>
                    </div>

                    {{-- Review Text --}}
                    <div class="review-text-box">
                        <p class="text-secondary mb-0" style="font-size:.75rem; line-height:1.6;">{{ $item->review_text }}</p>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="fas fa-star mb-3" style="font-size:2.5rem; opacity:.3;"></i>
            <p class="fs-6 mb-0">No reviews yet.</p>
        </div>
        @endif

    </div>
</section>