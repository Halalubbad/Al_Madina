@if ($products->isEmpty()){
    {{-- @dd('ddddd') --}}
    
}   
@endif
@forelse($products as $product)
{{-- @dd($products) --}}
    <div class="col-lg-4 col-md-6">
        <div class="position-relative">
            <a href="#" class="product-link" data-id="{{ $product->id }}">
        </div>

        <div class="card product-card  wow fadeInUp" data-target=".product_details" data-wow-duration="1s"
            data-wow-delay="0.2s">
            <figure class="card-img-top">
                <img src="{{ url(Storage::url($product->image ?? '')) }}" alt="Card image cap">
                <span>
                    @foreach ($product->tags->where('parent_id',  $sizeTagType->id) as $tag)
                        {{ $tag->name }}
                    @endforeach
                </span>
            </figure>
            <div class="card-body">
                <h5 class="card-title">{{ $product->brand->name }}</h5>
                <p class="card-text"> {{ $product->name }}</p>
            </div>
        </div>
        </a>
    </div>

@empty
    <?php
        $message = "There no product with this tag"
    ?>
    {{$message}}
@endforelse
