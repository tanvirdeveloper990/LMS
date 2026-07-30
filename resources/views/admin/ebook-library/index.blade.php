@extends('admin.layouts.app')

@section('title', 'Ebook Library Section')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Ebook Library Section Settings</h4>
        </div>



        <form action="{{ route('admin.ebook-library.update', $ebookLibrary->id ?? 1) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ── Basic Info ─────────────────────────────── -->
            <div class="card mb-4">
                <div class="card-header"><strong>Basic Info</strong></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Badge Text</label>
                        <input type="text" name="badge_text" class="form-control"
                            value="{{ old('badge_text', $ebookLibrary->badge_text ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title Line 1</label>
                        <input type="text" name="title_1" class="form-control"
                            value="{{ old('title_1', $ebookLibrary->title_1 ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title Line 2</label>
                        <input type="text" name="title_2" class="form-control"
                            value="{{ old('title_2', $ebookLibrary->title_2 ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $ebookLibrary->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- ── Main Image ─────────────────────────────── -->
            <div class="card mb-4">
                <div class="card-header"><strong>Main Image</strong></div>
                <div class="card-body">
                    @if (!empty($ebookLibrary->image))
                        <img src="{{ asset('storage/' . $ebookLibrary->image) }}" width="150"
                            class="mb-2 d-block rounded">
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

            <!-- ── Cards ─────────────────────────────── -->
            <div class="row">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header"><strong>Card {{ $i }}</strong></div>
                            <div class="card-body">
                                @if (!empty($ebookLibrary->{"card{$i}_image"}))
                                    <img src="{{ asset('storage/' . $ebookLibrary->{"card{$i}_image"}) }}" width="120"
                                        class="mb-2 d-block rounded">
                                @endif
                                <div class="mb-3">
                                    <label class="form-label">Card {{ $i }} Image</label>
                                    <input type="file" name="card{{ $i }}_image" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Card {{ $i }} Title</label>
                                    <input type="text" name="card{{ $i }}_title" class="form-control"
                                        value="{{ old("card{$i}_title", $ebookLibrary->{"card{$i}_title"} ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Card {{ $i }} Subtitle</label>
                                    <input type="text" name="card{{ $i }}_subtitle" class="form-control"
                                        value="{{ old("card{$i}_subtitle", $ebookLibrary->{"card{$i}_subtitle"} ?? '') }}">
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
