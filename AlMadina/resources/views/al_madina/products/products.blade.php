@extends('al_madina.parent')

@section('home_active', '@@home')
@section('about_active', '@@about')
@section('products_active', 'active')
@section('offers_active', '@@offers')
@section('albums_active', '@@albums')
@section('contact_active', '@@contact')
@section('news_active', '@@news')

@section('content')

    <div class="products bubbles">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb official ">
                    <li class="breadcrumb-item"><a href="{{ route('almadina.home') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">المنتجات</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-lg-3">
                    <div class="filters">
                        <div>
                            <div class="top">
                                <p>Brand</p>
                                <span class="filter hide">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20">
                                        <g id="Group_52884" data-name="Group 52884" transform="translate(-29 -1130.5)">
                                            <path id="Path_30683" data-name="Path 30683"
                                                d="M10,0A10,10,0,1,1,0,10,10,10,0,0,1,10,0Z"
                                                transform="translate(29 1130.5)" fill="#8ec641" />
                                            <path id="Path"
                                                d="M9.286,1.5H.714A.734.734,0,0,1,0,.75.734.734,0,0,1,.714,0H9.286A.734.734,0,0,1,10,.75.734.734,0,0,1,9.286,1.5Z"
                                                transform="translate(34 1140)" fill="#fff" />
                                        </g>
                                    </svg>
                                </span>
                                <span class="filter show">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20">
                                        <g id="Group_52877" data-name="Group 52877" transform="translate(-29 -1130.5)">
                                            <path id="Path_30683" data-name="Path 30683"
                                                d="M10,0A10,10,0,1,1,0,10,10,10,0,0,1,10,0Z"
                                                transform="translate(29 1130.5)" fill="#8ec641" />
                                            <path id="Path"
                                                d="M9.286,5.714H5.714V9.286a.714.714,0,1,1-1.429,0V5.714H.714a.714.714,0,1,1,0-1.429H4.286V.714a.714.714,0,1,1,1.429,0V4.286H9.286a.714.714,0,1,1,0,1.429Z"
                                                transform="translate(34 1135.856)" fill="#fff" />
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <div class="bottom">
                                @foreach ($allBrands as $brand)
                                    <label class="custom-checkbox">
                                        <input type="checkbox" class="filter-product" value="{{ $brand->id }}"
                                            id="brand" name="brand">
                                        {{-- data-brand="{{ $brand->name }}" data-name="{{ $brand->name }}" id="brandId" data-id="{{ $brand->id }}"> --}}
                                        <span class="checkmark"></span>
                                        <span class='label'>{{ $brand->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            @foreach ($parents as $parent)
                                <div class="top">
                                    <p>{{ $parent->name }}</p>
                                    {{-- <span class="filter hide">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20">
                                            <g id="Group_52884" data-name="Group 52884" transform="translate(-29 -1130.5)">
                                                <path id="Path_30683" data-name="Path 30683"
                                                    d="M10,0A10,10,0,1,1,0,10,10,10,0,0,1,10,0Z"
                                                    transform="translate(29 1130.5)" fill="#8ec641" />
                                                <path id="Path"
                                                    d="M9.286,1.5H.714A.734.734,0,0,1,0,.75.734.734,0,0,1,.714,0H9.286A.734.734,0,0,1,10,.75.734.734,0,0,1,9.286,1.5Z"
                                                    transform="translate(34 1140)" fill="#fff" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="filter show">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20">
                                            <g id="Group_52877" data-name="Group 52877" transform="translate(-29 -1130.5)">
                                                <path id="Path_30683" data-name="Path 30683"
                                                    d="M10,0A10,10,0,1,1,0,10,10,10,0,0,1,10,0Z"
                                                    transform="translate(29 1130.5)" fill="#8ec641" />
                                                <path id="Path"
                                                    d="M9.286,5.714H5.714V9.286a.714.714,0,1,1-1.429,0V5.714H.714a.714.714,0,1,1,0-1.429H4.286V.714a.714.714,0,1,1,1.429,0V4.286H9.286a.714.714,0,1,1,0,1.429Z"
                                                    transform="translate(34 1135.856)" fill="#fff" />
                                            </g>
                                        </svg>
                                    </span> --}}
                                </div>
                                <div class="bottom">
                                    @if ($parent->name == 'color')
                                        @foreach ($colorTag as $color)
                                            @foreach ($color->childs as $child)
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="filter-product" id="color"
                                                        name="color" value="{{ $child->id }}">
                                                    <span class="checkmark"></span>
                                                    <span class='label'> {{ $child->name }}</span>
                                                </label>
                                            @endforeach
                                        @endforeach
                                    @elseif ($parent->name == 'size')
                                        @foreach ($sizeTag as $color)
                                            @foreach ($color->childs as $child)
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="filter-product" id="size"
                                                        name="size" value="{{ $child->id }}">
                                                    <span class="checkmark"></span>
                                                    <span class='label'> {{ $child->name }}</span>
                                                </label>
                                            @endforeach
                                        @endforeach
                                    @elseif ($parent->name == 'Taste')
                                        @foreach ($tasteTag as $color)
                                            @foreach ($color->childs as $child)
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="filter-product" id="taste"
                                                        name="taste" value="{{ $child->id }}">
                                                    <span class="checkmark"></span>
                                                    <span class='label'> {{ $child->name }}</span>
                                                </label>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 mt-lg-0 mt-3">
                    <div class="row" id="updateDiv">
                        @include('al_madina.products.product_filter')

                        {{-- ********** --}}

                    </div>
                    {{-- <div class="mx-auto mt-5">
                        <nav class="custom-pagination">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fa fa-chevron-right"
                                                aria-hidden="true"></i></span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true"><i class="fa fa-chevron-left"
                                                aria-hidden="true"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div> --}}
                    <div class="row">
                        <div class="mx-auto mt-5" id="pagination-div">
                            <nav class="custom-pagination">
                                {{ $products->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- product details --}}
    <div class="modal-container">
        {{-- show product details modal --}}
    </div>

@endsection

@section('scripts')
    <script>
        $(document).on('click', '.product-link', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('show-product') }}",
                type: "get",
                data: {
                    id: id
                },
                success: function(data) {
                    $('.modal-container').html(data.view);
                    $('#product_details').modal('show');
                },

            });
        })
    </script>

    <script>
        var getfilters = function(brand, size, color, taste) {
            // console.log(brand);
            $.ajax({
                type: 'GET',
                url: "{{ route('filter-product') }}",
                data: {
                    brand: brand,
                    size: size,
                    color: color,
                    taste: taste,
                },
                error: function(e) {
                    console.log(e.responseText);
                },
                success: function(data) {
                    console.log(data);
                    $('#updateDiv').html(data.view)
                }
            });
        };

        $(document).ready(function() {
            $('input[type="checkbox"]').on('change', function(event) {
                event.preventDefault();
                var brand = [];
                var size = [];
                var color = [];
                var taste = [];
                $.each($("input[name='brand']:checked"), function() {
                    brand.push($(this).val());
                });
                $.each($("input[name='size']:checked"), function() {
                    size.push($(this).val());
                });
                $.each($("input[name='color']:checked"), function() {
                    color.push($(this).val());
                });
                $.each($("input[name='taste']:checked"), function() {
                    taste.push($(this).val());
                });
                
                // console.log(brand);
                // console.log(size);
                // console.log(color);
                // console.log(taste);

                // $('#updateDiv').html();
                getfilters(brand, size, color, taste);
            });
        });
    </script>

@endsection
