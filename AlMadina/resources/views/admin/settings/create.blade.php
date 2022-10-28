@extends('admin.starter')

@section('title',__('almadina.sliders'))
@section('page-lg-title',__('almadina.create_settings'))
@section('main-pg-title',__('almadina.sliders'))
@section('page-md-title',__('almadina.create'))

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
                            <h3 class="card-title">{{ __('almadina.create_settings') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- enctype="multipart/form-data" --}}
                        <form id="create-form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">{{ __('almadina.title') }}</label>
                                    <input type="text" class="form-control" id="title"
                                        placeholder="{{ __('almadina.title') }}">
                                </div>

                                <div class="form-group">
                                    <label for="instagram">{{ __('almadina.instagram') }}</label>
                                    <input type="text" class="form-control" id="instagram"
                                        placeholder="{{ __('almadina.instagram') }}">
                                </div>

                                <div class="form-group">
                                    <label for="youtube">{{ __('almadina.youtube') }}</label>
                                    <input type="text" class="form-control" id="youtube"
                                        placeholder="{{ __('almadina.youtube') }}">
                                </div>

                                <div class="form-group">
                                    <label for="twitter">{{ __('almadina.twitter') }}</label>
                                    <input type="text" class="form-control" id="twitter"
                                        placeholder="{{ __('almadina.twitter') }}">
                                </div>

                                <div class="form-group">
                                    <label for="facebook">{{ __('almadina.facebook') }}</label>
                                    <input type="text" class="form-control" id="facebook"
                                        placeholder="{{ __('almadina.facebook') }}">
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('almadina.email') }}</label>
                                    <input type="email" class="form-control" id="email"
                                        placeholder="{{ __('almadina.email') }}">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">{{ __('almadina.mobile') }}</label>
                                    <input type="text" class="form-control" id="mobile"
                                        placeholder="{{ __('almadina.mobile') }}">
                                </div>

                                <div class="form-group">
                                    <label for="whatsapp">{{ __('almadina.whatsapp') }}</label>
                                    <input type="text" class="form-control" id="whatsapp"
                                        placeholder="{{ __('almadina.whatsapp') }}">
                                </div>

                                <div class="form-group">
                                    <label for="sales_manager_mobile">{{ __('almadina.sales_manager_mobile') }}</label>
                                    <input type="text" class="form-control" id="sales_manager_mobile"
                                        placeholder="{{ __('almadina.sales_manager_mobile') }}">
                                </div>

                                <div class="form-group">
                                    <label for="customer_followup_mobile">{{ __('almadina.customer_followup_mobile') }}</label>
                                    <input type="text" class="form-control" id="customer_followup_mobile"
                                        placeholder="{{ __('almadina.customer_followup_mobile') }}">
                                </div>

                                <div class="form-group">
                                    <label for="disributor_mobile">{{ __('almadina.disributor_mobile') }}</label>
                                    <input type="text" class="form-control" id="disributor_mobile"
                                        placeholder="{{ __('almadina.disributor_mobile') }}">
                                </div>

                                <div class="form-group">
                                    <label for="location">{{ __('almadina.location') }}</label>
                                    <input type="text" class="form-control" id="location"
                                        placeholder="{{ __('almadina.location') }}">
                                </div>

                                <div class="form-group">
                                    <label for="site_image">{{ __('almadina.site_image') }}</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="site_image">
                                            <label class="custom-file-label" for="site_image">{{__('almadina.choose_file')}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="boss_image">{{ __('almadina.boss_image') }}</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="boss_image">
                                            <label class="custom-file-label" for="boss_image">{{__('almadina.choose_file')}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="boss_name">{{ __('almadina.boss_name') }}</label>
                                    <input type="text" class="form-control" id="boss_name"
                                        placeholder="{{ __('almadina.boss_name') }}">
                                </div>

                                <div class="form-group">
                                    <label for="boss_words">{{ __('almadina.boss_words') }}</label>
                                    <textarea id="boss_words" class="form-control" rows="4" placeholder="{{ __('almadina.boss_words') }}"></textarea>
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
        formData.append('title',document.getElementById('title').value);
        formData.append('instagram',document.getElementById('instagram').value);
        formData.append('facebook',document.getElementById('facebook').value);
        formData.append('twitter',document.getElementById('twitter').value);
        formData.append('youtube',document.getElementById('youtube').value);
        formData.append('email',document.getElementById('email').value);
        formData.append('mobile',document.getElementById('mobile').value);
        formData.append('whatsapp',document.getElementById('whatsapp').value);
        formData.append('sales_manager_mobile',document.getElementById('sales_manager_mobile').value);
        formData.append('customer_followup_mobile',document.getElementById('customer_followup_mobile').value);
        formData.append('disributor_mobile',document.getElementById('disributor_mobile').value);
        formData.append('location',document.getElementById('location').value);
        formData.append('boss_words',document.getElementById('boss_words').value);
        formData.append('boss_name',document.getElementById('boss_name').value);
        if(document.getElementById('site_image').files[0] != undefined) {
            formData.append('site_image',document.getElementById('site_image').files[0]);
        }
        if(document.getElementById('boss_image').files[0] != undefined) {
            formData.append('boss_image',document.getElementById('boss_image').files[0]);
        }

        axios.post('/almadina/admin/settings', formData)
            .then(function(response) {
                console.log(response);
                toastr.success(response.data.message);
                document.getElementById('create-form').reset();
            })
            .catch(function(error) {
                console.log(error.response);
                toastr.error(error.response.data.message);
            });
        }
    </script>
@endsection
