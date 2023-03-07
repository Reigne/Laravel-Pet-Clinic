@extends('layouts.base')
@section('body')

  <div class="container">

      <h2>Employees CRUD</h2><br/>

     @if (count($errors) > 0)
   @include('layouts.flash-messages')
   @else
   @include('layouts.flash-messages')
   @endif

 <div class="jumbotron">
  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#employeeModal"><strong><i class="fas fa-plus"></i> Add New Employee</strong></a>
  </div>
 <div class="col-xs-6">
  <form method="post" enctype="multipart/form-data" action="{{ url('/employee/import') }}">
      @csrf
      <input type="file" id="uploadName" name="employee_upload" required>  
 </div>
 <div>
    @error('employee_upload')
      <small>{{ $message }}</small>
    @enderror</div>
         <button type="submit" class="btn btn-info btn-primary" >Import Excel File</button>
    </form> 
  <div>
    {{$dataTable->table(['class' => 'table table-striped table-hover '], true)}}
  </div>
</div>
{{-- <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#artistModal"> --}}

<div class="modal" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:75%;">
    <div class="modal-content">
      <div class="modal-header text-center">
        <p class="modal-title w-100 font-weight-bold">Add New Employee</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>

        <form  method="POST" action="{{url('employee')}}" enctype="multipart/form-data">{{csrf_field()}}
        <div class="modal-body mx-3" id="inputfacultyModal">
          <div class="form-row">
            <div class="col-md-2 mb-3">
              <label for="validationServer01">Title</label>
              <input type="text" class="form-control validate" id="title" name="title" placeholder="Title" required>
            </div>
            
            <div class="col-md-5 mb-3">
              <label for="validationServer02">First name</label>
              <input type="text" class="form-control validate" id="fname" name="fname" placeholder="First name" required>
            </div>

            <div class="col-md-5 mb-3">
              <label for="validationServer02">Last name</label>
              <input type="text" class="form-control validate" id="lname" name="lname" placeholder="Last name" required>
            </div>

          </div>

          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom03">Addressline</label>
                <input type="text" class="form-control" id="addressline" name="addressline" placeholder="City" required>
                <div class="invalid-feedback">
                  Please provide a valid addressline.
                </div>
              </div>

              <div class="col-md-3 mb-3">
                <label for="validationCustom04">Town</label>
                <input type="text" class="form-control" id="town" name="town" placeholder="State" required><div class="invalid-feedback">Please provide a valid state.</div>
              </div>

              <div class="col-md-3 mb-3">
                <label for="validationCustom05">Zipcode</label>
                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zipcode" required>
                <div class="invalid-feedback">Please provide a valid zipcode.</div>
              </div>
            </div> 

            <div class="md-form mb-2">
              <label data-error="wrong" data-success="right" for="name" style="display: inline-block; width: 150px; ">Phone</label>
              <input type="text"  class="form-control validate" id="phone" name="phone" placeholder="Phone Number" required="">
          </div>

           <div class="md-form mb-2">
            <label data-error="wrong" data-success="right" for="name" style="display: inline-block; width: 150px; ">E-mail</label>
            <input type="text"  class="form-control validate" id="email" name="email" placeholder="example@address.com" required="">
          </div>

          <div class="md-form mb-2">
            <label data-error="wrong" data-success="right" for="name" style="display: inline-block;
          width: 150px; ">Password</label>
            <input type="password" class="form-control validate" id="password" name="password" placeholder="Password" required="">
          </div>

          <div class="form-group">
                <label for="imagePath" class="control-label">Your Picture</label>
                <input type="file" class="form-control-file" id="imagePath" name="image" required="">
                @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                </div>
<div class="modal-footer d-flex justify-content-center">
            <button type="submit" class="btn btn-success">Save</button>
            <button class="btn btn-light" data-dismiss="modal"> <i class="fas fa-paper-plane-o ml-1">Cancel</i></button>
          </div>
        </form>
 </div>
    </div>
    
  </div>
  @push('scripts')
    {{$dataTable->scripts()}}
  @endpush
@endsection