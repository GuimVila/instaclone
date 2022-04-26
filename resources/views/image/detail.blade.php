@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @include('includes.message')
      
            <div class="card pub_image pub_image_detail mb-3">
                <div class="card-header">

                    @if($image->user->image)
                    <div class="container-avatar">
                        <img src="{{ route('user.avatar', ['filename'=>$image->user->image]) }}" class="avatar"/>
                    </div>  
                    @endif

                    <div class="data-user">
                        {{ $image->user->name.' '.$image->user->surname}}
                        <span class="nickname">
                            {{  '| @'.$image->user->nick }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="image-container image-detail">
                        <img src="{{ route('image.file',['filename' => $image->image_path]) }}"/>
                    </div>
                    <div class="likes">
                    <!-- Check if user liked the post previously -->
                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                            @if($like->user->id == Auth::user()->id)
                                <?php $user_like = true; ?>    
                            @endif
                        @endforeach
                        @if($user_like) 
                            <img class="like-img btn-like" src="{{ asset('img/hearts-red.png') }}" data-id="{{ $image->id }}" />
                        @else
                            <img class="like-img btn-dislike" src="{{ asset('img/hearts-grey.png') }}" data-id="{{ $image->id }}" />
                        @endif
                        <span class="likes-counter">{{ count($image->likes) }}</span>
                    </div>
                    <div class="description">
                        <span class="nickname"> {{  '@'.$image->user->nick }} </span>
                        <span class="nickname date"> {{ '| '.\FormatTime::LongTimeFilter($image->created_at) }}</span>
                        <p>{{  $image->description }}</p>              
                    </div>
                    <h2 class="comments">Comments ({{ count($image->comments) }})</h2>
                    <hr>

                    <form class="comments" method="POST" action="{{ route('comment.save') }}">
                        @csrf
                        <input type="hidden" name="image_id" value="{{ $image->id }}"/>
                        <p>
                        <textarea name="content" id="" class="form-control mb-3" {{ $errors->has('content') ? 'is-invalid' : '' }} cols="30" rows="4"required></textarea>
                        @if($errors->has('content'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('connection_status') }}</strong>
                            </span>
                        @endif
                        </p>  <!-- use this error bootstrap and copy it to the rest -->
                        <button type="submit" class="btn btn-success">Comment</button>
                    </form>

                    @foreach($image->comments as $comment)
                        <div class="comment">  
                            <span class="nickname"> {{  '@'.$comment->user->nick }} </span>
                            <span class="nickname date"> {{ '| '.\FormatTime::LongTimeFilter($comment->created_at) }}</span>
                            <p>{{  $comment->content }}  
                            @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn btn-sm btn-danger">
                                    Delete  
                                </a> 
                            @endif 
                            </p>          
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection