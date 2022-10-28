@extends('admin.starter')

@section('title', __('almadina.sliders'))
@section('page-lg-title', __('almadina.edit'))
@section('main-pg-title', __('almadina.update_slider'))
@section('page-md-title', __('almadina.edit'))

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
                        <h3 class="card-title">{{__('almadina.update_slider')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="create-form">
                        @csrf
                        <div class="card-body">
                            
                            <div class="form-group">
                                <label for="slider_image">{{ __('almadina.image') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="slider_image">
                                        <label class="custom-file-label" for="slider_image">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="button" onclick="performUpdate('{{$slider->id}}')"
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
    $(function () { bsCustomFileInput.init() });
</script>

<script>
    function performUpdate(id) {
        var formData = new FormData();
        if(document.getElementById('slider_image').files[0] != undefined) {
            formData.append('image',document.getElementById('slider_image').files[0]);
        }
        formData.append('_method','PUT');

        axios.post('/almadina/admin/sliders/{{$slider->id}}', formData)
        .then(function (response) {
            console.log(response);
            toastr.success(response.data.message);
            window.location.href = '/almadina/admin/sliders';
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message);
        });
    }
</script>
@endsection