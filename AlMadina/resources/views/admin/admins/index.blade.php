@extends('admin.starter')

@section('title', __('almadina.admins'))
@section('page-lg-title', __('almadina.index'))
@section('main-pg-title', __('almadina.admins'))
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
                            <h6 style="float: left;" class="">{{ __('almadina.admins') }}</h6>

                            <button style="height:40px;width:150px;float:right;" type="button" class="btn btn-primary"
                                data-toggle="modal" data-target="#createadminModal" data-dismiss="modal">
                                {{ __('almadina.create_admin') }}
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>{{ __('almadina.name') }}</th>
                                        <th>{{ __('almadina.email') }}</th>
                                        {{-- <th>{{ __('almadina.role') }}</th> --}}
                                        <th>{{ __('almadina.created_at') }}</th>
                                        <th>{{ __('almadina.updated_at') }}</th>
                                        <th style="width: 40px">{{ __('almadina.settings') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            {{-- <td>{{ $admin->roles[0]->name }}</td> --}}
                                            <td>{{ $admin->created_at }}</td>
                                            <td>{{ $admin->updated_at }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.edit-admin', ['id' => $admin->id]) }}"
                                                        id="editBtn" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#editadminModal{{ $admin->id }}"
                                                        data-dismiss="modal" data-item-id="{{ $admin->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete('{{ $admin->id }}', this)"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- {{$admin->id}} --}}
                                        <div class="modal fade" id="editadminModal{{ $admin->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content rounded-0 border-0 p-4">
                                                    <div class="modal-header border-0">
                                                        <h3>{{ __('almadina.update_admin') }}</h3>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="editAdmin">
                                                            <form class="row" method="POST"
                                                                action="{{ route('admins.update', $admin->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <input id="admin_id" value="{{ $admin->id }}"
                                                                            type="hidden" name="admin_id">
                                                                        <label
                                                                            for="name">{{ __('almadina.name') }}</label>
                                                                        <input type="text" value="{{ $admin->name }}"
                                                                            class="form-control" id="edit_name"
                                                                            name="edit_name"
                                                                            placeholder="{{ __('almadina.name') }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="email">{{ __('almadina.email') }}</label>
                                                                        <input type="email" value="{{ $admin->email }}"
                                                                            class="form-control" id="edit_email"
                                                                            name="edit_email"
                                                                            placeholder="{{ __('almadina.email') }}">
                                                                    </div>

                                                                    <div class="card-footer">
                                                                        <div class="card-footer">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">{{ __('almadina.update') }}</button>
                                                                        </div>
                                                                        {{-- {{$admin->id}} --}}
                                                                        {{-- <button type="button" id="closeModal"
                                                                            onclick="performUpdate({{ $admin->id }})"
                                                                            class="btn btn-primary">{{ __('almadina.update') }}
                                                                        </button> --}}
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

    {{-- Create Admin --}}
    <div class="modal fade" id="createadminModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded-0 border-0 p-4">
                <div class="modal-header border-0">
                    <h3>{{ __('almadina.create_admin') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="creatAdmin">
                        <form class="row" id="create-form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('almadina.name') }}</label>
                                    <input type="text" class="form-control" id="adminname"
                                        placeholder="{{ __('almadina.name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('almadina.email') }}</label>
                                    <input type="email" class="form-control" id="adminemail"
                                        placeholder="{{ __('almadina.email') }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('almadina.password') }}</label>
                                    <input type="password" class="form-control" id="adminpassword"
                                        placeholder="{{ __('almadina.password') }}">
                                </div>

                                <div class="card-footer">
                                    <button type="button" id="closeModal" onclick="performStore()"
                                        class="btn btn-primary">{{ __('almadina.save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // onclick="javascript:window.location.reload()" 
        // $('#closeModal').click(function() {
        //     // window.location.reload();
        //     $('#createadminModal').modal('hide');
        //     $('#editadminModal').modal('hide');
        // });

        function performStore() {
            axios.post('/almadina/admin/admins', {
                    adminname: document.getElementById('adminname').value,
                    adminemail: document.getElementById('adminemail').value,
                    adminpassword: document.getElementById('adminpassword').value,
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    $('#closeModal').click(function() {
                        // window.location.reload();
                        $('#createadminModal').modal('hide');
                    });
                    window.location.reload();
                })
                .catch(function(error) {
                    console.log(error.response);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
    <script>
        // function performUpdate(id) {

        //     document.getElementById("admin_id").innerHTML = id;
        //     alert(id);

        //     axios.put('/almadina/admin/admins/' + id, {
        //             // alert(id);

        //             edit_name: document.getElementById('edit_name').value,
        //             edit_email: document.getElementById('edit_email').value,
        //             // password: document.getElementById('password').value,
        //         })
        //         .then(function(response) {
        //             console.log(response);
        //             toastr.success(response.data.message);
        //             $('#closeModal').click(function() {
        //                 // window.location.reload();
        //                 $('#editadminModal').modal('hide');
        //             });
        //             window.location.reload();
        //             // window.location.href = '/almadina/admin/admins';
        //         })
        //         .catch(function(error) {
        //             console.log(error.response);
        //             toastr.error(error.response.data.message);
        //         });
        // }
    </script>

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
            axios.delete('/almadina/admin/admins/' + id)
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
            Swal.fire({
                icon: data.icon,
                title: data.title,
                showConfirmButton: false,
                timer: 1500
            });
        }

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                        extend: 'copy',
                        footer: false,
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: false,
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        }
                    },
                    "excel",
                    "pdf",
                    "print",
                    "colvis"
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
