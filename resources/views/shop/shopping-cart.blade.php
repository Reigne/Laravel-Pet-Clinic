@extends('layouts.master')
@section('title')
    AcmeClinic Shopping Cart
@endsection
@section('content')
{{--dd($groomings)--}}
@if (count($errors) > 0)
@include('layouts.flash-messages')
@else
  @include('layouts.flash-messages')
  @endif
<div class="jumbotron">
    

    @if(Session::has('cart'))
 {{--    <div class="row">
        <div class="col-md-4 mb-3">
    <label for="customer_id">Please select your pet:</label>
    <select class="form-control" id="pet_id" name="pet_id" required="">
      @foreach($pets as $id => $pet)
        <option value="{{$id}}"><a> {{$pet}} </a></option>
      @endforeach
    </select>
  </div>
    </div> --}}
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <ul class="list-group">
                    @foreach($groomings as $grooming)
                            <li class="list-group-grooming">
                                <span class="badge rounded-pill bg-secondary">{{ $grooming['qty'] }}</span>
                                <strong>{{ $grooming['grooming']['description'] }}</strong>
                                <span class="label label-success">{{ $grooming['price'] }}</span>
                                <div class="btn-group col-sm-6 col-md-6 ">
                                    {{-- <button type="button" class="btn btn-primary btn-xs dropdown-toogle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu"> --}}
                                        {{-- <li><a href="{{ route('grooming.reduceByOne',['id'=>$grooming['grooming']['item_id']]) }}">Reduce By 1</a></li> --}}
                                        <a href="{{ route('grooming.remove',['id'=>$grooming['grooming']['id']]) }}"><button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash" aria-hidden="true">Remove</i></button></a>
                                    {{-- </ul> --}}
                                </div>
                            </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <strong>Total: </strong>${{ $totalPrice }}
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                 <a href="{{ route('checkout') }}" type="button" class="btn btn-success">Checkout</a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <h2>No Items in Cart!</h2>
            </div>
        </div>
    @endif
</div>
@endsection
