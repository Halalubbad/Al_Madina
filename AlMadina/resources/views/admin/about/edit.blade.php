@extends('admin.starter')

@section('route', route('abouts.index'))
@section('title', __('almadina.about'))
@section('page-lg-title', __('almadina.edit_about'))
@section('main-pg-title', __('almadina.about'))
@section('page-md-title', __('almadina.edit_about'))

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
                        <h3 class="card-title">{{__('almadina.edit_about')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="about_title">{{__('almadina.about_title') }}</label>
                                <input type="text" class="form-control" id="about_title"
                                    value=" {{$about->title}} ">
                            </div>
                            <div class="form-group">
                                <label for="about_text">{{__('almadina.about_text') }}</label>
                                <textarea id="about_text" class="form-control" rows="4" >
                                    {{$about->about_text}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="about_message">{{ __('almadina.about_message') }}</label>
                                <textarea placeholder="{{__('almadina.about_message')}}" type="text" id="about_message"
                                    class="date form-control">{{$about->message}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="about_objectives">{{ __('almadina.about_objectives') }}</label>
                                <textarea placeholder="{{__('almadina.about_objectives')}}" type="text" id="about_objectives"
                                    class="date form-control">{{$about->objectives}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="social_contribution">{{ __('almadina.social_contribution') }}</label>
                                <textarea placeholder="{{__('almadina.social_contribution')}}" type="text" id="social_contribution"
                                    class="date form-control">{{$about->social_contribution}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="team_text">{{ __('almadina.team_text') }}</label>
                                <textarea placeholder="{{__('almadina.team_text')}}" type="text" id="team_text"
                                    class="date form-control">{{$about->team_text}}</textarea>
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
                            <button type="button" onclick="performUpdate('{{$about->id}}')"
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
        if(document.getElementById('image').files[0] != undefined) {
            formData.append('image',document.getElementById('image').files[0]);
        }
        if(document.getElementById('video').files[0] != undefined) {
            formData.append('video',document.getElementById('video').files[0]);
        }
        formData.append('about_title', document.getElementById('about_title').value);
        formData.append('about_text', document.getElementById('about_text').value);
        formData.append('about_message', document.getElementById('about_message').value);
        formData.append('about_objectives', document.getElementById('about_objectives').value);
        formData.append('social_contribution', document.getElementById('social_contribution').value);
        formData.append('team_text', document.getElementById('team_text').value);

        formData.append('_method','PUT');

        axios.post('/almadina/admin/abouts/{{$about->id}}', formData)
        .then(function (response) {
            console.log(response);
            toastr.success(response.data.message);
            window.location.href = '/almadina/admin/abouts';
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message);
        });
    }
</script>
@endsection