@extends('admin.starter')

@section('route', route('offers.index'))
@section('title', __('almadina.offers'))
@section('page-lg-title', __('almadina.edit_offer'))
@section('main-pg-title', __('almadina.offer'))
@section('page-md-title', __('almadina.edit_offer'))

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
                        <h3 class="card-title">{{__('almadina.update_offer')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="title">{{ __('almadina.offer_title') }}</label>
                                <input type="text" class="form-control" id="title"
                                    placeholder="{{ __('almadina.title') }}" value="{{ $offer->title }}" >
                            </div>
                            <div class="form-group">
                                <label for="text">{{ __('almadina.offer_text') }}</label>
                                <input type="text" class="form-control" id="text"
                                    placeholder="{{ __('almadina.text') }}" value="{{ $offer->text }}" >
                            </div>
                            <div class="form-group">
                                <label for="Joining_mechanism">{{ __('almadina.Joining_mechanism') }}</label>
                                <input type="text" class="form-control" id="Joining_mechanism"
                                    placeholder="{{ __('almadina.Joining_mechanism') }}" value="{{ $offer->Joining_mechanism }}" >
                            </div>
                            <div class="form-group">
                                <label for="datepicker">{{ __('almadina.expired_at') }}</label>
                                <input placeholder="Select date" type="text" id="datepicker"
                                    class="date form-control" value="{{ $offer->expired_at }}" >
                            </div>
                            <div class="form-group">
                                <label for="image">{{ __('almadina.image') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image"  >
                                        <label class="custom-file-label" for="image">{{__('almadina.choose_file')}}</label>
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
                            <button type="button" onclick="performUpdate('{{$offer->id}}')"
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

<script type="text/javascript">
    $(function() {
        $('#datepicker').datepicker({
            dateFormat: 'yy/mm/dd'
        });
    });
</script>

<script>

    function performUpdate(id) {
        var formData = new FormData();
        formData.append('title',document.getElementById('title').value);
        formData.append('text',document.getElementById('text').value);
        formData.append('Joining_mechanism',document.getElementById('Joining_mechanism').value);
        formData.append('expired_at',document.getElementById('datepicker').value);
        if(document.getElementById('image').files[0] != undefined) {
            formData.append('image',document.getElementById('image').files[0]);
        }
        if(document.getElementById('video').files[0] != undefined) {
            formData.append('video',document.getElementById('video').files[0]);
        }
        formData.append('_method','PUT');

        axios.post('/almadina/admin/offers/{{$offer->id}}', formData)
        .then(function (response) {
            console.log(response);
            toastr.success(response.data.message);
            window.location.href = '/almadina/admin/offers';
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message);
        });
    }
</script>
{{-- Date Picker --}}
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
@endsection