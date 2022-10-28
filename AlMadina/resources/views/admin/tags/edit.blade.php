@extends('admin.starter')

@section('title', __('almadina.tag'))
@section('page-lg-title', __('almadina.edit'))
@section('main-pg-title', __('almadina.update_tag'))
@section('page-md-title', __('almadina.edit'))

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
                        <h3 class="card-title">{{__('almadina.update_tag')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="create-form">
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">{{ __('almadina.name') }}</label>
                                <input type="text" class="form-control" id="name" value="{{ $tag->name }}"
                                    placeholder="{{ __('almadina.name') }}">
                            </div>

                            <div class="form-group">
                                <label>{{__('almadina.parent_id')}}</label>
                                <select class="form-control" id="parent_id">
                                    <option value="0" @if($tag->parent_id = 0) selected @endif>{{__('almadina.select_text')}}</option>
                                    @foreach ($parents as $parent)
                                    <option value="{{$parent->id}}" @if($tag->parent_id = $parent->id) selected @endif>{{$parent->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="button" onclick="performUpdate('{{$tag->id}}')"
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
        // alert('PERFORM')
        axios.put('/almadina/admin/tags/{{$tag->id}}', {
            name: document.getElementById('name').value,
            parent_id: document.getElementById('parent_id').value,
        })
        .then(function(response) {
            console.log(response);
            toastr.success(response.data.message);
            window.location.href = '/almadina/tags';
        })
        .catch(function(error) {
            console.log(error);
            toastr.error(error.response.data);
        });
    }
</script>
@endsection