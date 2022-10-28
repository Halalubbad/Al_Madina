@extends('admin.starter')

@section('route', route('products.index'))
@section('title', __('almadina.product_tag'))
@section('page-lg-title', __('almadina.add_tag_to_product'))
@section('main-pg-title', __('almadina.products'))
@section('page-md-title', __('almadina.add_tag_to_product'))

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
                            <h3 class="card-title">{{ __('almadina.add_tag_to_product') }} {{$product[0]->name}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- enctype="multipart/form-data" --}}
                        <?php 
                            // dd($product_name)
                            
                        ?>
                        {{-- {{dd($tags[0])}} --}}
                        <form id="create_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="product_name">{{ __('almadina.product_name') }}</label>
                                    <input type="text" class="form-control" id="product"
                                        value=" {{$product[0]->name }} " readonly>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('almadina.trademarks') }}</label>
                                    <select class="form-control" id="parent_idR">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('almadina.tags') }}</label>
                                    <select class="form-control" id="tag_id">
                                    </select>
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
        $('#parent_idR').on('change', function() {
            // alert('value : '+this.value);
            getTags(this.value);
        });

        function getTags(tagId) {
            axios.get('/almadina/admin/tags/' + tagId)
                .then(function(response) {
                    console.log(response);
                    console.log(response.data.data);
                    $('#tag_id').empty();
                    $.each(response.data.data, function(i, item) {
                        $('#tag_id').append(new Option(item['name'], item['id']));
                    });
                })
                .catch(function(error) {
                    console.log(error);

                });
        }

        function performStore() {
            var formData = new FormData();
            formData.append('tag_id', document.getElementById('tag_id').value);
            formData.append('parent_idR', document.getElementById('parent_idR').value);
            formData.append('product', document.getElementById('product').value);

            axios.post('/almadina/admin/product_tags', formData)
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
