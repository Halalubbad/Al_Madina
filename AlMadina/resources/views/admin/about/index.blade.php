@extends('admin.starter')

@section('title', __('almadina.about'))
@section('page-lg-title', __('almadina.index'))
@section('main-pg-title', __('almadina.about'))
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
                            <h3 class="card-title">{{ __('almadina.about') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('almadina.image') }}</th>
                                        <th>{{ __('almadina.video') }}</th>
                                        <th>{{ __('almadina.about_title') }}</th>
                                        <th>{{ __('almadina.about_text') }}</th>
                                        <th>{{ __('almadina.about_message') }}</th>
                                        <th>{{ __('almadina.about_objectives') }}</th>
                                        <th>{{ __('almadina.social_contribution') }}</th>
                                        <th>{{ __('almadina.team_text') }}</th>
                                        <th>{{ __('almadina.created_at') }}</th>
                                        {{-- <th>{{ __('almadina.updated_at') }}</th> --}}
                                        <th style="width: 40px">{{ __('almadina.settings') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($abouts as $about)
                                        <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <img height="100" src="{{ Storage::url($about->image ?? '') }}" />
                                            </td>
                                            <td>
                                                <div class="media">
                                                    <div class="media-body">
                                                        <video width="200" height="200" controls preload="auto">
                                                            <source src="{{ Storage::url($about->video ?? '') }}"
                                                                type="video/mp4">
                                                        </video>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $about->title }}</td>
                                            <td>{{ $about->about_text }}</td>
                                            <td>{{ $about->message }}</td>
                                            <td>{{ $about->objectives }}</td>
                                            <td>{{ $about->social_contribution }}</td>
                                            <td>{{ $about->team_text }}</td>
                                            <td>{{ $about->created_at->diffForHumans() }}</td>
                                            {{-- <td>{{ $about->updated_at->diffForHumans() }}</td> --}}
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('abouts.edit', $about->id) }}"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete('{{ $about->id }}', this)"
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
            axios.delete('/almadina/admin/abouts/' + id)
                .then(function(response) {
                    console.log(response);
                    // toastr.success(response.data.message);
                    reference.closest('tr').remove();
                    showMessage(response.data);
                })
                .catch(function(error) {
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
