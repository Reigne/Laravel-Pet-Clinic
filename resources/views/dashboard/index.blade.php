@extends('layouts.base')
@section('body')
  <div class="container">
<div class="jumbotron">
<div  class="" align="center" >
    <h2>Dashboard</h2>

    <form class="row g-3" method="GET" action="{{ route('search') }}">
        <div class="col-auto">
            <input type="date" name="datepicker" class="form-control" id="datepicker" placeholder="pick date here..">
        </div>
        <div class="col-auto" >
            <button type="submit" class="btn btn-outline-primary">Search Date Chart</button>
        </div>
    </form>

</div>
</div>
<br>
<div class="jumbotron">
    <h4 align="center">Pet Groomed Chart</h4>
 @if(empty($groomingChart))
 <div id="app2"></div>
 @else
 <div class="row">
    {!! $groomingChart->container() !!}
</div>
{!! $groomingChart->script() !!} 
@endif   
</div>
<br>
<div class="jumbotron d-flex justify-content-start" >

<div class="container">
    <h4 align="center">Pet Disease/Injuries Chart</h4>
@if(empty($conditionChart))
 <div id="app2"></div>
 @else
 <div class="row">
    {!! $conditionChart->container() !!}
</div>
{!! $conditionChart->script() !!} 
@endif

    </div>
<br>
    <div class="container" >
    <h4 align="center">Pet Number Chart</h4>
@if(empty($petChart))
 <div id="app2"></div>
 @else
 <div class="row">
    {!! $petChart->container() !!}
</div>
{!! $petChart->script() !!} 
@endif

    </div>
</div>
 </div>
 <br> 
@endsection