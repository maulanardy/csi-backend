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

                <form class="form-horizontal" action="{{ url('drivers/insert') }}" role="form" id="f-create-driver" method="post" enctype="multipart/form-data">
                 @method('post')
                    @csrf
                    <div class="form-group">
                        <label for="nik" class="col-sm-2 control-label">NIK</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Nomer KTP" minlength='16' maxlength='16' required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Driver Name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Driver name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="car_code" class="col-sm-2 control-label">Default Car</label>
                        <div class="col-sm-10">
                        <select class="form-control" id="car_code" name="car_id">
                            @foreach ($cars as $car)
                                <option value="{{ $car['id'] }}">{{ $car['name'] }}</option>
                            @endforeach
                            
                        </select>
                        </div>
                    </div>
                    <!-- Username -->
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                        <div class="input-group">
                          <input type="password" class="form-control" name="password" id="txtPassword">

                          <div class="input-group-addon">
                            <input type="checkbox" id="showPassword" checked>
                            <label for="showPassword">
                            <i class="fa fa-eye-slash"></i></label>
                          </div>
                        </div>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="no_telp" class="col-sm-2 control-label">No Telphone</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No Telp" required>
                        </div>
                    </div>

                    <div class="form-group">
                            <label for="picture" class="col-sm-2 control-label">Picture</label>
                            <div class="col-sm-10">
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
    
    function initialize(){
        $("#picture").fileinput({'showUpload':false, 'previewFileType':'any'});
    }

       
    initialize();
    validate();

    $("#showPassword").change(function(){
        if($(this).is(":checked"))
        {
            // Hide Password
            $(this).closest("div").find('label i').removeClass('fa-eye');
            $(this).closest("div").find('label i').addClass('fa-eye-slash');
            $("#txtPassword").attr("type", "password");
        }
        else
        {
            // Show password
            $(this).closest("div").find('label i').removeClass('fa-eye-slash');
            $(this).closest("div").find('label i').addClass('fa-eye');
            $("#txtPassword").attr("type", "text");
        }
    });

    
});
</script>
@endpush
