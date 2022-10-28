@extends('admin.starter')

@section('route' , route('admin.home'))
@section('title', __('almadina.albums'))
@section('page-lg-title', __('almadina.albums'))
@section('main-pg-title', __('almadina.home'))
@section('page-md-title', __('almadina.albums'))

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('almadina.albums') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('almadina.title') }}</th>
                                        <th>{{ __('almadina.text') }}</th>
                                        <th>{{ __('almadina.album_images') }}</th>
                                        <th>{{ __('almadina.video') }}</th>
                                        {{-- <th>{{ __('almadina.created_at') }}</th>
                                        <th>{{ __('almadina.updated_at') }}</th> --}}
                                        <th style="width: 40px">{{ __('almadina.settings') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php $i = 0; ?>
                                    @foreach ($albums as $album)
                                        <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>{{ $album->title }}</td>
                                            <td>{{ $album->text }}</td>
                                            <td>
                                                <a href="{{route('album_Images.index',['id'=>$album->id])}}" class="btn btn-app bg-info">
                                                    <i class="fas fa-images"></i> {{__('almadina.album_images')}}
                                                </a>
                                                {{-- <i class="fa-solid fa-camera-viewfinder"></i> --}}
                                            </td>
                                            <td>
                                                <div class="media">
                                                    <div class="media-body">
                                                        <video width="320" height="240" controls preload="auto">
                                                            <source src="{{ Storage::url($album->video ?? '')  }}" type="video/mp4" >
                                                        </video>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td>{{ $album->created_at }}</td>
                                            <td>{{ $album->updated_at }}</td> --}}
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('albums.edit', $album->id) }}" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete('{{ $album->id }}', this)"
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
        axios.delete('/almadina/admin/albums/'+id)
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
