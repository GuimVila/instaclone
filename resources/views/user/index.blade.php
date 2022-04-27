@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h1>People</h1>
        <form method="GET" action="{{ route('user.index') }}" id="search_bar">
            <div class="row">
                <div class="form-group col">
                    <input type="text" id="search" class="form-control mt-2 mb-3">
                </div>
                <div class="form-group col btn-search">
                    <input type="submit"  value="Search" class="btn btn-sm btn-success" role="button">
                </div>
            </div>
        </form>
        <hr>
        @foreach($users as $user)
        <div class="profile-user">
                @if($user->image)
                    <div class="container-avatar">
                        <img src="{{ route('user.avatar', ['filename'=>$user->image]) }}" class="avatar"/>
                    </div>  
                @endif
                <div class="user-info">
                    <h2>{{ '@'.$user->nick }}</h2>
                    <h3>{{ $user->name .' '. $user->surname }}</h3>
                    <p>{{ 'Joined '.\FormatTime::LongTimeFilter($user->created_at) }}</p>
                </div>
            </div>
          
            <a href="{{ route('profile', ['id' => $user->id]) }}" class="btn btn-success users mb-3" role="button">Visit Profile</a>
            <div class="clearfix"></div>
            <hr class="profile-divider"/>
        @endforeach 
        </div>

        <!-- Pagination -->
        <div class="clearfix"></div>
        {{$users->links()}}
        </div>
    </div>
</div>
@endsection
