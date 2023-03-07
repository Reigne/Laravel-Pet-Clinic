@extends('layouts.base')
@section('body')

  <div class="container">

      <h2>Pets CRUD</h2><br>

    @if (count($errors) > 0)
  @include('layouts.flash-messages')
  @else
  @include('layouts.flash-messages')
  @endif

     
 <div class="jumbotron">

 <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <a href="{{ route('pet.create') }}" class="btn btn-success btn-sm" ><strong><i class="fas fa-plus"></i> Add New Pet</strong></a>
  </div>
 <div class="col-xs-6">
  <form method="post" enctype="multipart/form-data" action="{{ url('/pet/import') }}">
      @csrf
      <input type="file" id="uploadName" name="pet_upload" required>  
 </div>
 <div>
    @error('pet_upload')
      <small>{{ $message }}</small>
    @enderror</div>
         <button type="submit" class="btn btn-info btn-primary" >Import Excel File</button>
    </form> 
  <div>
    {{$dataTable->table(['class' => 'table table-striped table-hover '], true)}}
  </div>
</div>
</div>
{{-- <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#artistModal"> --}}

  @push('scripts')
    {{$dataTable->scripts()}}
  @endpush
@endsection