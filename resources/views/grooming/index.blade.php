@extends('layouts.base')
@section('body')

<div class="container">
  <h2>Groomings CRUD</h2><br/>

  @if (count($errors) > 0)
  @include('layouts.flash-messages')
  @else
  @include('layouts.flash-messages')
  @endif

 <div class="jumbotron">
 <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#groomingModal"><strong><i class="fas fa-plus"></i> Add New Grooming</strong></a>
  </div>
 <div class="col-xs-6">
  <form method="post" enctype="multipart/form-data" action="{{ url('/grooming/import') }}">
      @csrf
      <input type="file" id="uploadName" name="grooming_upload" required>  
 </div>
 <div>
    @error('grooming_upload')
      <small>{{ $message }}</small>
    @enderror</div>
         <button type="submit" class="btn btn-info btn-primary" >Import Excel File</button>
    </form> 
  <div>
    {{$dataTable->table(['class' => 'table table-striped table-hover '], true)}}
  </div>
</div>
{{-- <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#artistModal"> --}}
<div class="modal" id="groomingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:75%;">
      <div class="modal-content">
<div class="modal-header text-center">
          <p class="modal-title w-100 font-weight-bold">Add New Grooming</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form  method="POST" action="{{url('grooming')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-body mx-3" id="inputfacultyModal">
        <div class="form-row">
    <div class="col-md-6 mb-3">
      <label for="validationServer01">Description</label>
      <input type="text" class="form-control validate" id="description" name="description" placeholder="Description" required>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationServer02">Price</label>
      <input type="text" class="form-control validate" id="price" name="price" placeholder="Price" required>
    </div>
  </div>
  <div class="form-group">
    <label for="imagePath" class="control-label">Grooming Picture</label>
    <input type="file" class="form-control-file" id="imagePath" name="image">
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