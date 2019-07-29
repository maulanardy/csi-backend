@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengelolaan Data Base Mobil
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Mobil</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
            @if(session()->get('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}  
                </div><br />
            @endif

            {{--  sub menu  --}}
            <div style="margin-bottom: 20px">
                 <a href="#" class="btn bg-olive" data-target="#create" data-toggle="modal"><span>Input</span></a>
            </div>
            {{--  end of sub menu  --}}

            {{--  table data of car  --}}
            <div>
                <table id="table-car" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Mobil</th>
                            <th>No Plat Mobil</th>
                            <th>Available</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                   
                </table>
            </div>
            {{--  end of car data  --}}

            <!-- Modal Create Car -->
            <div class="modal fade modal-create" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Add Car</h4>
                    </div>

                    <form class="form-horizontal" role="form" id="f-create-car" action="{{ url('cars') }}" enctype="multipart/form-data" method="POST">
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Car Name</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Car name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="license" class="col-sm-2 control-label">License</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" name="license" id="license" placeholder="License">
                                </div>
                            </div>
                            <div class="form-group">
                                    <label for="picture" class="col-sm-2 control-label">Picture</label>
                                    <div class="col-sm-10">
                                    <input type="file" class="form-control" id="picture" name="picture">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label for="active" class="col-sm-2 control-label">Active</label>
                                    <div class="col-sm-10">
                                       <input type="checkbox" checked name="is_active">
                                    </div>
                            </div>
                            {{ csrf_field() }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-create-car" name="submit">Create Car</button>
                    </div>

                    </form>
                    </div>
                    </form>
                </div>
            </div>
            <!-- end of modal create car -->


            <!-- Modal update Car -->
            <div class="modal fade modal-update" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Update Car</h4>
                    </div>

                    <form class="form-horizontal" role="form" id="f-update-car" enctype="multipart/form-data">

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Car Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name_update" name="name" placeholder="Car name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="license" class="col-sm-2 control-label">License</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="license" id="license_update" placeholder="License">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="picture" class="col-sm-2 control-label">Picture</label>
                                <div class="col-sm-10">
                                    <img src="{{ asset('uploads') }}/cars/1549354055.png" width="100%">
                                    <input type="file" class="form-control" id="picture_update" name="picture">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="active" class="col-sm-2 control-label">Active</label>
                                <div class="col-sm-10">
                                   <select name="is_active" id="cbActive_update" class="form-control">
                                       <option value="1">Active</option>
                                       <option value="0">Non Active</option>
                                   </select>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-update-car">update Car</button>
                    </div>

                    </form>
                    </div>
                </div>
            </div>
            <!-- end of modal update car -->

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
    var id;
    // AJAX SETUP FOR UPLOAD
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(".modal-create").modal({
        keyboard: false,
        backdrop: 'static',
        show: false
    });

    var dataTable;
    function dataTableCars(){
        dataTable =  $('#table-car').DataTable({
            "ajax" : {
                url : "{{ asset('cars/data') }}",
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
                    "targets": 4
                }
            ],
            "columns" : [
                { "data" : "no",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { "data" : "name"},
                { "data" : "license"},
                { 
                    "data" : "is_available",
                    "render" : function(data){
                        if(data == 1)
                            return "<button class='avail btn btn-warning btn-xs'>AVAILABLE</button>";

                        return "<button class='notavail btn btn-success btn-xs'>NOT AVAILABLE</button>";
                    }
                },
                { "data": "id"}
            ],
            select : true
            
        });
    }
    function initialize(){
        dataTableCars();
        getData();
    }

    function getData(){
        var url = "{{ asset('cars/data') }}";
        $.get(url, function(data){
            console.log(data);
        });
    }
    
    initialize();

    $('#f-create-car').submit(function(e){
        e.preventDefault();
        var data = $('#f-create-car').serializeArray();
        var url = "{{ url('cars') }}";
        // $.post(url,data, function(status){
        //     dataTable.ajax.reload();
        //     $('#create').modal('hide');
        //     console.log(status);
        // });
        var fd = new FormData();
        fd.append('name', data[0].value);
        fd.append('license', data[1].value);
        fd.append('is_active', data[2].value);
        fd.append('_token', data[3].value);
        fd.append('picture', $("#picture")[0].files[0]);
        $.ajax({
            url: url,
            type: 'POST',
            data: fd,
            cache: false,
            dataType: 'JSON',
            contentType: false,
            processData: false,
        })
        .done(function(response) {
            console.log(response.status);
            $(".modal-create").modal('hide');
            $('#name').val('');
            $('#license').val('');
            $('#picture').val('');
            dataTable.ajax.reload();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    });

// UPDATE CAR
    $('#f-update-car').submit(function(e){
        e.preventDefault();
        // var data = $(this).serializeArray();
        var url = "{{ url('cars') }}/"+id;
        // $.post(url,data, function(status){
        //     dataTable.ajax.reload();
        //     $('#create').modal('hide');
        //     console.log(status);
        // });
        var fd = new FormData();
        fd.append('name', $(this).find("#name_update").val());
        fd.append('license', $(this).find("#license_update").val());
        fd.append('is_active', $(this).find("#cbActive_update").val());
        fd.append('_token', $(this).find("input[type='hidden']").val());
        fd.append('picture', $(this).find("#picture_update")[0].files[0]);
        // console.log("data " + data);
        // console.log(data);
        $.ajax({
            url: url,
            type: 'PATCH',
            data: fd,
            cache: false,
            dataType: 'JSON',
            contentType: false,
            processData: false,
        })
        .done(function(response) {
            console.log(response.status);
            $(".modal-update").modal('hide');
            $('#name_update').val('');
            $('#license_update').val('');
            $('#picture_update').val('');
            dataTable.ajax.reload();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
        
    });
    $('#table-car').on('click','.hapus',function(){
        id = $(this).data("id");
        $('#modal-konfirmasi .modal-body').text('Apakah data ini akan dihapus?');
        $('#modal-konfirmasi').modal('show');
    })

    $("#table-car").on('click', '.edit', function(){
        id = $(this).data("id");
        $(location).attr('href', '{{ url('cars') }}/' + id + '/edit')
        // $.get("{{ url('cars') }}/"+id, function(response){
        //     let data = response.data;
        //     id = data.id;
        //     let modal = $(".modal-update");
        //     modal.find("#name_update").val(data.name);
        //     modal.find("#license_update").val(data.license);
        //     modal.find('img').attr('src', '{{ asset("uploads") }}/cars/'+data.picture);
        //     console.log(data.is_active);
        //     modal.find('#cbActive_update option').removeAttr('selected');
        //     modal.find('#cbActive_update option[value='+data.is_active+']').attr('selected', 'selected');
        // })
        // .fail(function() {
        //     console.log( "error" );
        // })
        // .always(function() {
        //     $('.modal-update').modal('show');
        // });
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
            url: "cars/"+id,
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
    $("#table-car").on('click','.avail', function(e){
        id = $(this).closest('tr').find('td:eq(0)').text();
        let url = "{{ asset('cars') }}/"+id+"/available";
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
    $("#table-car").on('click', '.notavail', function(e){
        id = $(this).closest('tr').find('td:eq(0)').text();
        let url = "{{ asset('cars') }}/"+id+"/available";
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
