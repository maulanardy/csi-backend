@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengelolaan Data Base Supir
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Supir</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
            {{--  sub menu  --}}
            <div style="margin-bottom: 20px">
                 {{--  <a href="#" class="btn bg-olive" data-target="#create" data-toggle="modal"><span>Add Data</span></a>  --}}
                <a href="{{ url('drivers/form') }}" class="btn bg-olive" ><span>Input</span></a>
            </div>
            {{--  end of sub menu  --}}

            {{--  table data of driver  --}}
            <div>
                <table id="table-driver" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIK</th>
                            <th>Nama Supir</th>
                            <th>User Name</th>
                            <th>Mobil Default</th>
                            <th>No HP/WA</th>
                            <th>Available</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                   
                </table>
            </div>
            {{--  end of driver data  --}}
            <!-- Modal Create driver -->
            <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Add Driver</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="f-create-driver">
                            <div class="form-group">
                                <label for="nik" class="col-sm-2 control-label">NIK</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Nomer KTP" minlength='16' required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Driver Name</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Driver name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="car_code" class="col-sm-2 control-label">Default Car</label>
                                <div class="col-sm-10">
                                <select class="form-control" id="car_code" name="car_code">
                                    @foreach ($cars as $car)
                                        <option>{{ $car['name'] }}</option>
                                    @endforeach
                                    
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                    <label for="picture" class="col-sm-2 control-label">Picture</label>
                                    <div class="col-sm-10">
                                    <input type="file" class="form-control" id="picture" name="picture">
                                    </div>
                            </div>
        
                            {{ csrf_field() }}
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-create-driver">Create driver</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- end of modal create driver -->

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
<script src="{{ asset('js/validation.js') }}"></script>
<script>
$(function(){
    var dataTable;
    function dataTabledrivers(){
        dataTable =  $('#table-driver').DataTable({
            "ajax" : {
                url : "{{ asset('drivers/data') }}",
                dataSrc : 'data'
            },
            "columnDefs": [
                {
                    // The `data` parameter refers to the data for the cell (defined by the
                    // `data` option, which defaults to the column being worked with, in
                    // this case `data: 0`.
                    "render": function ( data, type, row ) {
                        return `
                        <button data-id="` + data + `" class='edit btn btn-xs btn-warning'><span class='glyphicon glyphicon-pencil'></span></button>
                        <button data-id="` + data + `" class='hapus btn btn-xs btn-danger'><span class='glyphicon glyphicon-trash'></span></button>
                        `;
                    },
                    "targets": 7
                }
            ],
            "columns" : [
                { "data" : "no",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { "data" : "nik"},
                { "data" : "name"},
                { "data" : "username"},
                { "data" : "default_car"},
                { "data" : "no_telp"},
                { 
                    "data" : "is_available",
                    "render" : function(data){
                        if(data == 1)
                            return "<button class='avail btn btn-warning btn-xs'>AVAILABLE</button>";

                        return "<button class='notavail btn btn-success btn-xs'>NOT AVAILABLE</button>";
                    }
                },
                { "data" : "id"}
            ],
            select : true
            
        });
    }
    function initialize(){
        dataTabledrivers();
        $("#picture").fileinput({'showUpload':false, 'previewFileType':'any'});
    }

    function getData(){
        var url = "{{ asset('drivers/data') }}";
        $.get(url, function(data){
            console.log(data);
        });
    }
    
    initialize();

    $('#btn-create-driver').click(function(){
        validate();
        // var data = $('#f-create-driver').serializeArray();
        // var url = "{{ url('drivers') }}";
        // $.post(url,data, function(status){
        //     dataTable.ajax.reload();
        //     $('#create').modal('hide');
        //     console.log(status);
        // });
        
    });
    var id;
    $('#table-driver').on('click','.hapus',function(){
        id = $(this).data("id");
        $('#modal-konfirmasi .modal-body').text('Apakah data ini akan dihapus?');
        $('#modal-konfirmasi').modal('show');
    })

    // EDIT DATA
    $("#table-driver").on('click', '.edit', function(){
        id = $(this).data("id");
        window.location = '{{ url("drivers") }}/'+id+'/edit';
    })

    $('#btn-hapus').click(function(){
        
        console.log(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax(
        {
            url: "drivers/"+id,
            type: 'delete', // replaced from put
            dataType: "JSON",
            data: {
                "id": id // method and token not needed in data
            },
            success: function (response)
            {
                console.log(response); // see the reponse sent
                dataTable.ajax.reload();
                $('#modal-konfirmasi').modal('hide');
            },
            error: function(xhr) {
            console.log(xhr.responseText); // this line will save you tons of hours while debugging
            // do something here because of error
        }
        });
    });

    // AVAILABLE BUTTON CLICK
    $("#table-driver").on('click','.avail', function(e){
        id = $(this).closest('tr').find('td:eq(0)').text();
        let url = "{{ asset('drivers') }}/"+id+"/available";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'POST',
            data: { is_available: 0},
        })
        .done(function() {
            dataTable.ajax.reload();
        });
        
    });

    // NOT AVAILABLE BUTTON CLICK
    $("#table-driver").on('click', '.notavail', function(e){
        id = $(this).closest('tr').find('td:eq(0)').text();
        let url = "{{ asset('drivers') }}/"+id+"/available";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'POST',
            data: { is_available: 1},
        })
        .done(function() {
            dataTable.ajax.reload();
        });
        
    });
});
</script>
@endpush
