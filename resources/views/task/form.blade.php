@extends('templates.header')

@push('style')

<link rel="stylesheet" type="text/css" href="{{ asset('vendor') }}/jquery-ui/jquery-ui.min.css">
@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Task Pages
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="{{ url('tasks') }}">Task</a></li>
        <li class="active">Form</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Update Task</h3>
        </div>
        <form method="POST" action="{{ url("tasks/$task_id/edit") }}">
            {{ method_field('patch') }}
            <div class="box-body">
                {{--  sub menu  --}}
                <div style="margin-bottom: 20px">
                     <a href="{{ url('tasks') }}" class="btn bg-olive"><span>Back</span></a>
                </div>
                {{--  end of sub menu  --}}
                <div class="container">

                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="driver_id">Driver Name</label>
                                <select name="driver_id" class="form-control" id="driver_id">
                                    <option disabled=""> -- </option>
                                    @foreach( $drivers as $d )
                                    <option value="{{ $d->id }}">{{ $d->id }} - {{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="car_id">Car Name</label>
                                <select name="car_id" class="form-control" id="car_id">
                                    <option disabled=""> -- </option>
                                    @foreach( $cars as $c )
                                    <option value="{{ $c->id }}">{{ $c->name }} - {{ $c->license }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> <!-- End of Row -->

                    <div class="row">

                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="txtDateStart">Start Date</label>
                                    <input type="text" class="form-control" id="task_date_start" placeholder="Task Date Start">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtDateStart">Start Hours</label>
                                    <select class="form-control hours" id="task_hours_start">
                                        <option disabled="">--</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtDateStart">Start Minutes</label>
                                    <select class="form-control minute" id="task_minutes_start">
                                        <option disabled="">--</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="task_date_start" id="txtDateStart">
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="txtDateStart">End Date</label>
                                    <input type="text" class="form-control" id="task_date_end" placeholder="Task Date End">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtDateEnd">End Hours</label>
                                    <select class="form-control hours" id="task_hours_end">
                                        <option disabled="">--</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtDateEnd">End Minutes</label>
                                    <select class="form-control minute" id="task_minutes_end">
                                        <option disabled="">--</option>
                                    </select>
                                </div>
                            </div>
                                <input type="hidden" name="task_date_end" id="txtDateEnd">
                        </div>

                    </div> <!-- End of Row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtDesc">Tasks Description</label>
                                <textarea class="form-control" name="task_description" id="txtDesc"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button class="btn" id="btnAprove">
                                    <i class="fa fa-check"></i> <span>Aprove</span>
                                </button>
                                <button class="btn" id="btnCancel">
                                    <i class="fa fa-eject"></i> <span>Cancel</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtPicName">P.I.C Name</label>
                                <input type="text" name="pic_name" class="form-control" id="txtPicName">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtPicPhone">P.I.C phone</label>
                                <input type="text" name="pic_phone" class="form-control" id="txtPicPhone">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-offset-5 col-md-2">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
                        </div>
                    </div>

                </div>

            </div>
        </form>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection

@push('script')
<script type="text/javascript" src="{{ asset('vendor') }}/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">

var startDate = { date: "", hours: "00", minutes: "00" };
var endDate = { date: "", hours: "00", minutes: "00" };
var data;
    function getIdTask(){
        // let path = window.location.pathname;
        // let paths = path.split("/");
        // return paths[2];
        return "{{ $task_id }}";
    }

    function initialized(){
        $.getJSON("{{ asset('tasks') }}/"+getIdTask(), function(response){
            data = response.data[0];

            $("#driver_id option[value="+data.driver_id+"]").attr('selected', true);
            $("#car_id option[value="+data.car_id+"]").attr('selected', true);

            let ds = data.task_date_start;
            let de = data.task_date_end;

            let date_start = ds.split(" ")[0];
            let time_start = ds.split(" ")[1];

            let date_end = de.split(" ")[0];
            let time_end = de.split(" ")[1];

            startDate = {
                date: date_start.split("-")[0] + "-" + date_start.split("-")[1] + "-" + date_start.split("-")[2],
                hours: time_start.split(":")[0],
                minutes: time_start.split(":")[1]
            }

            endDate = {
                date: date_end.split("-")[0] + "-" + date_end.split("-")[1] + "-" + date_end.split("-")[2],
                hours: time_end.split(":")[0],
                minutes: time_end.split(":")[1]
            }

            if(data.is_draft == 1){
                $("#btnAprove").addClass('btn-primary');
                $("#btnAprove span").text("Aprove");
            } else {
                $("#btnAprove").addClass('btn-success');
                $("#btnAprove span").text("Aproved");
            }

            if(data.is_canceled == 0 || data.is_canceled == null) {
                $("#btnCancel").addClass('btn-warning');
                $("#btnCancel span").text("Cancel");
            } else {
                $("#btnCancel").addClass('btn-danger');
                $("#btnCancel span").text("Canceled");
            }

            if(data.is_finished == 1) {
                $("#btnAprove").attr('disabled', true);
                $("#btnCancel").attr('disabled', true);
            }

            $("#task_date_start").val(startDate.date);
            $("#task_hours_start").val(startDate.hours);
            $("#task_minutes_start").val(startDate.minutes);

            $("#txtDateStart").val(startDate.date+" "+startDate.hours+":"+startDate.minutes+":00");
            $("#txtDateEnd").val(endDate.date+" "+endDate.hours+":"+endDate.minutes+":00");

            $("#task_date_end").val(endDate.date);
            $("#task_hours_end").val(endDate.hours);
            $("#task_minutes_end").val(endDate.minutes);

            $("#txtDesc").text(data.task_description);
            $("#txtPicName").val(data.pic_name);
            $("#txtPicPhone").val(data.pic_phone);
        })
    }
    // Hour Minute Looping
    function addHourMinute(){
        let body = "";
        for(let i = 0; i <= 23; i++){
            body += "<option>"+(i.toString().length == 1 ? "0"+i : i)+"</option>";
        }

        $(".hours").append(body);

        body = "";

        for(let i = 0; i <= 60; i += 5){
            body += "<option>"+(i.toString().length == 1 ? "0"+i : i)+"</option>";
        }

        $(".minute").append(body);
    }


    $(function(){
        initialized();

        // DateTimePicker JqueryUI
        $("#task_date_start").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#task_date_end").datepicker({
            dateFormat: "yy-mm-dd"
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

            addHourMinute();

            // APROVE TASK
            $("#btnAprove").click(function(e){
                e.preventDefault();
                let status = (data.is_draft == 1 ? 0 : 1);
                $.post("{{ url('api/v1') }}/tasks/aprove/"+getIdTask(), { status: status }, function(response){
                    if(response.status){
                        let url = "{{ url('tasks') }}";
                        window.location = url;
                    }
                })
            });

            $("#btnCancel").click(function(e){
                e.preventDefault();
                let status = (data.is_canceled == 1 ? 0 : 1);
                $.post("{{ url('api/v1') }}/tasks/cancel/"+getIdTask(), { status: status }, function(response){
                    if(response.status){
                        let url = "{{ url('tasks') }}";
                        window.location = url;
                    }
                })
            });
    });
</script>
@endpush
