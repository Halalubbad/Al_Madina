@extends('admin.starter')

@section('route', route('products.index'))
@section('title', __('almadina.products'))
@section('page-lg-title', __('almadina.add_product'))
@section('main-pg-title', __('almadina.products'))
@section('page-md-title', __('almadina.add_product'))

@section('styles')
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('almadina.add_product') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- enctype="multipart/form-data" --}}
                        <form id="create_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="product_name">{{ __('almadina.product_name') }}</label>
                                    <input type="text" class="form-control" id="product_name"
                                        placeholder="{{ __('almadina.product_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="price">{{ __('almadina.price') }}</label>
                                    <input type="text" class="form-control" id="price"
                                        placeholder="{{ __('almadina.price') }}">
                                </div>
                                <div class="form-group">
                                    <label for="product_ingredients">{{ __('almadina.product_ingredients') }}</label>
                                    <textarea id="product_ingredients" class="form-control" rows="3"
                                        placeholder="{{ __('almadina.product_ingredients') }}"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('almadina.brand') }}</label>
                                    <select class="form-control" id="brand_id">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="form-group">
                                    <label>{{ __('almadina.tags') }}</label>
                                    <select class="form-control" id="tag_id">
                                    </select>
                                </div> --}}

                                <div class="form-group">
                                    <label for="image">{{ __('almadina.image') }}</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image">
                                            <label class="custom-file-label"
                                                for="image">{{ __('almadina.choose_file') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="performStore()"
                                    class="btn btn-primary">{{ __('almadina.save') }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init()
        });
    </script>

    <script>
        // $('#parent_id').on('change', function() {
        //     // alert('value : '+this.value);
        //     getTags(this.value);
        // });

        // function getTags(tagId) {
        //     axios.get('/almadina/admin/tags/' + tagId)
        //         .then(function(response) {
        //             console.log(response);
        //             console.log(response.data.data);
        //             $('#tag_id').empty();
        //             $.each(response.data.data, function(i, item) {
        //                 $('#tag_id').append(new Option(item['name'], item['id']));
        //             });
        //         })
        //         .catch(function(error) {
        //             console.log(error);

        //         });
        // }

        function performStore() {
            var formData = new FormData();
            formData.append('image', document.getElementById('image').files[0]);
            formData.append('product_name', document.getElementById('product_name').value);
            formData.append('price', document.getElementById('price').value);
            formData.append('product_ingredients', document.getElementById('product_ingredients').value);
            formData.append('brand_id', document.getElementById('brand_id').value);

            axios.post('/almadina/admin/products', formData)
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    document.getElementById('create_form').reset();
                })
                .catch(function(error) {
                    console.log(error);
                    toastr.error(error.response.data.message);

                });
        }
    </script>

@endsection
