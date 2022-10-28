@extends('admin.starter')

@section('route', route('teamMembers.index'))
@section('title', __('almadina.team'))
@section('page-lg-title', __('almadina.edit_team'))
@section('main-pg-title', __('almadina.team'))
@section('page-md-title', __('almadina.edit_team'))

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
                        <h3 class="card-title">{{__('almadina.update_team')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">{{ __('almadina.employee_name') }}</label>
                                <input type="text" class="form-control" id="name" value="{{ $teamMember->employee_name }}"
                                    placeholder="{{ __('almadina.employee_name') }}">
                            </div>

                            <div class="form-group">
                                <label for="speciality">{{ __('almadina.speciality') }}</label>
                                <input type="text" class="form-control" id="speciality" value="{{ $teamMember->speciality }}"
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
                            <button type="button" onclick="performUpdate('{{$teamMember->id}}')"
                                class="btn btn-primary">{{__('almadina.update')}}</button>
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
<script src="{{asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
{{-- <script src="{{asset('js/axios.js')}}"></script> --}}

<script>
    $(function() {
        bsCustomFileInput.init()
    });
</script>

<script>

    function performUpdate(id) {
        var formData = new FormData();
        formData.append('name',document.getElementById('name').value);
        formData.append('speciality',document.getElementById('speciality').value);
        if(document.getElementById('image').files[0] != undefined) {
            formData.append('image',document.getElementById('image').files[0]);
        }
        formData.append('_method','PUT');

        axios.post('/almadina/admin/teamMembers/{{$teamMember->id}}', formData)
        .then(function (response) {
            console.log(response);
            toastr.success(response.data.message);
            window.location.href = '/almadina/admin/teamMembers';
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message);
        });
    }
</script>
@endsection