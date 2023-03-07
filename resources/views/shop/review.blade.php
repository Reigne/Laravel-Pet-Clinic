

@extends('layouts.base')
@section('body')

<div class="container">
  @if (count($errors) > 0)
  @include('layouts.flash-messages')
  @else
  @include('layouts.flash-messages')
  @endif
</div>


<div class="container mt-5 mb-5" style="width: 2000px; ">
  
        <div class="d-flex justify-content-center row" >
            <div class="d-flex flex-column col-md-16">
              
                <div class="coment-bottom bg-white p-2 px-4 shadow">

                  <div align="right">
                  <a href="{{ route('shop.index')}}" class="btn btn-success">Back</a>
                 </div>

                 <p style="font-size:200%;" align="center">{{ $groomings->description }}</p>
                  <div class="d-flex justify-content-center">
                   <img src="{{ asset($groomings->imagePath) }}" align="center" class="rounded" style="width:600px"/>
                 </div>
                <hr>
                <form method="post" action="{{ route('grooming.reviewStore') }}">
                    @csrf
                    <div class="form-group">
                      <input type="hidden" class="form-control" id="grooming_id" name="grooming_id" value="{{$groomings->id}}" readonly="true">
                    </div>

                    <div class="d-flex flex-row add-comment-section mt-4 mb-4">
                      @if(Auth::check())
                      <img class="img-fluid img-responsive rounded-circle mr-2" src="{{ asset(Auth::user()->customers->imagePath) }}" width="38">
                      @else
                      @endif
                      <input type="text" class="form-control mr-3" id="comment" name="comment" placeholder="Leave a comment here...">
                      <button class="btn btn-primary" type="submit">Comment</button>
                    </div>
                  </form> 
                  <h5>Recent comment by customers</h5>
                    @foreach ($reviews  as $review)
                    <div
                        class="commented-section mt-2"  style="width: 1000px; ">
                        <div class="d-flex flex-row align-items-center commented-user">
                            <h5 class="mr-2">
                              <strong>{{ $review->fname }} {{ $review->lname }}</strong>
                            </h5><span class="dot mb-1"></span>
                            <span class="mb-1 ml-2">{{ $review->created_at->format('F j, Y') }}</span></div>
                        <div class="comment-text-sm"><span>{{ $review->comment }}</span></div>
                      <hr>
            </div>
            @endforeach
            {{ $reviews->links() }}
    </div>
    </div>
    </div>
    </div>
@endsection


