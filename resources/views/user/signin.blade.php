@extends('layouts.master')
@section('content')

<div class="container" style="width: 500px; ">
            <div class="jumbotron">

            <h1>Sign in</h1>
            <p>Not a member?<a href="{{ route('user.signup') }}"> Signup now</a></p>
            @if (count($errors) > 0)
                @include('layouts.flash-messages')
              @else
            @include('layouts.flash-messages')    
            @endif
            <hr>
            <form class="" action="{{ route('user.signin') }}" method="post">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email" class="form-control">
                   {{--  @if($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                    @endif --}}
                     </div>
                 </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" class="form-control">
                   {{--  @if($errors->has('password'))
                        <div class="error">{{ $errors->first('password') }}</div>
                    @endif --}}
                </div>
                </div>

                    <input type="submit" value="Sign In" class="btn btn-primary">
             </form>
         </div>
        </div>
@endsection
