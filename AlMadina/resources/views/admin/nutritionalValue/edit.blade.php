@extends('admin.starter')

@section('route', route('nutritionalValues.index'))
@section('title', __('almadina.nutritionalValues'))
@section('page-lg-title', __('almadina.edit_nutritionalValues'))
@section('main-pg-title', __('almadina.nutritionalValues'))
@section('page-md-title', __('almadina.edit_nutritionalValues'))

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
                        <h3 class="card-title">{{__('almadina.update_nutritionalValues')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{__('almadina.product_name')}}</label>
                                <select class="form-control" id="product_id">
                                    @foreach ($products as $product)
                                    <option @if ($nutritionalValue->product_id == $product->id) selected @endif value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="energy">{{ __('almadina.energy') }}</label>
                                <input type="text" value="{{$nutritionalValue->energy}}" class="form-control" id="energy"
                                    placeholder="{{ __('almadina.energy') }}">
                            </div>
                            <div class="form-group">
                                <label for="fatty">{{ __('almadina.fatty') }}</label>
                                <input type="text" value="{{$nutritionalValue->fatty}}" class="form-control" id="fatty"
                                    placeholder="{{ __('almadina.fatty') }}">
                            </div>
                            <div class="form-group">
                                <label for="proteins">{{ __('almadina.proteins') }}</label>
                                <input type="text" value="{{$nutritionalValue->proteins}}" class="form-control" id="proteins"
                                    placeholder="{{ __('almadina.proteins') }}">
                            </div>
                            <div class="form-group">
                                <label for="carbohydrates">{{ __('almadina.carbohydrates') }}</label>
                                <input type="text" value="{{$nutritionalValue->carbohydrates}}" class="form-control" id="carbohydrates"
                                    placeholder="{{ __('almadina.carbohydrates') }}">
                            </div>
                            <div class="form-group">
                                <label for="vitaminC">{{ __('almadina.vitaminC') }}</label>
                                <input type="text" value="{{$nutritionalValue->vitaminC}}" class="form-control" id="vitaminC"
                                    placeholder="{{ __('almadina.vitaminC') }}">
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="button" onclick="performUpdate('{{$nutritionalValue->id}}')"
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

<script>

    function performUpdate(id) {
        axios.put('/almadina/admin/nutritionalValues/{{$nutritionalValue->id}}', {
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
            window.location.href = '/almadina/admin/nutritionalValues';
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message);
        });
    }
</script>
@endsection