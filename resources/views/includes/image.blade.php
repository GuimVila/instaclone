<div class="card pub_image mb-3">
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
        <a href="{{ route('image.detail', ['id' => $image->id]) }}">
            <div class="image-container">
                <img src="{{ route('image.file',['filename' => $image->image_path]) }}"/>
            </div>
        </a>
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
        <div class="clearfix"></div>
        <div class="description">
            <span class="nickname"> {{  '@'.$image->user->nick }} </span>
            <span class="date"> {{ \FormatTime::LongTimeFilter($image->created_at) }}</span>
            <p>{{  $image->description }}</p>              
        </div>
        <a href="" class="btn btn-sm btn-warning btn-comments">
            Comments ({{ count($image->comments) }})
        </a>
    </div>
</div>