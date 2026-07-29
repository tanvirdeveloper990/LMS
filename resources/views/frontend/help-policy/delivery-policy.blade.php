@extends('layouts.app')
@section('title', 'Delivery Policy')

@section('content')

<section class="py-5 px-6 mx-6 my-6">
    <div class="container">
        <div class="justify-content-center">

             <div class="summernote-content">
                {!! $data->delivery_policy !!}
            </div>

           
        </div>
    </div>
</section>

@endsection
