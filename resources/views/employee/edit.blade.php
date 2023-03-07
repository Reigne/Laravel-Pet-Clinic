@extends('layouts.base')
@section('body')

 <div class="container">
    
      <h2>Edit Employee</h2><br/>
      {{-- dd($artists) --}}
      @if (count($errors) > 0)
                    @include('layouts.flash-messages')
            @endif
            
      {{ Form::model($employee,['route' => ['employee.update',$employee->id],'method'=>'PUT', 'enctype' =>'multipart/form-data']) }}

      @foreach($users as $user)
      <div class="jumbotron">
        <div class="d-flex justify-content-end">
         <a href="{{url()->previous()}}" class="btn btn-secondary btn-sm" role="button">Back</a>
       </div>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="Name">Register as:</label>
            {!! Form::select('role', ['employee' => 'Employee', 'admin' => 'Admin'], $user->role, ['class' => 'form-control']) !!}
            {{-- {!! Form::select('role', $user->role, null, ['class' => 'form-control', 'id' => 'role']) !!} --}}
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-2 mb-3">
            <label for="Name">Title</label>
           {!! Form::text('',$employee->title,array('class' => 'form-control', 'readonly')) !!}
          </div>

          <div class="col-md-5 mb-3">
            <label for="Name">First Name</label>
           {!! Form::text('',$employee->fname,array('class' => 'form-control', 'readonly')) !!}
          </div>

          <div class="col-md-5 mb-3">
            <label for="Name">Last Name</label>
           {!! Form::text('',$employee->lname,array('class' => 'form-control', 'readonly')) !!}
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-8 mb-3">
            <label for="Name">Addressline</label>
           {!! Form::text('',$employee->addressline,array('class' => 'form-control', 'readonly')) !!}
          </div>

          <div class="col-md-4 mb-3">
            <label for="Name">Town</label>
           {!! Form::text('',$employee->town,array('class' => 'form-control', 'readonly')) !!}
          </div>
        </div>
        
        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="Name">Zipcode</label>
           {!! Form::text('',$employee->zipcode,array('class' => 'form-control', 'readonly')) !!}
          </div>

          <div class="col-md-3 mb-3">
            <label for="Name">Phone</label>
           {!! Form::text('',$employee->phone,array('class' => 'form-control', 'readonly')) !!}
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="Name">E-mail</label>
           {!! Form::text('',$user->email,array('class' => 'form-control', 'readonly')) !!}
          </div>

          {{-- <div class="col-md-4 mb-3">
            <label for="Name">Password</label>
           <input type="password" class="form-control" id="password" name="password">
          </div> --}}
        </div>

        {{-- <div class="form-row">
                <label for="image" class="control-label">Your Picture</label>
                <input type="file" class="form-control-file" id="image" name="image">
                @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <td><img src="{{ asset($employee->imagePath) }}" width="80"height="80" class="rounded" >
                </td>
                   
        </div> --}}
        <div class="row">
          <div class="form-group col-md-4" style="margin-top:30px">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </div>
     {!! Form::close() !!}
   </div>
   @endforeach
    </div>
  </div>
@endsection