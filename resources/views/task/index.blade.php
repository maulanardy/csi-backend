@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kegiatan Yang Sedang Berjalan (Supir dan Mobil Yang Sedang Bertugas)
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
                            <th>Waktu Mulai Plsn</th>
                            <th>GPS Mulai Plsn</th>
                            <th>Waktu Selesai Renc</th>
                            <th>Tujuan</th>
                            <th>Tamu</th>
                            <th>No HP Tamu</th>
                            <th>Dipesan Oleh</th>
                            <th>Disetujui Oleh</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $k => $task)
                        <tr>
                            <td>{{$k + 1}}</td>
                            <td>{{$task->driver->name}}</td>
                            <td>{{$task->car->name}} - {{$task->car->license}}</td>
                            <td>{{\Carbon\Carbon::parse($task->task_date_start)->format("d M Y H:i")}}</td>
                            <td>{{\Carbon\Carbon::parse($task->started_date)->format("d M Y H:i")}}</td>
                            <td><a target="_blank" href="https://www.google.com/maps?q={{$task->started_latitude}},{{$task->started_longitude}}&ll={{$task->started_latitude}},{{$task->started_longitude}}&z=12">Lihat</a></td>
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
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            {{--  end of car data  --}}

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
$(function(){
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
    }
    
    initialize();
});
</script>
@endpush
