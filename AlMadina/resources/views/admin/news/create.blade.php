@extends('admin.starter')

@section('route', route('news.index'))
@section('title', __('almadina.news'))
@section('page-lg-title', __('almadina.create_news'))
@section('main-pg-title', __('almadina.news'))
@section('page-md-title', __('almadina.create_news'))

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
                            <h3 class="card-title">{{ __('almadina.add_news') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- enctype="multipart/form-data" --}}
                        <form id="create_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">{{ __('almadina.title') }}</label>
                                    <input type="text" class="form-control" id="title"
                                        placeholder="{{ __('almadina.title') }}">
                                </div>
                                <div class="form-group">
                                    <label for="text">{{ __('almadina.text') }}</label>
                                    <textarea id="text" class="form-control" rows="4" placeholder="{{ __('almadina.news_text') }}"></textarea>
                                </div>
                                {{-- data-date-format="yyyy-mm-dd" --}}
                                <div class="form-group">
                                    <label for="datepicker">{{ __('almadina.published_at') }}</label>
                                    <input placeholder="Select date" type="text" id="datepicker"
                                        class="date form-control">
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

    <script type="text/javascript">
        $(function() {
            $('#datepicker').datepicker({
                dateFormat: 'yy/mm/dd'
            });
        });
    </script>

    <script>
        function performStore() {
            var formData = new FormData();
            formData.append('image', document.getElementById('image').files[0]);
            formData.append('title', document.getElementById('title').value);
            formData.append('text', document.getElementById('text').value);
            formData.append('published_at', document.getElementById('datepicker').value);

            axios.post('/almadina/admin/news', formData)
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

    {{-- Date Picker --}}
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
@endsection
