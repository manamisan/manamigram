@extends('layouts.app')

@section('title','Show Post')

@section('content')

    <div class="mt-2 border border-2 rounded py-3 px-4 shadow-sm">
        <div class="row flex-nowrap align-items-center">
            <div class="col-3">
                @if($post->user->picture)
                    <div class="rounded rounded-circle">
                        <img src="{{ asset('storage/pictures/'.$post->user->picture) }}" alt="{{ $post->user->picture }}" class="d-block mx-auto dashboard-photo img-thumbnail"
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
            <div class="col">
                @guest
                            <a class="btn btn-outline-secondary" 
                            href="
                                @if (Route::has('login'))
                                    {{ route('login') }}
                                @else
                                    #
                                @endif
                            "
                            >Follow</a>
                        @endguest
                        @auth                            
                            @if($post->user->id != Auth::user()->id)
                                @if(!$post->user->isFollowedBy(Auth::user()->id))
                                {{-- <p>ssssss</p> --}}
                                {{-- <form action="{{ route('follow.follow',[$post->user->id,Auth::user()->id]) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-info w-100 text-white follow-index">Follow</button>
                                </form> --}}

                            
                                    <span class="btn btn-info w-100 text-white follow-index follow-{{ $post->user->id }}" data-followee_id="{{ $post->user->id }}" data-follower_id="{{ Auth::user()->id }}" data-route="{{ route('follow.follow',[$post->user->id,Auth::user()->id]) }}">Follow</span>

                                {{-- @else
                                    <p>ssssss</p> --}}
                                @endif

                            {{-- @else --}}
                            @endif
                        @endauth
            </div>

            {{-- button --}}
            <div class="col nav-item dropdown text-end">
                <a id="navbarDropdown" class="nav-link fs-3" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fa-solid fa-ellipsis"></i>
                </a>

                @guest
                @else
                    
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
                            <a href="#" class="bg-info dropdown-item text-white">
                                <i class="fa-solid fa-share-nodes me-2"></i>Share
                            </a>
                        
                    </div>
                    @include('posts.components.delete')
                @endguest
            </div>
        </div>

        @if ( preg_match( "/.*?\.jpg|.*?\.png|.*?\.gif|.*?\.jpeg/i", $post->media))
            <img src="{{ secure_asset('storage/media/'.$post->media) }}" class="w-100 shadow mt-2" alt="{{ $post->media }}">
        @elseif(preg_match( "/.*?\.mp4/i", $post->media))
            <video controls autoplay loop muted class="w-100 shadow mt-2">
                <source src="{{ secure_asset('storage/media/'.$post->media) }}" type="video/mp4">
            </video>
        @else
            <p class="text-muted">This file can't be read</p>             
        @endif

        {{-- <img src="{{ asset('storage/media/'.$post->media) }}" alt="{{ $post->media }}" class="w-100 shadow mt-2"> --}}
        <h2 class="h4 mt-2">{{ $post->title }}</h2>
        <p class="full">{{ $post->body }}</p>
    </div>

    @auth
        <form action="{{ route('comment.store', $post->id) }}" method="POST">
            @csrf
            <div class="input-group my-5">
                <input type="text" class="form-control" name="comment" value="{{ old('comment') }}" placeholder="Add a comment...">

                <button class="btn btn-outline-secondary">Post</button>
            </div>
            @error('comment')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </form>
    @endauth
    @guest
        <a class="btn btn-info text-white w-100 my-5 fs-3" href="{{ route('login') }}">To post comments, need to log in</a>
    @endguest


    <div class="mt-2 mb-5">
        <h2 class="display-6 border-bottom">Comments</h2>
        @forelse ($post->comments->sortByDesc('created_at') as $comment)
        <div class="row p-2">
            <div class="col-8">
                <span class="fw-bold">{{ $comment->user->username }}</span>
                <span class="ms-2 small text-muted">
                    {{ $comment->created_at->diffForHumans() }}
                </span>
                <p class="full mb-0">{{ $comment->body }}</p>
            </div>
            <div class="col-4 text-end">
                @auth
                    {{-- check if the coomment is from the currently logging in user  --}}
                    @if($comment->user->id === Auth::user()->id)

                        @include('posts.components.modal')

                        <form action="{{ route('comment.destroy',$comment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Delete Comment">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
        @empty
            <h3 class="display-6">No comments yet...</h3>
        @endforelse
    </div>

@endsection
