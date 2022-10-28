@extends('admin.starter')

@section('title', __('almadina.comments'))
@section('page-lg-title', __('almadina.index'))
@section('main-pg-title', __('almadina.news'))
@section('page-md-title', __('almadina.index'))

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('almadina.comments') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('almadina.client_name') }}</th>
                                        <th>{{ __('almadina.image') }}</th>
                                        <th>{{ __('almadina.text') }}</th>
                                        <th>{{ __('almadina.news') }}</th>
                                        {{-- <th>{{ __('almadina.published_at') }}</th> --}}
                                        <th>{{ __('almadina.created_at') }}</th>
                                        <th>{{ __('almadina.updated_at') }}</th>
                                        <th style="width: 40px">{{ __('almadina.settings') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($comments as $comment)
                                        <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>{{ $comment->client_name }}</td>
                                            <td>
                                                <img height="100" src="{{ Storage::url($comment->image ?? '') }}" />
                                            </td>
                                            <td>{{ $comment->text }}</td>
                                            <td>{{ $comment->news->title }}</td>
                                            {{-- <td>{{ $comment->published_at }}</td> --}}
                                            <td>{{ $comment->created_at }}</td>
                                            <td>{{ $comment->updated_at }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    {{-- <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a> --}}
                                                    <a href="#" onclick="confirmDelete('{{ $comment->id }}', this)"
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
        axios.delete('/almadina/admin/comments/'+id)
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
