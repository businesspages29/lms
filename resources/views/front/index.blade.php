@extends('layouts.front')
@section('content')
    <div class="container mt-2">
        @auth
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    {{ __('Add Product') }}
                </a>
            </div>
        @endauth
        <div class="row">
            <div class="col-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-12 col-md-4 col-lg-4 mt-3">
                            <div class="card">
                                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                </div>
                                @php
                                    $variants = $product->variants;
                                @endphp
                                @if (count($variants) > 0)
                                    <div class="card-footer">
                                        @foreach ($variants as $variant)
                                            <div class="d-flex justify-content-between">
                                                <div>{{ $variant->name }}</div>
                                                <div class="d-flex justify-content-between g-2"><span>Rs.
                                                        {{ $variant->price }}
                                                    </span><span class="ms-2"><del>Rs.
                                                            {{ $variant->offer_price }}</del></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @auth
        <x-modals.product-modal />
        <x-modals.product-variant-modal />
    @endauth
@endsection
