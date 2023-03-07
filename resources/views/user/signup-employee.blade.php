@extends('layouts.master')
@section('content')
    <div class="container">
            <h1>Sign-up Employee</h1>
            <p>Already have account?<a href="{{ route('user.signin') }}"> Log In</a></p>
            
            @if (count($errors) > 0)
                    @include('layouts.flash-messages')
            @endif

            <div class="jumbotron">
                <form class="" action="{{ route('user.signupEmployee') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}  
                <div class="form-row">
            {{-- <input type="text" hidden id="role" name="role" value="employee"> --}}
            
           {{--  <div class="col-md-3 mb-3">
            <label for="role">Register As:</label>
            <select class="form-control" id="role" name="role" required="">
              <option value="customer">Customer</option>
              <option value="employee">Employee</option>
            </select>
            </div> --}}
            </div>

            <div class="form-row">

            <div class="col-md-2 mb-3">
              <label for="validationServer01">Title</label>
              <input type="text" class="form-control validate" id="title" name="title" placeholder="Title">
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

                <input type="submit" value="Sign Up" class="btn btn-primary">
             </form>
         </div>
</div>
        </div>
    </div>
@endsection