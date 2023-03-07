@extends('layouts.base')
@section('body')
<div class="container">
  <h2>Create New Consulation</h2>
  <br>
  <form method="post" action="{{route('consultation.store')}}" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <div class="jumbotron">
   
 <div class="form-row">
  <div class="col-md-4 mb-3">
    <label for="pet_id">Select Pet</label>
    <select class="form-control" id="pet_id" name="pet_id" required="">
      @foreach($pets as $id => $pet)
        <option value="{{$id}}"><a> {{$pet}} </a></option>
      @endforeach
    </select>
  </div>
</div>

{{-- <label for="pet_id">Select Medical Condition</label>
@foreach($conditions as $id => $condition)
<div class="form-check">

  <input class="form-check-input" type="checkbox" name="condition_id[]" id="condition_id[]" value="{{ $id }}">
  <label class="form-check-label" for="flexCheckDefault">
    {{ $condition }}
  </label>
</div>
@endforeach
<br> --}}

<label for="pet_id">Select Medical Condition</label>

@foreach($conditions as $condition ) 
        <br>
        <div class="form-check form-check-inline">
        {{ Form::checkbox('condition_id[]',$condition->id, null, array('class'=>'form-check-input','id'=>'condition')) }} 
        {!!Form::label('condition', $condition->description,array('class'=>'form-check-label')) !!}
        </div> 
@endforeach


<div class="form-row">
{{-- <div class="col-md-4 mb-3">
    <label for="description">Description</label>
    <select class="form-control" id="description" name="description" required="">
        <option value="Skin Allergies"><a>Skin Allergies</a></option>
        <option value="Ear Infection"><a>Ear Infection</a></option>
        <option value="Upset Stomach"><a>Upset Stomach</a></option>
        <option value="Diabetes"><a>Diabetes</a></option>
        <option value="Diarrhea"><a>Diarrhea</a></option>
        <option value="Bladder Infection"><a>Bladder Infection</a></option>
    </select>
  </div> --}}

<div class="col-md-3 mb-3">
    <label for="price" class="control-label">Price</label>
    <input type="text" class="form-control" id="price" name="price" value="{{old('price')}}" required="">
  </div>
</div>

<div class="form-row">
  <div class="col-md-9 mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Comment</label>
    <textarea class="form-control" id="comment" name="comment" rows="2" placeholder="Insert comment here..." value="{{old('comment')}}"></textarea>
  </div>
</div>

<div>
<button type="submit" class="btn btn-primary">Save</button>
  <a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a>
</div>
  </div>     
</div>
</form>
@endsection