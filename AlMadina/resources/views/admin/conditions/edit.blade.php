@extends('admin.starter')

@section('route', route('conditions.index'))
@section('title', __('almadina.conditions'))
@section('page-lg-title', __('almadina.edit_condition'))
@section('main-pg-title', __('almadina.condition'))
@section('page-md-title', __('almadina.edit_condition'))

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
                        <h3 class="card-title">{{__('almadina.update_condition')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{__('almadina.offer_title')}}</label>
                                <select class="form-control" id="offer_id">
                                    @foreach ($offers as $offer)
                                    <option @if ($condition->offer_id == $offer->id) selected @endif value="{{$offer->id}}">{{$offer->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="condition">{{ __('almadina.condition') }}</label>
                                <input type="text" value="{{$condition->name}}" class="form-control" id="condition"
                                    placeholder="{{ __('almadina.condition') }}">
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="button" onclick="performUpdate('{{$condition->id}}')"
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
        axios.put('/almadina/admin/conditions/{{$condition->id}}', {
          offer_id : document.getElementById('offer_id').value ,
          condition : document.getElementById('condition').value ,
        })
        .then(function (response) {
            console.log(response);
            toastr.success(response.data.message);
            window.location.href = '/almadina/admin/conditions';
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message);
        });
    }
</script>
@endsection