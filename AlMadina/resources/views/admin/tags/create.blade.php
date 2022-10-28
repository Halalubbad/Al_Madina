@extends('admin.starter')

@section('title',__('almadina.tags'))
@section('route' , route('tags.index'))
@section('page-lg-title',__('almadina.create_tag'))
@section('main-pg-title',__('almadina.tags'))
@section('page-md-title',__('almadina.create_tag'))

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
                            <h3 class="card-title">{{ __('almadina.add_tag') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{-- enctype="multipart/form-data" --}}
                        <form id="create_form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('almadina.tag_name') }}</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="{{ __('almadina.tag_name') }}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('almadina.parent_id')}}</label>
                                    <select class="form-control" id="parent_id">
                                        <option value="0" selected>{{__('almadina.select_text')}}</option>
                                        @foreach ($parents as $parent)
                                        <option value="{{$parent->id}}">{{$parent->name}}</option>
                                        @endforeach
                                    </select>
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
        axios.post('/almadina/admin/tags', {
          name : document.getElementById('name').value ,
          parent_id : document.getElementById('parent_id').value ,
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
