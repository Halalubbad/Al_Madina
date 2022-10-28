@extends('admin.starter')

@section('route', route('conditions.index'))
@section('title', __('almadina.theysaid'))
@section('page-lg-title', __('almadina.edit_says'))
@section('main-pg-title', __('almadina.theysaid'))
@section('page-md-title', __('almadina.edit_says'))

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
                            <h3 class="card-title">{{ __('almadina.edit_says') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            @csrf
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">{{ __('almadina.name') }}</label>
                                        <input type="text" value="{{ $theysaid->name }}" class="form-control"
                                            id="name" placeholder="{{ __('almadina.name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="category">{{ __('almadina.category') }}</label>
                                        <input type="text" value="{{ $theysaid->category }}" class="form-control"
                                            id="category" placeholder="{{ __('almadina.category') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="details">{{ __('almadina.details') }}</label>
                                        <textarea rows="3" type="text" class="form-control"
                                            id="details" placeholder="{{ __('almadina.details') }}">{{ $theysaid->details }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">{{ __('almadina.image') }}</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image">
                                                <label class="custom-file-label"
                                                    for="image">{{ __('almadina.choose_file') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="performUpdate('{{ $theysaid->id }}')"
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

    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init()
        });
    </script>

    <script>
        function performUpdate(id) {
            var formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('category', document.getElementById('category').value);
            formData.append('details', document.getElementById('details').value);
            if (document.getElementById('image').files[0] != undefined) {
                formData.append('image', document.getElementById('image').files[0]);
            }
            formData.append('_method', 'PUT');

            axios.post('/almadina/admin/theysaids/{{ $theysaid->id }}', formData)
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    window.location.href = '/almadina/admin/theysaids';
                })
                .catch(function(error) {
                    console.log(error.response);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
