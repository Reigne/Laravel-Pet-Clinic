@extends('layouts.master')
@section('content')
    @if (count($errors) > 0)
  @include('layouts.flash-messages')
  @else
  @include('layouts.flash-messages')
  @endif
<div class="container rounded shadow bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="{{ asset(Auth::user()->employees->imagePath) }}">
            	<span class="font-weight-bold">{{ Auth::user()->employees->fname}}  {{ Auth::user()->employees->lname}} (#{{Auth::user()->employees->id}})</span>
            	<span class="text-black-50">{{ Auth::user()->role }}</span><span> </span></div>
        </div>

        {{-- {{ Form::model(Auth::user(),['route' => ['employee.update',Auth::user()->employees->id],'method'=>'PUT', 'enctype' =>'multipart/form-data']) }} --}}
        {{-- <form method="PUT" action="{{ route('stocks.update', Auth::user()->employees->id) }}"> --}}
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <div class="row mt-2">
                	<div class="col-md-3"><label class="labels">Title</label><input type="text" class="form-control" value="{{ Auth::user()->employees->title }}" placeholder="surname" readonly=""></div>
                    <div class="col-md-4"><label class="labels">Name</label><input type="text" class="form-control" placeholder="first name" value="{{ Auth::user()->employees->fname }}" readonly=""></div>
                    <div class="col-md-5"><label class="labels">Surname</label><input type="text" class="form-control" value="{{ Auth::user()->employees->lname }}" placeholder="surname" readonly=""></div>
                </div>
                <div class="row mt-3">
                	<div class="col-md-12"><label class="labels">Email</label><input type="text" class="form-control" placeholder="enter email" value="{{ Auth::user()->email }}" readonly=""></div>

                    <div class="col-md-12"><label class="labels">Phone Number</label><input type="text" class="form-control" placeholder="enter phone number" value="{{ Auth::user()->employees->phone }}" readonly=""></div>

                    <div class="col-md-12"><label class="labels">Addressline</label><input type="text" class="form-control" placeholder="enter addressline" value="{{ Auth::user()->employees->addressline }}" readonly=""></div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-6"><label class="labels">Town</label><input type="text" class="form-control" placeholder="enter town" value="{{ Auth::user()->employees->town }}" readonly=""></div>

                    <div class="col-md-6"><label class="labels">Zipcode</label><input type="text" class="form-control" placeholder="enter zipcode" value="{{ Auth::user()->employees->zipcode }}" readonly=""></div>
                </div>
                 {{-- <div class="row mt-3">
                	<div class="col-md-12"><label class="labels">Password</label><input type="password" class="form-control" placeholder="enter password" value=""></div>
                </div> --}}
               {{--  <div class="row mt-3">
                	<div class="col-md-12">
                		<label class="labels" for="image" class="control-label">Your Picture</label>
                		<input type="file" class="form-control-file" id="image" name="image" required="">
                	</div>
                </div> --}}
{{-- <a href=". route('employee.edit', $row->id). " class=\"btn btn-warning\">Edit</a>  --}}
                <div class="mt-5 text-center">
                    <a class="btn btn-primary profile-button" type="button" href=" {{ route('customer.edit', Auth::user()->employees->id) }} " >Edit Profile
                    </a>
                </div>
            </div>
            
        </div>

        {{-- <div class="col-md-4">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center experience"><span>List of Pets</span>
                	<span class="border px-3 p-1 add-experience">
                		<a href=" {{ route('pet.create') }}" >
                	<i class="fa fa-plus"></i>&nbsp;Add Pet</span></a>
                </div>

                	<br>

                <div class="col-md-12"><label class="labels">Pet Name</label></div>
                @foreach ($pets as $pet)
                <div class="col-md-12">
                <span class="font-bold"><li>{{ $pet->name }} <span class="text-black-50">({{ $pet->species }})</span></li></span> 
                </div>
                @endforeach
                <br>
                {{-- <div class="col-md-12"><label class="labels">Additional Details</label><input type="text" class="form-control" placeholder="additional details" value=""></div> --}}
         {{--    </div>
        </div> --}} 
    </div>

</div>
</div>
</div>
@endsection

