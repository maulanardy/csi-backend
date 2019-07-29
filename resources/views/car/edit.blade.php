@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Car Pages
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Mobil</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        {{-- @dd($car) --}}

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Data</h3>
        </div>
        <div class="box-body">
          <form method="post" action="{{ url('cars/' . $car->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" name="name" value={{$car->name}} />
            </div>
            <div class="form-group">
              <label for="license">License :</label>
              <input type="text" class="form-control" name="license" value="{{$car->license}}" />
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="active" name="is_active" {{$car->is_active == 1 ? "checked" : ""}} value="1" class="custom-control-input">
              <label class="custom-control-label" for="active">ACTIVE</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="inactive" name="is_active" {{$car->is_active == 0 ? "checked" : ""}} value="0" class="custom-control-input">
              <label class="custom-control-label" for="inactive">NON ACTIVE</label>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection