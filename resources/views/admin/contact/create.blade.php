@extends('admin.layouts.app')

@section('title', 'Update Contacts')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" >

            <!-- Header -->
            <div class="card-header text-white d-flex justify-content-between align-items-center bg-gradient-purple">
                <h5 class="mb-0">Update Contacts</h5>

                @can('view user')
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
                @endcan
            </div>

            <!-- Form Body -->
            <div class="card-body">
                <form method="POST" action="{{route('admin.contacts.store')}}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="row g-3">

                        <!-- FULL NAME -->
                        <div class="col-md-6">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name')}}" class="form-control" required>
                        </div>

                        <!-- EMAIL -->
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email')}}" class="form-control" required>
                        </div>

                        <!-- PHONE -->
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone')}}" class="form-control">
                        </div>

                      <!-- subject -->
                    <div class="col-md-6">
                        <label class="form-label">Subject</label>
                        <textarea name="subject" class="form-control" rows="2" required>{{ old('subject')}}</textarea>
                    </div>

                    <!-- message -->
                    <div class="col-md-6">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="2" required>{{ old('message')}}</textarea>
                    </div>


                       

                       

                     
                        <!-- STATUS -->
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="text-end pt-4 mt-3 border-top">
                        <button type="submit" class="btn text-white px-4 bg-gradient-purple">
                            <i class="fa fa-save me-1"></i> Update
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>
@endsection
