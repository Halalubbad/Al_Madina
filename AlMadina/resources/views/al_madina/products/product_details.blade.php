
<div class="modal custom-modal custom-modal-product fade bd-example-modal-lg" id="product_details" tabindex="-1"
    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h2>تفاصيل المنتج</h2>
                <form>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card product-card">
                                <figure class="card-img-top">
                                    <img src="{{ url(Storage::url($show->image ?? '')) }}" alt="Card image cap">
                                    {{-- <span>‏330 مل</span> --}}
                                    <span>‏

                                        @foreach ($show->tags->where('parent_id', $sizeTagType->id) as $tag)
                                            {{ $tag->name }}
                                        @endforeach

                                    </span>
                                </figure>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="title">
                                {{ $show->brand->name }}
                            </div>
                            <div class="subtitle">
                                {{ $show->name }}
                            </div>
                            <div class="mokawenat">
                                <h5>مكونات المنتج</h5>
                                <p> {{ $show->product_ingredients }} </p>
                            </div>
                            <div class="value">
                                <h5>القيمة الغذائية للمنتج</h5>
                                <ul>
                                    <li>
                                        <span class="type">طاقة (س,ح): </span>
                                        <span class="number">{{ $show->nutritionalValues[0]->energy }}</span>
                                    </li>
                                    <li>
                                        <span class="type">دهنيات (غ): </span>
                                        <span class="number">{{ $show->nutritionalValues[0]->fatty }}</span>
                                    </li>
                                    <li>
                                        <span class="type">بروتينات (غ): </span>
                                        <span class="number">{{ $show->nutritionalValues[0]->proteins }}</span>
                                    </li>
                                    <li>
                                        <span class="type">كربوهيدرات (غ): </span>
                                        <span class="number">{{ $show->nutritionalValues[0]->carbohydrates }}</span>
                                    </li>
                                    <li>
                                        <span class="type">فيتامين سي (ملغم): </span>
                                        <span class="number">{{ $show->nutritionalValues[0]->vitaminC }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="d-flex price">
                                <h5>السعر: </h5>
                                <p>{{ $show->price }} {{ __('almadina.shekel_ar') }}</p>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
