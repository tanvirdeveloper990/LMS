@extends('admin.layouts.app')

@section('title', 'Update Seller Commision')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 1200px; overflow: hidden;">

            <div class="card-header bg-gradient-purple">
                <div class="d-flex justify-content-between align-items-center text-white">
                    <h5 class="mb-0 fw-semibold">Update Seller Commision</h5>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.seller-commision.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-4">

                        {{-- Main Section --}}
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" value="{{ old('title',$data->title) }}" class="form-control">
                        </div>

                       {{-- List Fields --}}
                        <div class="col-md-6">
                            <label class="form-label">List One</label>
                            <input type="text" name="list_1" value="{{ old('list_1', $data->list_1) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Two</label>
                            <input type="text" name="list_2" value="{{ old('list_2', $data->list_2) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Three</label>
                            <input type="text" name="list_3" value="{{ old('list_3', $data->list_3) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Four</label>
                            <input type="text" name="list_4" value="{{ old('list_4', $data->list_4) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Five</label>
                            <input type="text" name="list_5" value="{{ old('list_5', $data->list_5) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Six</label>
                            <input type="text" name="list_6" value="{{ old('list_6', $data->list_6) }}" class="form-control">
                        </div>

                         {{-- Our Work Section --}}
                        <div class="col-md-6">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="button_text" value="{{ old('button_text', $data->button_text) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Button Link</label>
                            <input type="text" name="button_link" value="{{ old('button_link', $data->button_link) }}" class="form-control">
                        </div>

                      
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">

                            @if($data->image)
                                <img src="{{Storage::url($data->image) }}" 
                                    class="mt-2 rounded" width="120">
                            @endif
                        </div>
                </div>

                    <div class="border-top pt-3 text-end">
                        <button type="submit" class="btn text-white bg-gradient-purple">
                            <i class="fa fa-edit me-1"></i> Update
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>
@endsection
