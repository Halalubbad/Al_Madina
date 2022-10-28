@extends('admin.starter')

@section('title',__('almadina.team'))
@section('route' , route('teamMembers.index'))
@section('page-lg-title',__('almadina.add_member'))
@section('main-pg-title',__('almadina.our_team'))
@section('page-md-title',__('almadina.add_member'))

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
                            <h3 class="card-title">{{ __('almadina.add_member') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- enctype="multipart/form-data" --}}
                        <form id="create_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('almadina.employee_name') }}</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="{{ __('almadina.employee_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="speciality">{{ __('almadina.speciality') }}</label>
                                    <input type="text" class="form-control" id="speciality"
                                        placeholder="{{ __('almadina.speciality') }}">
                                </div>
                                <div class="form-group">
                                    <label for="image">{{ __('almadina.image') }}</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image">
                                            <label class="custom-file-label" for="image">{{__('almadina.choose_file')}}</label>
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
        function performStore() {
            var formData = new FormData();
            formData.append('image', document.getElementById('image').files[0]);
            formData.append('name', document.getElementById('name').value);
            formData.append('speciality', document.getElementById('speciality').value);

            axios.post('/almadina/admin/teamMembers', formData)
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
