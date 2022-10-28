@extends('admin.starter')

@section('title',__('almadina.conditions'))
@section('route' , route('conditions.index'))
@section('page-lg-title',__('almadina.add_condition'))
@section('main-pg-title',__('almadina.conditions'))
@section('page-md-title',__('almadina.add_condition'))

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
                            <h3 class="card-title">{{ __('almadina.add_condition') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- enctype="multipart/form-data" --}}
                        <form id="create_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{__('almadina.offer_title')}}</label>
                                    <select class="form-control" id="offer_id">
                                        @foreach ($offers as $offer)
                                        <option value="{{$offer->id}}">{{$offer->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="condition">{{ __('almadina.condition') }}</label>
                                    <input type="text" class="form-control" id="condition"
                                        placeholder="{{ __('almadina.condition') }}">
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

    <script>
        function performStore(){
        // alert('PERFORM')
        axios.post('/almadina/admin/conditions', {
          offer_id : document.getElementById('offer_id').value ,
          condition : document.getElementById('condition').value ,
        })
        .then(function (response) {
          console.log(response);
          toastr.success(response.data.message);
          document.getElementById('create_form').reset();
        })
        .catch(function (error) {
          console.log(error.response);
          toastr.error(error.response.data.message);
          
        });
    }
    </script>
@endsection
