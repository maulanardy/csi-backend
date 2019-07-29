@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kegiatan Yang Sudah Disetujui & Menunggu Pelaksanaan (Supir dan Mobil Yang Akan Bertugas)
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Tasks</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
            {{--  sub menu  --}}
            @php 
            if(Request::get('dr') && Request::get('dr') !== "all"){
                $tasks = $tasks->where('driver_id', Request::get('dr'));
            }

            if(Request::get('cr') && Request::get('cr') !== "all"){
                $tasks = $tasks->where('car_id', Request::get('cr'));
            }
            @endphp
            <form method="get" style="margin-bottom: 20px" action="" class="form-inline float-right">
              <label class="" for="inlineFormCustomSelectPref">filter: </label>
              <select name="dr" class="form-control input-sm" id="dr">
                <option value="all" selected>-- All Drivers--</option>
                @foreach($drivers as $driver)
                <option value="{{$driver->id}}" {{Request::get('dr') == $driver->id ? "selected" : ""}}>{{$driver->name}}</option>
                @endforeach
              </select>
              <select name="cr" class="form-control input-sm" id="cr">
                <option value="all" selected>-- All Cars--</option>
                @foreach($cars as $car)
                <option value="{{$car->id}}" {{Request::get('cr') == $car->id ? "selected" : ""}}>{{$car->name}} - {{$car->license}}</option>
                @endforeach
              </select>
              <button type="submit" class="btn btn-primary btn-sm my-1">Apply</button>
              <a href="#" class="btn bg-olive pull-right" data-target="#create" data-toggle="modal"><span>Tambah Kegiatan</span></a>
            </form>
            {{--  end of sub menu  --}}

            {{--  table data of car  --}}
            <div class="table-responsive">
                <table id="table-car" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Supir</th>
                            <th>Mobil</th>
                            <th>Waktu Mulai Renc</th>
                            <th>Waktu Selesai Renc</th>
                            <th>Tujuan</th>
                            <th>Tamu</th>
                            <th>No HP Tamu</th>
                            <th>Dipesan Oleh</th>
                            <th>Disetujui Oleh</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $k => $task)
                        <tr>
                            <td>{{$k + 1}}</td>
                            <td>{{$task->driver->name}}</td>
                            <td>{{$task->car->name}} - {{$task->car->license}}</td>
                            <td>{{\Carbon\Carbon::parse($task->task_date_start)->format("d M Y H:i")}}</td>
                            <td>{{\Carbon\Carbon::parse($task->task_date_end)->format("d M Y H:i")}}</td>
                            <td>{{$task->task_description}}</td>
                            <td>{{$task->pic_name}}</td>
                            <td>{{$task->pic_phone}}</td>
                            <td>{{$task->requestedBy->name}}</td>
                            <td>{{$task->approved_by ? $task->approvedBy->name : "-"}}</td>
                            <td>{{
                            $task->is_canceled == 1 ? "BATAL" : 
                            ($task->is_finished == 1 ? "SELESAI" :
                            ($task->is_started == 1 ? "DI JALAN" :
                            ($task->is_draft == 1 ? "MENUNGGU" : "AKAN")))
                            }}</td>
                            <td>
                              <button data-id="{{$task->id}}" class="cancel btn btn-warning btn-xs">
                                <i class="fa fa-eject"></i> <span>Cancel</span>
                              </button>
                              <button data-id="{{$task->id}}" class='edit btn btn-xs btn-warning'>
                                <span class='glyphicon glyphicon-pencil'></span>
                              </button>
                              <button data-id="{{$task->id}}" class='hapus btn btn-xs btn-danger'>
                                <span class='glyphicon glyphicon-trash'></span>
                              </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            {{--  end of car data  --}}

            <!-- Modal Create Car -->
            <div class="modal fade modal-create" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Add Tasks</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="f-create-car" method="POST" action="{{ url('tasks') }}">

                            <!-- Driver Id -->
                            <div class="form-group">
                                <label for="driver_id" class="col-sm-4 control-label">Supir</label>
                                <div class="col-sm-8">
                                <!-- <input type="text" class="form-control" id="driver_id" name="driver_id" placeholder="Driver Id"> -->
                                <select name="driver_id" class="form-control">
                                    @foreach( $drivers as $d )
                                    <option value="{{ $d->id }}">{{ $d->name }} - {{ $d->car->name }} - {{ $d->car->license }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>

                            <!-- Car ID -->
                            <div class="form-group">
                                <label for="car_id" class="col-sm-4 control-label">Mobil</label>
                                <div class="col-sm-8">
                                <!-- <input type="text" class="form-control" id="car_id" name="car_id" placeholder="Car ID"> -->
                                <select name="car_id" class="form-control">
                                    <option value="0"> -- Use default car -- </option>
                                    @foreach( $cars as $c )
                                    <option value="{{ $c->id }}">{{ $c->name }} - {{ $c->license }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>

                            <!-- Task Date Start -->
                            <div class="form-group">
                                <label for="task_date_start" class="col-sm-4 control-label">Waktu Mulai Rncn</label>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p>Tanggal</p>
                                            <input type="text" class="form-control" value="{{date("Y-m-d")}}" name="date_start" id="task_date_start">
                                        </div>
                                        <div class="col-sm-4">
                                            <p>Jam</p>
                                            <select class="form-control hours" id="task_hours_start" name="hour_start">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <p>Menit</p>
                                            <select class="form-control minute" id="task_minutes_start" name="minute_start">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="{{date("Y-m-d H:00:00")}}" id="txtDateStart">
                            </div>

                            <!-- Task Date End -->
                            <div class="form-group">
                                <label for="task_date_end" class="col-sm-4 control-label">Waktu Selesai Rncn</label>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p>Tanggal</p>
                                            <input type="text" class="form-control" value="{{date("Y-m-d")}}" id="task_date_end" name="date_end">
                                        </div>
                                        <div class="col-sm-4">
                                            <p>Jam</p>
                                            <select class="form-control hours" id="task_hours_end" name="hour_end">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <p>Menit</p>
                                            <select class="form-control minute" id="task_minutes_end" name="minute_end">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="{{date("Y-m-d H:00:00")}}" id="txtDateEnd">
                            </div>

                            <!-- Task Description -->
                            <div class="form-group">
                                    <label for="task_description" class="col-sm-4 control-label">Tujuan</label>
                                    <div class="col-sm-8">
                                    <!-- <input type="text" class="form-control" id="task_description" name="task_description"> -->
                                    <textarea required="required" class="form-control" placeholder="Masukan keterangan kegiatan, lokasi tujuan, serta bersama siapa kegiatan berlangsung" name="task_description" rows="3"></textarea>
                                    </div>
                            </div>

                            <!-- pic_name -->
                            <div class="form-group">
                                    <label for="picture" class="col-sm-4 control-label">Nama Tamu</label>
                                    <div class="col-sm-8">
                                    <input required="required" type="text" class="form-control" id="picture" placeholder="di request oleh" name="pic_name">
                                    </div>
                            </div>

                            <!-- pic phone -->
                            <div class="form-group">
                                    <label for="pic_phone" class="col-sm-4 control-label">No HP Tamu</label>
                                    <div class="col-sm-8">
                                    <input required="required" type="text" class="form-control" id="pic_phone" placeholder="no handphone" value="" name="pic_phone">
                                    </div>
                            </div>

                            <!-- <div class="form-group">
                                <label for="active" class="col-sm-2 control-label">Active</label>
                                <div class="col-sm-10">
                                   <input type="checkbox" checked name="active">
                                </div>
                            </div> -->
                            {{ csrf_field() }}
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- end of modal create car -->

            <!-- modal konfirmasi -->
   
            <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
                    </div>
                    <div class="modal-body">
                        test
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-hapus">Yes</button>
                    </div>
                    </div>
                </div>
                </div>
            <!-- end of modal konfirmais -->
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
<script>
var startDate = { date: "", hours: "00", minutes: "00" };
var endDate = { date: "", hours: "00", minutes: "00" };
$(function(){

    // DateTimePicker JqueryUI
    $("#task_date_start").datepicker({
        format: "yyyy-mm-dd"
    });
    $("#task_date_end").datepicker({
        format: "yyyy-mm-dd"
    });

    // Date Time Picker Methods
    // Start
        $("#task_date_start").change(function(){
            startDate.date = $(this).val();
            $("#txtDateStart").val(startDate.date+" "+startDate.hours+":"+startDate.minutes+":00");
        });

        $("#task_hours_start").change(function(){
            startDate.hours = $(this).val();
            $("#txtDateStart").val(startDate.date+" "+startDate.hours+":"+startDate.minutes+":00");
        });

        $("#task_minutes_start").change(function(){
            startDate.minutes = $(this).val();
            $("#txtDateStart").val(startDate.date+" "+startDate.hours+":"+startDate.minutes+":00");
        });

    // END
        $("#task_date_end").change(function(){
            endDate.date = $(this).val();
            $("#txtDateEnd").val(endDate.date+" "+endDate.hours+":"+endDate.minutes+":00");
        });

        $("#task_hours_end").change(function(){
            endDate.hours = $(this).val();
            $("#txtDateEnd").val(endDate.date+" "+endDate.hours+":"+endDate.minutes+":00");
        });

        $("#task_minutes_end").change(function(){
            endDate.minutes = $(this).val();
            $("#txtDateEnd").val(endDate.date+" "+endDate.hours+":"+endDate.minutes+":00");
        });

    // Hour Minute Looping
    function addHourMinute(){
        let body = "";
        for(let i = 0; i <= 23; i++){
            body += "<option " + (moment().format('H') == i ? "selected" : "") + ">"+(i.toString().length == 1 ? "0"+i : i)+"</option>";
        }

        $(".hours").append(body);

        body = "";

        for(let i = 0; i <= 60; i += 15){
            body += "<option>"+(i.toString().length == 1 ? "0"+i : i)+"</option>";
        }

        $(".minute").append(body);
    }

    addHourMinute();

    // Modal Function
    $(".modal-create").modal({
        keyboard: false,
        backdrop: 'static',
        show: false
    })

    var dataTable;

    function dataTableTask(){
        dataTable =  $('#table-car').DataTable({});
    }

    function initialize(){
        dataTableTask();
        // getData();
    }
    
    initialize();

    var id;

    $('#table-car').on('click','.hapus',function(){
        id = $(this).data('id');
        $('#modal-konfirmasi .modal-body').text('Apakah data ini akan dihapus?');
        $('#modal-konfirmasi').modal('show');
    });

     // If Edit Button Clicked
    $('#table-car').on('click','.edit',function(){
        id = $(this).data('id');
        window.location = "{{ url('tasks') }}/"+id+"/edit";
    });

    // CLICKED CANCEL BUTTON
    $('#table-car').on('click','.cancel',function(){
        id = $(this).data('id');
        $.post("{{ url('api/v1') }}/tasks/cancel/"+id, { status: 1 }, function(response){
                    if(response.status){
                        // initialize();
                        window.location = "{{ url('tasks/approved') }}";
                    }
                })
    });

    $('#btn-hapus').click(function(){
        
        console.log(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax(
        {
            url: "/tasks/"+id,
            type: 'delete', // replaced from put
            dataType: "JSON",
            data: {
                "id": id // method and token not needed in data
            },
            success: function (response)
            {
                console.log(response); // see the reponse sent
                window.location = "{{ url('tasks/approved') }}";
                $('#modal-konfirmasi').modal('hide');
            },
            error: function(xhr) {
            console.log(xhr.responseText); // this line will save you tons of hours while debugging
            // do something here because of error
        }
        });
    });
});
</script>
@endpush
