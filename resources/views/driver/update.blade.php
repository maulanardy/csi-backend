@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver Pages
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="{{ url('drivers') }}">Supir</a></li>
        <li class="active">Form</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Create Driver</h3>
        </div>
        <div class="box-body">
            {{--  sub menu  --}}
            <div style="margin-bottom: 20px">
                 <a href="{{ url('drivers') }}" class="btn bg-olive"><span>Data</span></a>
            </div>
            {{--  end of sub menu  --}}

            {{--  table data of driver  --}}

                <form class="form-horizontal" action="{{ url('drivers/'.$drivers->id.'/update') }}" role="form" id="f-create-driver" method="post" enctype="multipart/form-data">
                 @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="nik" class="col-sm-2 control-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nik" name="nik" placeholder="Nomer KTP" minlength='16' maxlength='16' required value="{{ $drivers->nik }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Driver Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Driver name" required value="{{ $drivers->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="car_code" class="col-sm-2 control-label">Default Car</label>
                        <div class="col-sm-10">
                        <select class="form-control" id="car_code" name="car_id">
                            @foreach ($cars as $car)
                                <option value="{{ $car['id'] }}" {{ ($car['id'] == $drivers->default_car_id ? "selected" : "") }} >{{ $car['name'] }}</option>
                            @endforeach
                            
                        </select>
                        </div>
                    </div>
                    <!-- Username -->
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required value="{{ $drivers->username }}">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Change Password</label>
                        <div class="col-sm-10">
                        <input type="checkbox" id="changePass">
                        <span>
                            <div class="input-group" id="input-password">
                              <input type="password" class="form-control" name="password" id="txtPassword">

                              <div class="input-group-addon">
                                <input type="checkbox" id="showPassword" checked>
                                <label for="showPassword">
                                <i class="fa fa-eye-slash"></i></label>
                              </div>
                            </div>
                        </span>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="no_telp" class="col-sm-2 control-label">No Telphone</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No Telp" required value="{{ @$drivers->no_telp }}">
                        </div>
                    </div>

                    <div class="form-group">
                            <label for="picture" class="col-sm-2 control-label">Picture</label>
                            <div class="col-sm-10">
                                <img src="{{ asset('uploads/drivers/'.$drivers->picture) }}" width="50%" style="margin-bottom: 1%">
                                <input type="file" class="form-control" id="picture" name="picture">
                            </div>
                    </div>


                   
                    <div class="modal-footer">
                        {{--  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  --}}
                        <button type="submit" class="btn btn-success" id="btn-create-driver">Create driver</button>
                    </div>
                </form>

            <!-- end of modal create driver -->

        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection

@push('script')
<script src="{{ asset('js/validation.js') }}"></script>
<script>
$(function(){
    $("#input-password").hide();

    $("#changePass").change(function(){
        if($(this).is(":checked")){
            $("#input-password").show();
        } else {
             $("#input-password").hide();
        }
    })
});
</script>
@endpush