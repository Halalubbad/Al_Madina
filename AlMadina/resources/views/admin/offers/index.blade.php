@extends('admin.starter')

@section('title', __('almadina.offers'))
@section('page-lg-title', __('almadina.offers'))
@section('main-pg-title', __('almadina.home'))
@section('page-md-title', __('almadina.offers'))

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('almadina.offers') }}</h3>
                        </div>
                        {{-- <div class="card-toolbar">
                            <a href="" class="btn btn-info font-weight-bolder font-size-sm">New
                                About</a>
                        </div> --}}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('almadina.image') }}</th>
                                        <th>{{ __('almadina.title') }}</th>
                                        {{-- <th>{{ __('almadina.text') }}</th> --}}
                                        <th>{{ __('almadina.conditions') }}</th>
                                        <th>{{ __('almadina.offer_details') }}</th>
                                        {{-- <th>{{ __('almadina.Joining_mechanism') }}</th>
                                        <th>{{ __('almadina.video') }}</th>
                                        <th>{{ __('almadina.expired_at') }}</th> --}}
                                        {{-- <th>{{ __('almadina.created_at') }}</th>
                                        <th>{{ __('almadina.updated_at') }}</th> --}}
                                        <th style="width: 40px">{{ __('almadina.settings') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($offers as $offer)
                                        <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <img height="100" src="{{ Storage::url($offer->image ?? '') }}" />
                                            </td>
                                            <td>{{ $offer->title }}</td>
                                            {{-- <td>{{ $offer->text }}</td> --}}
                                            <td>
                                                <a href="{{ route('conditions.index', ['id' => $offer->id]) }}"
                                                    class="btn btn-light-primary font-weight-bolder font-size-sm">
                                                    <i class="fas fa-list-ul"></i> {{ $offer->conditions_count }}
                                                </a>
                                            </td>
                                            <td>
                                            <a href="{{ route('offers.index', ['id' => $offer->id]) }}"
                                                class="btn btn-app bg-info">
                                                <i class=""></i> {{ __('almadina.offer_details') }}
                                            </a>
                                            </td>
                                            {{-- <td>{{ $offer->Joining_mechanism }}</td> --}}

                                            {{-- <td>
                                                <div class="media">
                                                    <div class="media-body">
                                                        <video width="320" height="240" controls preload="auto">
                                                            <source src="{{ Storage::url($offer->video ?? '')  }}" type="video/mp4" >
                                                        </video>
                                                    </div>
                                                </div>
                                            </td> --}}
                                            {{-- <td>{{ $offer->expired_at }}</td> --}}
                                            {{-- <td>{{ $offer->created_at }}</td>
                                            <td>{{ $offer->updated_at }}</td> --}}
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('offers.edit', $offer->id) }}"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete('{{ $offer->id }}', this)"
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
            axios.delete('/almadina/admin/offers/' + id)
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
