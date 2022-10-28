@extends('admin.starter')

@section('title', __('almadina.nutritionalValues'))
<?php 
    if($request->has('id')){
        $productName = $nutritionalValues[0]->product->name; ?>
        @section('page-lg-title', $productName) 
    <?php }else { ?>
        @section('page-lg-title', __('almadina.nutritionalValues'))
    <?php }
?>
<?php 
if($request->has('id')){
    ?>
    @section('route' , route('products.index'))
    @section('main-pg-title', __('almadina.products'))
<?php }else { ?>
    @section('route' , route('products.index'))
    @section('main-pg-title', __('almadina.home'))
<?php }
?>
@section('page-md-title', __('almadina.nutritionalValues'))

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('almadina.nutritionalValues') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('almadina.product_name') }}</th>
                                        <th>{{ __('almadina.energy') }}</th>
                                        <th>{{ __('almadina.fatty') }}</th>
                                        <th>{{ __('almadina.proteins') }}</th>
                                        <th>{{ __('almadina.carbohydrates') }}</th>
                                        <th>{{ __('almadina.vitaminC') }}</th>
                                        {{-- <th>{{ __('almadina.created_at') }}</th>
                                        <th>{{ __('almadina.updated_at') }}</th> --}}
                                        <th style="width: 40px">{{ __('almadina.settings') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($nutritionalValues as $nutritionalValue)
                                        <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>{{ $nutritionalValue->product->name }}</td>
                                            <td>{{ $nutritionalValue->energy }}</td>
                                            <td>{{ $nutritionalValue->fatty }}</td>
                                            <td>{{ $nutritionalValue->proteins }}</td>
                                            <td>{{ $nutritionalValue->carbohydrates }}</td>
                                            <td>{{ $nutritionalValue->vitaminC }}</td>
                                            {{-- <td>{{ $condition->created_at }}</td>
                                            <td>{{ $condition->updated_at }}</td> --}}
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('nutritionalValues.edit', $nutritionalValue->id) }}" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete('{{ $nutritionalValue->id }}', this)"
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
        axios.delete('/almadina/admin/nutritionalValues/'+id)
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
