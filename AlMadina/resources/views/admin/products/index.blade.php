@extends('admin.starter')

@section('title', __('almadina.products'))
@section('page-lg-title', __('almadina.our_products'))
@section('main-pg-title', __('almadina.home'))
@section('page-md-title', __('almadina.our_products'))

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('almadina.products') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('almadina.image') }}</th>
                                        <th>{{ __('almadina.product_name') }}</th>
                                        {{-- <th>{{ __('almadina.brand') }}</th> --}}
                                        <th>{{ __('almadina.details') }}</th>
                                        {{-- <th>{{ __('almadina.price') }}</th>
                                        <th>{{ __('almadina.product_ingredients') }}</th> --}}
                                        <th>{{ __('almadina.nutritionalValues') }}</th>
                                        <th>{{ __('almadina.tags') }}</th>
                                        {{-- <th>{{ __('almadina.created_at') }}</th>
                                        <th>{{ __('almadina.updated_at') }}</th> --}}
                                        <th style="width: 40px">{{ __('almadina.settings') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                <img height="100" src="{{ Storage::url($product->image ?? '') }}" />
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            {{-- <td>{{ $product->brand->name }}</td> --}}
                                            <td>  
                                                <a href="{{route('products.index',['id'=>$product->id])}}" class="btn btn-app bg-info">
                                                    <i class=""></i> {{ __('almadina.details') }}
                                                </a>
                                            </td>
                                            {{-- <td>{{ $product->price }}   {{__('almadina.shekel')}}</td>
                                            <td>{{ $product->product_ingredients }}</td> --}}
                                            <td> 
                                                {{$product->id}} 
                                                <a href="{{route('nutritionalValues.index',['id'=>$product->id])}}" class="btn btn-app bg-info">
                                                    <i class=""></i> {{ __('almadina.nutritionalValues') }}
                                                </a>
                                            </td>
                                            {{-- <td>{{ $product->created_at }}</td>
                                            <td>{{ $product->updated_at }}</td> --}}
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('product_tags.create',['id' => $product->id ]) }}" class="btn btn-add btn-primary ">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                    {{-- {{$product->id}} --}}
                                                    {{-- <a href="{{ route('product_tags.edit', $product->id) }}" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a> --}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    {{-- <a href="{{ route('products.create',['id' => $product->id ]) }}" class="btn btn-add btn-primary ">
                                                        <i class="fas fa-plus"></i>
                                                    </a> --}}
                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete('{{ $product->id }}', this)"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id, reference) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            performDelete(id, reference);
        }
        });
    }

    function performDelete(id, reference) {
        axios.delete('/almadina/admin/products/'+id)
        .then(function (response) {
            console.log(response);
            // toastr.success(response.data.message);
            reference.closest('tr').remove();
            showMessage(response.data);
        })
        .catch(function (error) {
            console.log(error.response);
            // toastr.error(error.response.data.message);
            showMessage(error.response.data);
        });
    }

    function showMessage(data) {
        Swal.fire(
            data.title,
            data.text,
            data.icon
        );
    }

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
