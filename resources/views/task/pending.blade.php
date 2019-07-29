@extends('templates.header')

@section('content')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kegiatan Yang Menunggu Pesetujuan
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
                            <th width="10%">Tujuan</th>
                            <th>Tamu</th>
                            <th>No HP Tamu</th>
                            <th>Dipesan Oleh</th>
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
                            <td>{{
                            $task->is_canceled == 1 ? "BATAL" : 
                            ($task->is_finished == 1 ? "SELESAI" :
                            ($task->is_started == 1 ? "DI JALAN" :
                            ($task->is_draft == 1 ? "MENUNGGU" : "AKAN")))
                            }}</td>
                            <td>
                              <button data-id="{{$task->id}}" class="aprove btn btn-primary btn-xs">
                                <i class="fa fa-check"></i> <span>Aprove</span>
                              </button>
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
        dataTable =  $('#table-car').DataTable({
            // "ajax" : {
            //     url : "{{ asset('tasks/data/pending') }}",
            //     dataSrc : 'data'
            // },
            // "columnDefs": [
            //     {
            //         // The `data` parameter refers to the data for the cell (defined by the
            //         // `data` option, which defaults to the column being worked with, in
            //         // this case `data: 0`.
            //         "render": function ( data, type, row ) {
            //             return `
            //             <button data-id="` + data + `" class="aprove btn btn-primary btn-xs">
            //                 <i class="fa fa-check"></i> <span>Aprove</span>
            //             </button>
            //             <button data-id="` + data + `" class="cancel btn btn-warning btn-xs">
            //                 <i class="fa fa-eject"></i> <span>Cancel</span>
            //             </button>
            //             <button data-id="` + data + `" class='edit btn btn-xs btn-warning'>
            //                 <span class='glyphicon glyphicon-pencil'></span>
            //             </button>
            //             <button data-id="` + data + `" class='hapus btn btn-xs btn-danger'>
            //                 <span class='glyphicon glyphicon-trash'></span>
            //             </button>`;
            //         },
            //         "targets": 11
            //     }
            // ],
            // "columns" : [
            //     { "data" : "no",
            //     render: function (data, type, row, meta) {
            //         return meta.row + meta.settings._iDisplayStart + 1;
            //     }},
            //     { "data" : "driver_name"},
            //     { "data" : "car_name"},
            //     { "data" : "task_date_start"},
            //     { "data" : "task_date_end"},
            //     { "data" : "task_description"},
            //     { "data" : "pic_name"},
            //     { "data" : "pic_phone"},
            //     { "data" : "created_name" },
            //     { "data" : "canceled_name" },
            //     { "data" : "status" },
            //     { "data" : "id"}
            // ],
            // select : true
            
        });
    }

    function addbutton(){
        // let count;
        // let table = $("#table-car tbody");
        // $.get("{{ asset('tasks/data') }}", function(response){
        //     count = response.data.length;

        //     for(let i = 0; i < count; i++){
        //         let status =table.find("tr:eq("+i+")").find("td:eq(8)").text();
        //         if(status == "CANCELED" || status == "FINISHED") {
        //             table.find("tr:eq("+i+")").find('td:eq(9)').find('.aprove').hide();
        //             table.find("tr:eq("+i+")").find('td:eq(9)').find('.cancel').hide();
        //         } else if(status == "OPEN" || status == "STARTED") {
        //             // table.find("tr:eq("+i+")").find('td:eq(9)').find('.aprove').hide();
        //         }
        //     }
        // });
    }
    function initialize(){
        dataTableTask();
        addbutton();
        // getData();
    }

    // function getData(){
    //     var url = "{{ asset('cars/data') }}";
    //     $.get(url, function(data){
    //         console.log(data);
    //     });
    // }
    
    initialize();

    // $('#btn-create-car').click(function(){
    //     var data = $('#f-create-car').serializeArray();
    //     var url = "{{ url('cars') }}";
    //     $.post(url,data, function(status){
    //         dataTable.ajax.reload();
    //         $('#create').modal('hide');
    //         console.log(status);
    //     });
        
    // });
    var id;

    $('#table-car').on('click','.hapus',function(){
        id = $(this).data('id');
        $('#modal-konfirmasi .modal-body').text('Apakah data ini akan dihapus?');
        $('#modal-konfirmasi').modal('show');
    });

    // If Edit Button Clicked
    // $('#table-car').on('click','.edit',function(){
    //     var currentRow = $(this).closest('tr');
    //     id = currentRow.find('td:eq(0)').text();
    //     $modalUpdate = $(".modal-update");

    //     var countCar = $modalUpdate.find("#car_id option").size();
    //     var countDriver = $modalUpdate.find("#driver_id option").size();

    //     var data = {};
    //     // let driverName = currentRow.find('td:eq(1)').text();
    //     // let carName = currentRow.find('td:eq(2)').text();
    //     // let dateStart = currentRow.find('td:eq(3)').text();
    //     // let dateEnd = currentRow.find('td:eq(4)').text();
    //     // let desc = currentRow.find('td:eq(5)').text();
    //     // let picName = currentRow.find('td:eq(6)').text();
    //     // let picPhone = currentRow.find('td:eq(7)').text();
    //     $.get("{{ asset('tasks') }}/"+id, function(response){
    //         data = response.data;

    //         // SELECTED CAR
    //         for(let i = 0; i < countCar; i++) {
    //             if($modalUpdate.find("#car_id option:eq("+i+")").val() == data[0].car_id)
    //             {
    //                 $modalUpdate.find("#car_id option:eq("+i+")").attr('selected',true);
    //             }
    //             else
    //             {
    //                 $modalUpdate.find("#car_id option:eq("+i+")").attr('selected',false);
    //             }
    //         }

    //         // SELECTED DRIVER
    //         for(let i = 0; i < countDriver; i++) {
    //             if($modalUpdate.find("#driver_id option:eq("+i+")").val() == data[0].driver_id)
    //             {
    //                 $modalUpdate.find("#driver_id option:eq("+i+")").attr('selected',true);
    //             }
    //             else
    //             {
    //                 $modalUpdate.find("#driver_id option:eq("+i+")").attr('selected',false);
    //             }
    //         }

    //         // $modalUpdate.find("#car_id option[value="+data[0].car_id+"]").attr('selected',true);
    //         $('.modal-update').modal('show');

    //     });
        
    // })

     // If Edit Button Clicked
    $('#table-car').on('click','.edit',function(){
        id = $(this).data('id');
        window.location = "{{ url('tasks') }}/"+id+"/edit";
    });

    // CLICKED APROVE BUTTON
    $('#table-car').on('click','.aprove',function(){
        id = $(this).data('id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post("{{ url('tasks') }}/"+id+"/approve", { status: 0 }, function(response){
            if(response.status){
                // initialize();
                window.location = "{{ url('tasks/pending') }}";
        addbutton();
            }
        })
    });

    // CLICKED CANCEL BUTTON
    $('#table-car').on('click','.cancel',function(){
        id = $(this).data('id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post("{{ url('tasks') }}/"+id+"/cancel", { status: 1 }, function(response){
                    if(response.status){
                        // initialize();
                        window.location = "{{ url('tasks/pending') }}";        addbutton();
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
            url: "{{ url('tasks') }}/"+id,
            type: 'delete', // replaced from put
            dataType: "JSON",
            data: {
                "id": id // method and token not needed in data
            },
            success: function (response)
            {
                console.log(response); // see the reponse sent
                window.location = "{{ url('tasks/pending') }}";
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
