@extends('layouts.base')
@section('body')

 <div class="container">
    
      <h2>Edit grooming</h2><br/>
      {{-- dd($artists) --}}
      @if (count($errors) > 0)
                    @include('layouts.flash-messages')
            @endif
            
      {{ Form::model($grooming,['route' => ['grooming.update',$grooming->id],'method'=>'PUT', 'enctype' =>'multipart/form-data']) }}

      <div class="jumbotron">
        <div class="d-flex justify-content-end">
         <a href="{{url()->previous()}}" class="btn btn-secondary btn-sm" role="button">Back</a>
       </div>

        <div class="form-row">
          <div class="col-md-2 mb-3">
            <label for="Name">Description</label>
           {!! Form::text('description',$grooming->description,array('class' => 'form-control')) !!}
          </div>

          <div class="col-md-5 mb-3">
            <label for="Name">Price</label>
           {!! Form::text('price',$grooming->price,array('class' => 'form-control')) !!}
          </div>

        </div>

        <div class="form-row">
          <label for="image" class="control-label">Grooming Picture</label>
          <input type="file" class="form-control-file" id="image" name="image" required="">

          <td>
            <img src="{{ asset($grooming->imagePath) }}" width="80"height="80" class="rounded" >
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