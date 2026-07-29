@extends('layouts.app')
@section('title', \App\Helpers\TranslateHelper::translate('Our Showrooms'))
@section('content')

<style>
    .showrooms-page-section { padding: 40px 0 60px; background: #f7f7f8; }
    .showrooms-page-title { font-weight: 800; font-size: 1.6rem; margin-bottom: 24px; text-align: center; }
    .showroom-page-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 22px;
    }
    .showroom-page-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        border: 1px solid #f1f1f1;
        transition: box-shadow .25s ease, transform .25s ease;
        display: block;
        color: inherit;
        text-decoration: none;
    }
    .showroom-page-card:hover {
        box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        transform: translateY(-3px);
        color: inherit;
    }
    .showroom-page-img-wrap {
        width: 100%;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: #f3f4f6;
    }
    .showroom-page-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }
    .showroom-page-card:hover .showroom-page-img-wrap img {
        transform: scale(1.06);
    }
    .showroom-page-body {
        padding: 14px 16px;
    }
    .showroom-page-name {
        font-weight: 700;
        font-size: .95rem;
        color: #1c1c1c;
        margin: 0;
    }
</style>

<section class="showrooms-page-section">
    <div class="container">
        <h1 class="showrooms-page-title">{{ \App\Helpers\TranslateHelper::translate('আমাদের শোরুম সমূহ') }}</h1>

        @if($showrooms->isEmpty())
            <p class="text-center text-muted">No showrooms found.</p>
        @else
            <div class="showroom-page-grid">
                @foreach($showrooms as $showroom)
                <a href="{{ route('showroom.detail', $showroom->id) }}" class="showroom-page-card">
                    <div class="showroom-page-img-wrap">
                        @if($showroom->image)
                            <img src="{{ Storage::url($showroom->image) }}" alt="{{ $showroom->name }}">
                        @else
                            <img src="https://placehold.co/400x300/1c1c1c/ffffff?text={{ urlencode($showroom->name) }}" alt="{{ $showroom->name }}">
                        @endif
                    </div>
                    <div class="showroom-page-body">
                        <p class="showroom-page-name">{{ $showroom->name }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection