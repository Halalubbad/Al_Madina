@extends('admin.starter')

@section('title','Admin')
@section('page-lg-title',__('almadina.admin'))
@section('main-pg-md-title',__('almadina.edit_password'))
@section('page-md-title',__('almadina.admin'))

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
                        <h3 class="card-title">{{__('almadina.edit_password')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="create-form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="current_password">{{__('almadina.current_password')}}</label>
                                <input type="password" class="form-control" id="current_password"
                                    placeholder="{{__('almadina.current_password')}}">
                            </div>
                            <div class="form-group">
                                <label for="new_password">{{__('almadina.new_password')}}</label>
                                <input type="password" class="form-control" id="new_password"
                                    placeholder="{{__('almadina.new_password')}}">
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">{{__('almadina.new_password_confirmation')}}</label>
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    placeholder="{{__('almadina.new_password_confirmation')}}">
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="button" onclick="performStore()"
                                class="btn btn-primary">{{__('almadina.save')}}</button>
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
{{-- <script src="{{asset('js/axios.js')}}"></script> --}}
<script>
    function performStore() {
        // alert('Perform Store - FUNCTION JS');
        // console.log('performStore');
        
        //application/x-www-form-urlencoded
        axios.put('/almadina/update-password', {
            password: document.getElementById('current_password').value,
            new_password: document.getElementById('new_password').value,
            new_password_confirmation: document.getElementById('new_password_confirmation').value,
        })
        .then(function (response) {
            console.log(response);
            toastr.success(response.data.message);
            document.getElementById('create-form').reset();
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message);
        });
    }
</script>
@endsection