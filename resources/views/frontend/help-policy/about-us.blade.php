
@extends('layouts.app')
@section('title', 'About Us')

@section('content')

<section class="py-5 px-6 mx-6 my-6">
    <div class="container">
        <div class="justify-content-center">

             <div class="summernote-content">
               {!! $data->about_us !!}
            </div>

           
        </div>
    </div>
</section>

@endsection

