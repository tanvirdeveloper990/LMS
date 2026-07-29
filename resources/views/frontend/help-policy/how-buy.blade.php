@extends('layouts.app')
@section('title', 'How To Buy')
@section('content')

<style>
    :root {
        --brand-red:   #FF0000;
        --brand-black: #000000;
        --brand-white: #ffffff;
    }

    body { background: #f7f7f8; }

    .htb-title-bar {
        width: 70px;
        height: 4px;
        background: var(--brand-red);
        margin: 16px auto 0;
        border-radius: 999px;
    }

    /* ── Visual step icons ── */
    .htb-step-visual {
        text-align: center;
    }
    .htb-step-visual-img-wrap {
        margin-bottom: 12px;
    }
    .htb-step-visual-img-wrap img {
        width: 100%;
        height: 96px;
        object-fit: contain;
    }
    .htb-step-visual-label {
        font-size: .9rem;
        font-weight: 700;
        color: var(--brand-black);
        margin: 0;
    }
    .htb-step-dots {
        display: none;
        align-items: center;
        justify-content: center;
        color: #d1d5db;
        font-size: 1.3rem;
        letter-spacing: 2px;
    }
    @media (min-width: 992px) {
        .htb-step-dots { display: flex; }
    }

    /* ── Detailed instructions card ── */
    .htb-detail-card {
        background: var(--brand-white);
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
        padding: 2rem;
    }
    @media (min-width: 768px) {
        .htb-detail-card { padding: 3rem; }
    }

    .htb-step-row {
        display: flex;
        gap: 1rem;
    }
    .htb-step-row:not(:last-child) {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px dashed #eee;
    }
    .htb-step-number {
        flex-shrink: 0;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: var(--brand-red);
        color: var(--brand-white);
        font-weight: 700;
        font-size: .9rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .htb-step-text {
        color: #374151;
        line-height: 1.7;
        padding-top: 4px;
        margin: 0;
    }

    .htb-empty-state {
        text-align: center;
        color: #9ca3af;
        padding: 2.5rem 0;
    }
    .htb-empty-state i {
        font-size: 2rem;
        margin-bottom: .75rem;
        display: block;
        color: #d1d5db;
    }
</style>

<main>
    <section class="container py-5">

        <!-- Page Title -->
        <div class="text-center mb-5">
            <h1 class="fw-bold display-6 display-md-4 text-dark mb-2">How To Order</h1>
            <div class="htb-title-bar"></div>
        </div>

        <!-- Steps Visual Guide (Images) -->
        @if($data->whereNotNull('image')->count())
        <div class="mx-auto mb-5" style="max-width:1100px;">
            <div class="row g-4 align-items-center justify-content-center">
                @foreach($data as $index => $item)
                    @if($item->image)
                    <div class="col-6 col-md-4 col-lg-{{ $data->count() > 0 ? intdiv(12, min($data->count(), 6)) : 3 }}">
                        <div class="htb-step-visual">
                            <div class="htb-step-visual-img-wrap">
                                <img src="{{ Storage::url($item->image) }}" alt="Step {{ $index + 1 }}">
                            </div>
                            <p class="htb-step-visual-label">
                                {{ $index + 1 }}. {{ $item->text }}
                            </p>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Detailed Instructions -->
        <div class="mx-auto htb-detail-card" style="max-width:900px;">
            @forelse($data as $index => $item)
            <div class="htb-step-row">
                <div class="htb-step-number">
                    {{ $index + 1 }}
                </div>
                <p class="htb-step-text">
                    {{ $item->text }}
                </p>
            </div>
            @empty
            <div class="htb-empty-state">
                <i class="fas fa-info-circle"></i>
                <p class="mb-0">No instructions available yet.</p>
            </div>
            @endforelse
        </div>

    </section>
</main>
@endsection