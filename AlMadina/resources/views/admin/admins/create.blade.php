@extends('admin.starter')

@section('title' , __('almadina.create_admin'))
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
                        <h3 class="card-title">{{__('almadina.create_admin')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="create-form">
                        @csrf
                        <div class="card-body">
                            {{-- <div class="form-group">
                                <label>{{__('almadina.roles')}}</label>
                                <select class="form-control" id="role_id">
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label for="name">{{__('almadina.name')}}</label>
                                <input type="text" class="form-control" id="name" placeholder="{{__('almadina.name')}}">
                            </div>
                            <div class="form-group">
                                <label for="email">{{__('almadina.email')}}</label>
                                <input type="email" class="form-control" id="email" placeholder="{{__('almadina.email')}}">
                            </div>
                            <div class="form-group">
                                <label for="password">{{__('almadina.password')}}</label>
                                <input type="password" class="form-control" id="password" placeholder="{{__('almadina.password')}}">
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
        axios.post('/almadina/admin/admins', {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
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