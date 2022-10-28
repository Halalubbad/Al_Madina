@extends('admin.starter')

@section('title',__('almadina.album_images'))
@section('route' , route('album_Images.index'))
@section('page-lg-title',__('almadina.add_image'))
@section('main-pg-title',__('almadina.album_images'))
@section('page-md-title',__('almadina.add_image'))

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
                            <h3 class="card-title">{{ __('almadina.add_image') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- enctype="multipart/form-data" --}}
                        <form id="create_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{__('almadina.album')}}</label>
                                    <select class="form-control" id="album_id">
                                        @foreach ($albums as $album)
                                        <option value="{{$album->id}}">{{$album->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="slider_image">{{ __('almadina.image') }}</label>
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
<script src="{{asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script>
    $(function() {
        bsCustomFileInput.init()
    });
</script>

<script>
    function performStore() {
        var formData = new FormData();
        formData.append('image', document.getElementById('image').files[0]);
        formData.append('album_id',document.getElementById('album_id').value);

        axios.post('/almadina/admin/album_Images', formData)
            .then(function(response) {
                console.log(response);
                toastr.success(response.data.message);
                document.getElementById('create_form').reset();
            })
            .catch(function(error) {
                console.log(error.response);
                toastr.error(error.response.data.message);
            });
    }
</script>
@endsection
