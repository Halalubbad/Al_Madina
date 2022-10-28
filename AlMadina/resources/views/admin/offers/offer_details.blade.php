@extends('admin.starter')

@section('title', __('almadina.offers'))
@section('route', route('offers.index'))
@section('page-lg-title', __('almadina.offer_details'))
@section('main-pg-title', __('almadina.offers'))
@section('page-md-title', __('almadina.offer_details'))

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
                            <h3 class="card-title">{{ __('almadina.offer_details') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- enctype="multipart/form-data" --}}
                        <form>
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <img height="100" src="{{ Storage::url($offer[0]->image ?? '') }}" />
                                </div>
                                <div class="form-group">
                                    <label for="title">{{ __('almadina.offer_title') }}</label>
                                    <input type="text" class="form-control" id="title" value="{{ $offer[0]->title }}"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="text">{{ __('almadina.offer_text') }}</label>
                                    <input type="text" class="form-control" id="text" value="{{ $offer[0]->text }}"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="Joining_mechanism">{{ __('almadina.Joining_mechanism') }}</label>
                                    <input type="text" class="form-control" id="Joining_mechanism"
                                        value="{{ $offer[0]->Joining_mechanism }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="condition">{{ __('almadina.condition') }}</label>
                                    @foreach ($offer[0]->conditions as $condition)
                                        <input type="text" class="form-control" id="condition"
                                            value="{{ $condition->name }}" readonly>
                                    @endforeach

                                </div>
                                <div class="form-group">
                                    <label for="datepicker">{{ __('almadina.expired_at') }}</label>
                                    <input type="text" id="datepicker" value="{{ $offer[0]->expired_at }}"
                                        class="date form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="video">{{ __('almadina.video') }}</label>
                                    <div class="input-group">
                                        <div class="media">
                                            <div class="media-body">
                                                <video width="320" height="240" controls preload="auto">
                                                    <source src="{{ Storage::url($offer[0]->video ?? '') }}"
                                                        type="video/mp4">
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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

    {{-- Date Picker --}}
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
@endsection
