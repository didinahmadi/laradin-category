@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
        @component('laradin-category::category._form', [
            'method'       => 'POST',
            'urlBack'      => laradin_route('index'),
            'urlAction'    => laradin_route('store'),
            'categoryList' => $categoryList,
            'model'        => null
        ])
        @endcomponent

        </div>
    </div>
</div>
@endsection
