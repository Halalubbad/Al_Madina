@extends('admin.starter')

@section('title',__('almadina.settings'))
@section('page-lg-title',__('almadina.index'))
@section('main-pg-title',__('almadina.settings'))
@section('page-md-title',__('almadina.index'))

@section('styles')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('almadina.settings')}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>{{__('almadina.title')}}</th>
                                    <th>{{__('almadina.instagram')}}</th>
                                    <th>{{__('almadina.facebook')}}</th>
                                    <th>{{__('almadina.twitter')}}</th>
                                    <th>{{__('almadina.youtube')}}</th>
                                    <th>{{__('almadina.email')}}</th>
                                    <th>{{__('almadina.mobile')}}</th>
                                    <th>{{__('almadina.whatsapp')}}</th>
                                    <th>{{__('almadina.sales_manager_mobile')}}</th>
                                    <th>{{__('almadina.customer_followup_mobile')}}</th>
                                    <th>{{__('almadina.disributor_mobile')}}</th>
                                    <th>{{__('almadina.location')}}</th>
                                    <th>{{__('almadina.site_image')}}</th>
                                    <th>{{__('almadina.boss_image')}}</th>
                                    <th>{{__('almadina.boss_name')}}</th>
                                    <th>{{__('almadina.boss_words')}}</th>
                                    <th>{{__('almadina.created_at')}}</th>
                                    <th>{{__('almadina.updated_at')}}</th>
                                    <th style="width: 40px">{{__('almadina.settings')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($settings as $setting)
                                <tr>
                                    <td>{{$setting->id}}</td>
                                    <td>{{$setting->title}}</td>
                                    <td>{{$setting->instagram}}</td>
                                    <td>{{$setting->facebook}}</td>
                                    <td>{{$setting->twitter}}</td>
                                    <td>{{$setting->youtube}}</td>
                                    <td>{{$setting->email}}</td>
                                    <td>{{$setting->mobile}}</td>
                                    <td>{{$setting->whatsapp}}</td>
                                    <td>{{$setting->sales_manager_mobile}}</td>
                                    <td>{{$setting->customer_followup_mobile}}</td>
                                    <td>{{$setting->disributor_mobile}}</td>
                                    <td>{{$setting->location}}</td>
                                    <td>
                                        <img  height="100" src="{{Storage::url($setting->site_image ?? '')}}" />
                                    </td>
                                    <td>
                                        <img  height="100" src="{{Storage::url($setting->boss_image ?? '')}}" />
                                    </td>
                                    <td>{{$setting->boss_name}}</td>
                                    <td>{{$setting->boss_words}}</td>
                                    <td>{{$setting->created_at}}</td>
                                    <td>{{$setting->updated_at}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('settings.edit',$setting->id)}}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {{-- <a href="#" onclick="confirmDelete('{{ $setting->id }}', this)"
                                                class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a> --}}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    // function confirmDelete(id, reference) {
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You won't be able to revert this!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         cancelButtonColor: '#d33',
    //         confirmButtonColor: '#3085d6',
    //         confirmButtonText: 'Yes, delete it!'
    //     }).then((result) => {
    //     if (result.isConfirmed) {
    //         performDelete(id, reference);
    //     }
    //     });
    // }

    // function performDelete(id, reference) {
    //     axios.delete('/almadina/settings/'+id)
    //     .then(function (response) {
    //         console.log(response);
    //         toastr.success(response.data.message);
    //         reference.closest('tr').remove();
    //         showMessage(response.data);
    //     })
    //     .catch(function (error) {
    //         console.log(error.response);
    //         toastr.error(error.response.data.message);
    //         showMessage(error.response.data);
    //     });
    // }

    $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection