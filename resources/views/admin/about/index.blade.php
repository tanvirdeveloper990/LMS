@extends('admin.layouts.app')

@section('title', 'About Section')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">About Section Settings</h4>
        </div>



        <form action="{{ route('admin.about.update', $about->id ?? 1) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ── Basic Info ─────────────────────────────── -->
            <div class="card mb-4">
                <div class="card-header"><strong>Basic Info</strong></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Badge Text</label>
                        <input type="text" name="badge_text" class="form-control"
                            value="{{ old('badge_text', $about->badge_text ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title Line 1</label>
                        <input type="text" name="title_1" class="form-control"
                            value="{{ old('title_1', $about->title_1 ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title Line 2</label>
                        <input type="text" name="title_2" class="form-control"
                            value="{{ old('title_2', $about->title_2 ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $about->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- ── Main Image ─────────────────────────────── -->
            <div class="card mb-4">
                <div class="card-header"><strong>Main Image</strong></div>
                <div class="card-body">
                    @if (!empty($about->image))
                        <img src="{{ asset('storage/' . $about->image) }}" width="150" class="mb-2 d-block rounded">
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

            <!-- ── Badge ─────────────────────────────── -->
            <div class="card mb-4">
                <div class="card-header"><strong>Badge</strong></div>
                <div class="card-body">
                    @if (!empty($about->badge_image))
                        <img src="{{ asset('storage/' . $about->badge_image) }}" width="80" class="mb-2 d-block rounded">
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Badge Image</label>
                        <input type="file" name="badge_image" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Badge Title</label>
                        <input type="text" name="badge_title" class="form-control"
                            value="{{ old('badge_title', $about->badge_title ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Badge Subtitle</label>
                        <input type="text" name="badge_subtitle" class="form-control"
                            value="{{ old('badge_subtitle', $about->badge_subtitle ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- ── Cards ─────────────────────────────── -->
            <div class="row">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header"><strong>Card {{ $i }}</strong></div>
                            <div class="card-body">
                                @if (!empty($about->{"card{$i}_image"}))
                                    <img src="{{ asset('storage/' . $about->{"card{$i}_image"}) }}" width="120"
                                        class="mb-2 d-block rounded">
                                @endif
                                <div class="mb-3">
                                    <label class="form-label">Card {{ $i }} Image</label>
                                    <input type="file" name="card{{ $i }}_image" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Card {{ $i }} Title</label>
                                    <input type="text" name="card{{ $i }}_title" class="form-control"
                                        value="{{ old("card{$i}_title", $about->{"card{$i}_title"} ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Card {{ $i }} Subtitle</label>
                                    <input type="text" name="card{{ $i }}_subtitle" class="form-control"
                                        value="{{ old("card{$i}_subtitle", $about->{"card{$i}_subtitle"} ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <button type="submit" class="btn btn-dark px-4">Updete</button>
        </form>

    </div>
@endsection
