@extends('admin.starter')

@section('route', route('products.index'))
@section('title', __('almadina.product_tags'))
@section('page-lg-title', __('almadina.edit_product_tag'))
@section('main-pg-title', __('almadina.product'))
@section('page-md-title', __('almadina.edit_product_tag'))

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
                            <h3 class="card-title">{{ __('almadina.update_product_tag') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="product_name">{{ __('almadina.product_name') }}</label>
                                    <input type="text" class="form-control" id="product_name"
                                        value=" {{ $productTag->product->name }} " readonly>
                                </div>
                                <div class="form-group">
                                    <label for="parent_id">{{ __('almadina.trademarks') }}</label>
                                    <input type="text" class="form-control" id="parent_id"
                                        value=" {{$parent[0]->name }} " readonly>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('almadina.tags') }}</label>
                                    <select class="form-control" id="tag_id">
                                        @foreach ($allTags as $tag)
                                            <option @if ($tag->id == $productTag->tag_id) selected @endif value=" {{$tag->id}} "> {{$tag->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" onclick="performUpdate('{{ $productTag->id }}')"
                                    class="btn btn-primary">{{ __('almadina.update') }}</button>
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
    <script>
        function performUpdate(id) {
            axios.put('/almadina/admin/product_tags/{{$productTag->id}}' , {
                    tag_id: document.getElementById('tag_id').value,
                    product_name: document.getElementById('product_name').value,
                    parent_id: document.getElementById('parent_id').value,
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    window.location.href = '/almadina/admin/product_tags'
                })
                .catch(function(error) {
                    console.log(error.response);
                    toastr.error(error.response.data.message);
                });
        }
    </script>

@endsection
