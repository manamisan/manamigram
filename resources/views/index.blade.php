@extends('layouts.app')

@section('title','Home')

@section('content')
    {{-- <p>{{ secure_asset('storage/media/') }}</p> --}}
    @forelse ($all_posts as $post)
        {{-- display all of the posts --}}

        <div class="card mb-2">
            <div class="card-header">
                {{-- <p>{{ $post->video() }}</p> --}}
                <div class="row flex-nowrap align-items-center">
                    <div class="col-3">
                        @if($post->user->picture)
                            <div class="rounded rounded-circle">
                                <img src="{{ secure_asset('storage/pictures/'.$post->user->picture) }}" alt="{{ $post->user->picture."aa" }}" class="d-block mx-auto dashboard-photo img-thumbnail"
                                style="width:3.5rem; height:3.5rem; object-fit:fill;">
                                {{-- <img src="https://manami-math.site/manamigram/public/storage/media/1673457844.jpg" alt="{{ $post->user->picture."aa" }}" class="d-block mx-auto dashboard-photo img-thumbnail"
                                style="width:3.5rem; height:3.5rem; object-fit:fill;"> --}}
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
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a href="#" class="bg-info dropdown-item text-white">
                                    <i class="fa-solid fa-share-nodes me-2"></i>Share
                                </a>
                            </div>
                        @endguest
                        @auth
                            
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
                        @endauth
                    </div>
                </div>
            </div>

            @if ( preg_match( "/.*?\.jpg|.*?\.png|.*?\.gif|.*?\.jpeg/i", $post->media))
                <img src="{{ secure_asset('storage/media/'.$post->media) }}" class="card-img-top border-bottom" alt="{{ $post->media }}">
            @elseif(preg_match( "/.*?\.mp4/i", $post->media))
                <video controls loop muted class="card-img-top border-bottom">
                    <source src="{{ secure_asset('storage/media/'.$post->media) }}" type="video/mp4">
                </video>
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
                                <a class="btn btn-outline-secondary border-0 text-dark" href="{{ route('post.show',$post->id) }}">
                                    <i class="fa-regular fa-comment"></i>
                                </a>
                            </div>
                            <div class="col">
                                <a class="btn btn-outline-secondary border-0 text-dark" href="{{ route('login') }}">
                                    <i class="fa-regular fa-bookmark"></i>
                                </a>
                            </div>
                        @endguest
                        @auth
                            <div class="col">

                                @if ($post->isLikedBy(Auth::user()->id))
                                    {{-- <form action="{{ route('like.removeLike',[Auth::user()->id, $post->id] ) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-secondary border-0 text-dark">
                                            <i class="fa-solid fa-heart text-danger"></i>
                                        </button>
                                    </form> --}}

                                    <span class="btn btn-outline-secondary border-0 text-dark like liked" data-route="{{ route('like.removeLike',[Auth::user()->id, $post->id] ) }}">
                                        <i class="fa-solid fa-heart text-danger"></i>
                                    </span>

                                    <span class="btn btn-outline-secondary border-0 text-dark d-none">
                                        <i class="fa-regular fa-heart me-2"></i>removed...
                                    </span>
                                @else
                                    {{-- <form action="{{ route('like.addLike',[Auth::user()->id, $post->id] ) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-outline-secondary border-0 text-dark">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </form> --}}
                                    
                                    <span class="btn btn-outline-secondary border-0 text-dark like" data-route="{{ route('like.addLike',[Auth::user()->id, $post->id] ) }}">
                                        <i class="fa-regular fa-heart"></i>
                                    </span>

                                    <span class="btn btn-outline-secondary border-0 d-none">
                                        <i class="fa-solid fa-heart text-danger me-2"></i>liked!
                                    </span>
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
                        @endauth
                    </div>

                    <div class="row">
                        @if (isset($post->likes[0]))
                            <div class="col"><p>
                                Liked by {{ $post->likes[0]->user->username }} 
                                @if(isset($post->likes[1]))
                                @if(isset($post->likes[2]))
                                    and others
                                @else
                                    and another
                                @endif
                                @endif
                            </p></div>         
                        @else
                            <div class="col"><p>Not liked yet.</p></div>       
                        @endif
                    </div>
                </h5>
            </div>

            {{-- @include('components.card-footer') --}}

        </div>


    @empty
        <div style="margin-top: 100px;">
            <h2 class="text-muted text-center">No Posts Yet.</h2>
            <p class="text-center">
                <a href="{{ route('post.create') }}" class="text-decoration-none">Create a New Post.</a>
            </p>
        </div>
    @endforelse

    {{-- pagination --}}
    <div class="d-flex justify-content-center mt-3 mb-5">
        {{ $all_posts->links() }}
    </div>

@endsection

@section('script')
    <script type="module" src="{{ secure_asset('/js/follow.js') }}"></script>

    <script type="module">
    $(function(){

        if($('video').length){
            $(window).on('scroll resize', function () {
                var windowScrollTop = $(window).scrollTop();
                var windowInnerHeight = window.innerHeight;

                var $video = $('video');
                var videoTop = $('video').offset().top;
                var videoHeight = $('video').innerHeight();

                // videoが停止している、かつvideoが画面内に入ってきた場合、再生処理
                if ($video[0].paused && (windowScrollTop + windowInnerHeight > videoTop)) {
                $video[0].play();
                }

                // videoが再生中、かつ画面外に出た場合、停止処理
                if (!$video[0].paused && ((windowScrollTop + windowInnerHeight < videoTop) || (windowScrollTop > videoTop + videoHeight))) {
                $video[0].pause();
                }
            }).trigger('scroll');
        }

         $('.like').on('click',function(){

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

            if($this.hasClass('liked')){
                json.data={'_method':'DELETE'};
            }

            $.ajax(json).done(function(){

                $this.next().removeClass('d-none');
                $this.remove();

                // $.ajax({
                //     headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     method: "POST",
                //     url: "/components/card-footer.blade.php",
                //     data:{val:"test"},
                //     timeout:10000,
                //     dataType:'text'
                // }).done(function(data){

                //     $('#card-footer').html(data);

                // }).fail(function(){
                //     alert('error dayo');
                // }).always(function(){
                //     console.log('finished dayo');
                // });

            }).fail(function(){
                alert('error dayo');
            }).always(function(){
                console.log('finished dayo');
            });

        });    
    });
    </script>
@endsection