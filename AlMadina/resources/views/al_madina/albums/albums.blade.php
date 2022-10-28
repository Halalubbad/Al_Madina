@extends('al_madina.parent')

@section('home_active', '@@home')
@section('about_active', '@@about')
@section('products_active', '@@products')
@section('offers_active', '@@offers')
@section('albums_active', 'active')
@section('contact_active', '@@contact')
@section('news_active', '@@news')

@section('content')


    <div class="albums-page bubbles">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb official ">
                    <li class="breadcrumb-item"><a href="{{ route('almadina.home') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">الألبومات</li>
                </ol>
            </nav>
        </div>
        @foreach ($albums as $album)
            {{-- @dd($album->album_images()) --}}
            <div class="album-section wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                <div class="container">
                    <h2>{{$album->title}}</h2>
                    <p>{{$album->text}}</p>
                    <div class="row">
                        <div class="col-lg-12">
                            <figure class="album-img" data-fancybox="gallery"
                                href="{{ Storage::url($album->video ?? '') }}">
                                <img src="{{ Storage::url($album->album_images[0]->image ?? '') }}" alt=""
                                    class="img-fluid" srcset="">
                                <div class="play">
                                    <i class="fa fa-play" aria-hidden="true"></i>
                                </div>
                            </figure>
                        </div>
                        {{-- {{dd($album_images_count)}} --}}
                        @php
                            $images = $album->album_images->filter(function ($value, $key) {
                                return $value->image != null;
                            });
                        @endphp
                        {{-- @dd($album->getKey()) --}}
                        @foreach ($images as $Eimage)
                            {{-- {{$loop->iteration}} --}}
                            @if ($loop->iteration < 4)
                                @if ($Eimage->image)
                                    <div class="col-lg-4 col-6">
                                        <figure @if (count($images) > 3 && $loop->iteration == 3) class="more-imgs" @endif
                                            data-fancybox="gallery-{{ $album->getKey() }}"
                                            href="{{ Storage::url($Eimage->image ?? '') }}">

                                            <img src="{{ Storage::url($Eimage->image ?? '') }}" alt=""
                                                class="img-fluid" srcset=""
                                                data-fancybox="gallery-{{ $album->getKey() }}">
                                            @if (count($images) > 3 && $loop->iteration == 3)
                                                <span>+{{ count($images) - 3 }}</span>
                                            @endif

                                        </figure>
                                    </div>
                                @endif
                            @else
                                @push('more-image')
                                    @if ($Eimage->image)
                                        <img src="{{ url(Storage::url($Eimage->image ?? '')) }}" alt=""
                                            class="img-fluid" srcset="" data-fancybox="gallery-{{ $album->getKey() }}">
                                    @endif
                                @endpush
                            @endif
                        @endforeach

                        <div style="display:none;">
                            @stack('more-image')
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
