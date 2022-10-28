@extends('admin.starter')

@section('route', route('albums.index'))
@section('title', __('almadina.albums'))
@section('page-lg-title', __('almadina.edit_album'))
@section('main-pg-title', __('almadina.album'))
@section('page-md-title', __('almadina.edit_album'))

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
                        <h3 class="card-title">{{__('almadina.update_album')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="title">{{ __('almadina.album_title') }}</label>
                                <input type="text" class="form-control" id="title"
                                    placeholder="{{ __('almadina.album_title') }}" value="{{ $album->title }}" >
                            </div>
                            <div class="form-group">
                                <label for="text">{{ __('almadina.album_text') }}</label>
                                <input type="text" class="form-control" id="text"
                                    placeholder="{{ __('almadina.album_text') }}" value="{{ $album->text }}" >
                            </div>
                            <div class="form-group">
                                <label for="video">{{ __('almadina.video') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="video">
                                        <label class="custom-file-label" for="video">{{__('almadina.choose_file')}}</label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="button" onclick="performUpdate('{{$album->id}}')"
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

<script>
    $(function() {
        bsCustomFileInput.init()
    });
</script>

<script>

    function performUpdate(id) {
        var formData = new FormData();
        formData.append('title',document.getElementById('title').value);
        formData.append('text',document.getElementById('text').value);
        if(document.getElementById('video').files[0] != undefined) {
            formData.append('video',document.getElementById('video').files[0]);
        }
        formData.append('_method','PUT');

        axios.post('/almadina/admin/albums/{{$album->id}}', formData)
        .then(function (response) {
            console.log(response);
            toastr.success(response.data.message);
            window.location.href = '/almadina/admin/albums';
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message);
        });
    }
</script>
@endsection