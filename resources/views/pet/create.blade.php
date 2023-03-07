@extends('layouts.base')
@section('body')
<div class="container">
  <h2>Create New Pet</h2>
  <br>
  <form method="post" action="{{ route('pet.store') }}" enctype="multipart/form-data">
  @csrf
   <div class="jumbotron">
   
   <div class="form-row">
    @if(Auth::user()->role == 'customer')

    <input type="text" class="form-control" id="customer_id" name="customer_id" hidden value="{{ Auth::user()->customers->id }}" >
    
    @else
  <div class="col-md-4 mb-3">
    <label for="customer_id">Owner Name</label>
    <select class="form-control" id="customer_id" name="customer_id" required="">
      @foreach($customers as $id => $customer)
        <option value="{{$id}}"><a> {{$customer}} </a></option>
      @endforeach
    </select>
  </div>
   @endif

  

  <div class="col-md-4 mb-3">
    <label for="name" class="control-label">Pet Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required="">
    @if($errors->has('name'))
    <small style="color: red">{{ $errors->first('name') }}</small>
   @endif 
 </div>
</div>

<div class="form-row">
     

</div>
  <div class="form-row">
    <div class="col-md-3 mb-3">
    <label for="species" class="control-label">Species</label>
    <input type="text" class="form-control" id="species" name="species" value="{{old('species')}}" required="">
    @if($errors->has('species'))
    <small style="color: red">{{ $errors->first('species') }}</small>
   @endif 
  </div>
  <div class="col-md-3 mb-3">
    <label for="breed" class="control-label">Breed</label>
    <input type="text" class="form-control" id="breed" name="breed" value="{{old('breed')}}" required="">
    @if($errors->has('breed'))
    <small style="color: red">{{ $errors->first('breed') }}</small>
   @endif 
  </div>
  </div>
  <div class="form-row">
    <div class="col-md-2 mb-3">
    <label for="gender">Gender</label>
    <select class="form-control" id="gender" name="gender" required="">
      <option>Male</option>
      <option>Female</option>
    </select>
  </div>
    <div class="col-md-3 mb-3">
    <label for="color" class="control-label">Color</label>
    <input type="text" class="form-control" id="color" name="color" value="{{old('color')}}" required="">
    @if($errors->has('color'))
    <small style="color: red">{{ $errors->first('color') }}</small>
   @endif 
  </div>
    <div class="col-md-3 mb-3">
    <label for="age" class="control-label">Age</label>
    <input type="text" class="form-control" id="age" name="age" value="{{old('age')}}" required="">
    @if($errors->has('age'))
    <small style="color: red">{{ $errors->first('age') }}</small>
   @endif 
  </div>
</div>
   <div class="form-group">
                <label for="imagePath" class="control-label">Pet Picture</label>
                <input type="file" class="form-control-file" id="imagePath" name="image" required="">
                @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                </div>
<button type="submit" class="btn btn-primary">Save</button>
  <a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a>
  </div>
  </div>     
</div>
</form>
@endsection