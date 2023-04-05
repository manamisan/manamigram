@extends('layouts.app')

@section('title','Profile')

@section('content')

    <div class="row mt-2 mb-5 align-items-center text-center mx-0 px-0">

        <div class="col-3">
            @if ($user->picture)
                <img src="{{ asset('storage/pictures/'.$user->picture) }}" alt="{{ $user->picture }}" class="img-thumbnail w-100">
            @else
                <i class="fa-solid fa-image fa-10x d-block text-center"></i>
            @endif
        </div>

        <div class="col-3">
            <p class="display-6">{{ $user->posts->count() }}</p>
            <span class="fs-6">Posts</span>
        </div>

        <div class="col-3 p-0">
            <a href="{{ route('follow.followers',$user->id) }}" class="btn btn-outline-secondary w-100">
                <p id="followers" class="display-6">{{ $user->followers->count() }}</p>
                <span class="fs-6 fs-md-3">Followers</span>
            </a>
        </div>

        <div class="col-3 p-0">
            <a href="{{ route('follow.following',$user->id) }}" class="btn btn-outline-secondary w-100">
                <p id="followeing" class="display-6">{{ $user->followings->count() }}</p>
                <span class="fs-6">Followers</span>
            </a>
        </div>
    </div>

    <div class="row mt-2 mb-5">
        <div class="col">
            <h2 class="display-6">{{ $user->name }}</h2>
            @auth
                @if(Auth::user()->id === $user->id)
                    <a href="{{ route('profile.edit',$user->id) }}" class="text-decoration-none btn btn-secondary w-100">Edit Profile</a>    
                @else
                    @if($user->isFollowedBy(Auth::user()->id))
                        {{-- <form action="{{ route('follow.unfollow',[$user->id,Auth::user()->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-secondary w-100 text-white">Following</button>
                        </form> --}}

                        <span id="follow-profile" class="btn btn-secondary w-100 text-white following" data-route="{{ route('follow.unfollow',[$user->id,Auth::user()->id]) }}">
                            Following
                        </span>
                    @else
                        {{-- <form action="{{ route('follow.follow',[$user->id,Auth::user()->id]) }}" method="POST">
                            @csrf
                            <button class="btn btn-info w-100 text-white">Follow</button>
                        </form> --}}

                        <span id="follow-profile" class="btn btn-info w-100 text-white follow" data-route="{{ route('follow.follow',[$user->id,Auth::user()->id]) }}">
                            Follow
                        </span>
                    @endif
                @endif
            @endauth
            @guest
                @if (Route::has('login'))
                    <a class="btn btn-info w-100 text-white follow" href="{{ route('login') }}">
                        Follow
                    </a>
                @endif
            @endguest
        </div>
    </div>

    <ul class="list-group mb-5">
        <h2 class="display-6">Posts</h2>
        @forelse ($user->posts->sortByDesc('created_at') as $post)
                
            <div class="card mb-3">
                <div class="card-header">
                    {{-- <p>{{ $post->video() }}</p> --}}
                    <div class="row flex-nowrap align-items-center">
                        <div class="col-3">
                            @if($post->user->picture)
                                <div class="rounded rounded-circle">
                                    <img src="{{ secure_asset('storage/pictures/'.$post->user->picture) }}" alt="{{ $post->user->picture."aa" }}" class="d-block mx-auto dashboard-photo img-thumbnail"
                                    style="width:3.5rem; height:3.5rem; object-fit:cover;">
                                </div>
                            @else
                                <div>
                                    <i class="fa-regular fa-user d-block text-center dashboard-icon" style="font-size: 1rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-3">
                            <a href="{{ route('profile.show',$post->user->id) }}" class="text-decoration-none">{{ $post->user->username }}</a>
                        </div>
                        {{-- <div class="col">
                            <a class="btn btn-outline-secondary" 
                            href="
                                @guest
                                    @if (Route::has('login'))
                                        {{ route('login') }}
                                    @else
                                        #
                                    @endif
                                @else
                                    #
                                @endguest
                            "
                            >Follow</a>
                        </div> --}}
    
                        {{-- button --}}
                        <div class="col nav-item dropdown text-end">
                            <a id="navbarDropdown" class="nav-link fs-3" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa-solid fa-ellipsis"></i>
                            </a>
    
                            @guest
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a href="#" class="bg-info dropdown-item text-white">
                                        <i class="fa-solid fa-share-nodes me-2"></i>Share
                                    </a>
                                </div>
                            @else
                                
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a href="#" class="bg-info dropdown-item text-white">
                                        <i class="fa-solid fa-share-nodes me-2"></i>Share
                                    </a>
                                    @if ($post->user_id === Auth::user()->id)
                                        
                                        <a href="{{ route('post.edit',$post->id) }}" class="bg-primary dropdown-item text-white">
                                            <i class="fa-solid fa-pen me-2"></i>Edit
                                        </a>
    
                                        <button type="button" class="dropdown-item bg-danger text-white" data-bs-toggle="modal" data-bs-target="#delete-{{ $post->id }}">
                                            <i class="fa-solid fa-trash-can me-2"></i>Delete
                                        </button>
    
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
    
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    @else
                                    @endif
                                    
                                </div>
                                @include('posts.components.delete')
                            @endguest
                        </div>
                    </div>
                </div>
    
                @if ( preg_match( "/.*?\.jpg|.*?\.png|.*?\.gif|.*?\.jpeg/i", $post->media))
                    <img src="{{ secure_asset('storage/media/'.$post->media) }}" class="card-img-top border-bottom" alt="{{ $post->media }}">
                @elseif(preg_match( "/.*?\.mp4/i", $post->media))
                    <video controls autoplay muted class="card-img-top border-bottom">
                        <source src="{{ secure_asset('storage/media/'.$post->media) }}" type="video/mp4">
                    </video>
                @else
                    {{-- <p class="text-muted">This file can't be read</p>              --}}
                @endif
                {{-- <p>{{ asset('storage/media/'.$post->media) }}</p> --}}
    
                <div class="card-body pt-0">
                
                    <h2 class="h4">{{ $post->title }}</h2>
                    <p class="card-text full">
                    {{-- full ->app.js --}}
                        {{ $post->body }}
                    </p>
                </div>
    
                <div class="card-footer border-top pt-0">
                    <h5 class="card-title">
                        <div class="row align-item-center border-bottom">
    
                            @guest
                                <div class="col">
                                    <a class="btn btn-outline-secondary border-0 text-dark" href="{{ route('login') }}">
                                        <i class="fa-regular fa-heart"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="btn btn-outline-secondary border-0 text-dark" href="{{ route('login') }}">
                                        <i class="fa-regular fa-comment"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="btn btn-outline-secondary border-0 text-dark" href="{{ route('login') }}">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </a>
                                </div>
                            @else
                                <div class="col">
    
                                    @if ($post->isLikedBy(Auth::user()->id))
                                        <form action="{{ route('like.removeLike',[Auth::user()->id, $post->id] ) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-secondary border-0 text-dark">
                                                <i class="fa-solid fa-heart text-danger"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('like.addLike',[Auth::user()->id, $post->id] ) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-outline-secondary border-0 text-dark">
                                                <i class="fa-regular fa-heart"></i>
                                            </button>
                                        </form>    
                                    @endif
                                        
                                </div>
                                <div class="col">
                                    <a class="btn btn-outline-secondary border-0 text-dark" href="{{ route('post.show',$post->id) }}">
                                        <i class="fa-regular fa-comment"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="btn btn-outline-secondary border-0 text-dark" href="#">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </a>
                                </div>
                            @endguest
                        </div>
    
                        <div class="row">
                            @if (isset($post->likes[0]))
                                <div class="col"><p>Liked by {{ $post->likes[0]->user->username }} and others</p></div>         
                            @else
                                <div class="col"><p>Not liked yet.</p></div>       
                            @endif
                        </div>
                    </h5>
                </div>
    
            </div>

        @empty
            <div style="margin-top: 100px;">
                <h2 class="text-muted text-center">No Posts Yet.</h2>
                <p class="text-center">
                    <a href="{{ route('post.create') }}" class="text-decoration-none">Create a New Post.</a>
                </p>
            </div>
        @endforelse
    </ul>
@endsection

@section('script')
    <script type="module" src="{{ secure_asset('/js/follow.js') }}"></script>
    <script type="module">
    $(function(){
         $('#follow-profile').on('click',function(){

            console.log('bbb');
            let url = $(this).data('route');
            let $this = $(this);

            let json = {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: url,  
            };

            // if($(this).text()=='Follow'){

            // }

            if($this.hasClass('following')){
                json.data={'_method':'DELETE'};
            }

            $.ajax(json).done(function(){

                if($this.hasClass('follow')){

                    let html = '<div class="w-100 text-dark text-center" >Followed!</div>';

                    $this.after(html);
                    $this.remove();
                    let followers_num = Number($('#followers').text())+1;
                    $('#followers').text(followers_num); 
                    console.log('bbb');

                }else if($this.hasClass('following')){

                    let html = '<div class="w-100 text-dark text-center" >Unfollowed...</div>';

                    $this.after(html);
                    $this.remove();
                    let followers_num = Number($('#followers').text())-1;
                    $('#followers').text(followers_num);
                    console.log('bbb');
                }


            }).fail(function(){
                alert('error dayo');
            }).always(function(){
                console.log('finished dayo');
            });


            });    
    });
    </script>
@endsection
