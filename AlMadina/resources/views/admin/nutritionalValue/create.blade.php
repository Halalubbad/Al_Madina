@extends('admin.starter')

@section('title',__('almadina.nutritionalValues'))
@section('route' , route('nutritionalValues.index'))
@section('page-lg-title',__('almadina.add_nutritionalValues'))
@section('main-pg-title',__('almadina.nutritionalValues'))
@section('page-md-title',__('almadina.add_nutritionalValues'))

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
                            <h3 class="card-title">{{ __('almadina.add_nutritionalValues') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- enctype="multipart/form-data" --}}
                        <form id="create_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{__('almadina.product_name')}}</label>
                                    <select class="form-control" id="product_id">
                                        @foreach ($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="energy">{{ __('almadina.energy') }}</label>
                                    <input type="text" class="form-control" id="energy"
                                        placeholder="{{ __('almadina.energy') }}">
                                </div>
                                <div class="form-group">
                                    <label for="fatty">{{ __('almadina.fatty') }}</label>
                                    <input type="text" class="form-control" id="fatty"
                                        placeholder="{{ __('almadina.fatty') }}">
                                </div>
                                <div class="form-group">
                                    <label for="proteins">{{ __('almadina.proteins') }}</label>
                                    <input type="text" class="form-control" id="proteins"
                                        placeholder="{{ __('almadina.proteins') }}">
                                </div>
                                <div class="form-group">
                                    <label for="carbohydrates">{{ __('almadina.carbohydrates') }}</label>
                                    <input type="text" class="form-control" id="carbohydrates"
                                        placeholder="{{ __('almadina.carbohydrates') }}">
                                </div>
                                <div class="form-group">
                                    <label for="vitaminC">{{ __('almadina.vitaminC') }}</label>
                                    <input type="text" class="form-control" id="vitaminC"
                                        placeholder="{{ __('almadina.vitaminC') }}">
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
        axios.post('/almadina/admin/nutritionalValues', {
          product_id : document.getElementById('product_id').value ,
          energy : document.getElementById('energy').value ,
          fatty : document.getElementById('fatty').value ,
          proteins : document.getElementById('proteins').value ,
          carbohydrates : document.getElementById('carbohydrates').value ,
          vitaminC : document.getElementById('vitaminC').value ,
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
