
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-3">My favourite posts</h1>
            <hr class="mb-4">

            @foreach($likes as $like)
                @include('includes.image', ['image'=>$like->image]) 
            @endforeach

            <!-- Pagination -->
        <div class="clearfix"></div>
        {{$likes->links()}}
        </div>
        </div>
    </div>
</div>
@endsection