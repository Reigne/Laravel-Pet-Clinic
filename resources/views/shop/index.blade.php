@extends('layouts.base')
@section('body')
@section('title')
Acme Clinic Shop
@endsection
<div id="viewport">
<div class="container">
  <!-- Page Heading -->
  @if (count($errors) > 0)
  @include('layouts.flash-messages')
  @else
  @include('layouts.flash-messages')
  @endif
  <hr>
  <h1 class="my-4">Acme Clinic Shop
    <small>“We Know you love your Pet more.”</small>
  </h1>
  <div class="row">
   @foreach ($groomings->chunk(3) as $itemChunk)
            @foreach ($itemChunk as $grooming)
                <div class="col-lg-4 col-sm-6 mb-4">
                  <div class="card h-100 shadow rounded">
                    <img src="{{ $grooming->imagePath }}" alt="..." class="img-responsive">
                      <div class="card-body">
                            <h3 class="card-title">
                                <a href="#">{{ $grooming->description }}</a>
                            </h3>
                        <p class="card-text">Price of Service: ${{ $grooming->price}}</p>
                     </div>
                     <a href="{{ route('shop.review',$grooming->id) }}" class="btn btn-default"><i class="fas fa-comments"></i> Services Review</a> 
                     <a href="{{ route('grooming.addToCart', ['id'=>$grooming->id]) }}" class="btn btn-primary"><i class="fas fa-cart-plus"></i> Add to Cart</a>
                  </div>
                </div>
            @endforeach
    @endforeach
</div>
{{ $groomings->links() }}
</div>
@endsection