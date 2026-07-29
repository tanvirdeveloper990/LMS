
@extends('layouts.app')
@section('title', 'Return Policy')

@section('content')

<section class="py-5 px-6 mx-6 my-6">
    <div class="container">
        <div class="justify-content-center">

             <div class="summernote-content">
               {!! $data->return_policy !!}
            </div>

           
        </div>
    </div>
</section>

@endsection


