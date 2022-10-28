@extends('admin.starter')

@section('title', __('almadina.products'))
@section('page-lg-title', __('almadina.products'))
@section('main-pg-title', __('almadina.home'))
@section('page-md-title', __('almadina.products'))

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            {{-- {{ __('almadina.product') }} --}}
                            <h3 class="card-title">details of {{ $product[0]->name }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="create_form">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <img height="100" src="{{ Storage::url($product[0]->image ?? '') }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="product_name">{{ __('almadina.product_name') }}</label>
                                        <input type="text" value="{{ $product[0]->name }}" class="form-control"
                                            id="product_name" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">{{ __('almadina.price') }}</label>
                                        <input type="text" value="{{ $product[0]->price }}" class="form-control"
                                            id="price" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_ingredients">{{ __('almadina.product_ingredients') }}</label>
                                        <textarea id="product_ingredients" class="form-control" rows="3"
                                             readonly>{{ $product[0]->product_ingredients }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="brand">{{ __('almadina.brand') }}</label>
                                        <input type="text" value="{{ $product[0]->brand->name }}" class="form-control"
                                            id="brand" readonly>
                                    </div>

                                    {{-- tags --}}
                                    <label for="tag">{{ __('almadina.tags') }}</label>
                                    @foreach ($product[0]->tags as $tag)
                                        <div class="form-group">
                                            <input type="text" value="{{ $tag->name }}" class="form-control"
                                                id="tag" readonly>
                                        </div>
                                    @endforeach

                                    {{-- nutritionalValues --}}
                                    <div class="form-group">
                                        <label for="energy">{{ __('almadina.energy') }}</label>
                                        <input type="text" value="{{ $product[0]->nutritionalValues[0]->energy }}" class="form-control"
                                            id="energy" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="fatty">{{ __('almadina.fatty') }}</label>
                                        <input type="text" value="{{ $product[0]->nutritionalValues[0]->fatty }}" class="form-control"
                                            id="fatty" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="proteins">{{ __('almadina.proteins') }}</label>
                                        <input type="text" value="{{ $product[0]->nutritionalValues[0]->proteins }}" class="form-control"
                                            id="proteins" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="carbohydrates">{{ __('almadina.carbohydrates') }}</label>
                                        <input type="text" value="{{ $product[0]->nutritionalValues[0]->carbohydrates }}" class="form-control"
                                            id="carbohydrates" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="vitaminC">{{ __('almadina.vitaminC') }}</label>
                                        <input type="text" value="{{ $product[0]->nutritionalValues[0]->vitaminC }}" class="form-control"
                                            id="vitaminC" readonly>
                                    </div>
                                    {{-- @foreach ($product[0]->nutritionalValues as $nutritionalValue)
                                        <label for="nutritionalValue"></label>
                                        <div class="form-group">
                                            <input type="text" value="{{ $nutritionalValue->energy }}" class="form-control"
                                                id="tag" placeholder="{{ __('almadina.tag') }}" readonly>
                                        </div>
                                    @endforeach --}}




                                </div>
                                <!-- /.card-body -->

                                {{-- <div class="card-footer">
                                    <button type="button" onclick="performStore()"
                                        class="btn btn-primary">{{ __('almadina.save') }}</button>
                                </div> --}}
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')

@endsection
