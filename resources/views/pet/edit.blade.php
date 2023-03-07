@extends('layouts.base')
@section('body')

 <div class="container">
    
      <h2>Edit Pet</h2><br/>
      {{-- dd($artists) --}}
      @if (count($errors) > 0)
                    @include('layouts.flash-messages')
            @endif

      {{ Form::model($pet,['route' => ['pet.update',$pet->id],'method'=>'PUT', 'enctype' =>'multipart/form-data']) }}

      <div class="jumbotron">
        <div class="d-flex justify-content-end">
         <a href="{{url()->previous()}}" class="btn btn-secondary btn-sm" role="button">Back</a>
       </div>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="customer_id">Owner I.D</label>
            {!! Form::select('customer_id', $customers, null, ['class' => 'form-control', 'id' => 'customer_id']) !!}
            @if($errors->has('customer_id'))
            <small>{{ $errors->first('customer_id') }}</small>
           @endif 
         </div>
          <div class="col-md-4 mb-3">
            <label for="Name">Pet Name</label>
           {!! Form::text('name', $pet->name,array('class' => 'form-control')) !!}
          </div>
         </div>

         <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="Name">Species</label>
           {!! Form::text('species',$pet->species,array('class' => 'form-control')) !!}
          </div>
          <div class="col-md-4 mb-3">
            <label for="Name">Breed</label>
           {!! Form::text('breed',$pet->breed,array('class' => 'form-control')) !!}
          </div>
          <div class="col-md-4 mb-3">
            <label for="Name">Gender</label>
           {!! Form::text('gender',$pet->gender,array('class' => 'form-control')) !!}
          </div>
         </div>

         <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="Name">Color</label>
           {!! Form::text('color',$pet->color,array('class' => 'form-control')) !!}
          </div>
          <div class="col-md-2 mb-3">
            <label for="Name">Age</label>
           {!! Form::text('age',$pet->age,array('class' => 'form-control')) !!}
          </div>
         </div>

        <div class="form-row">
          <label for="image" class="control-label">Your Picture</label>
          <input type="file" class="form-control-file" id="image" name="image">

          <td>
            <img src="{{ asset($pet->imagePath) }}" width="80"height="80" class="rounded" >
          </td>
                   
        </div>
        <div class="row">
          <div class="form-group col-md-4" style="margin-top:30px">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </div>
     {!! Form::close() !!}
   </div>
    </div>
  </div>
@endsection