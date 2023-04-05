<div id="card-footer" class="card-footer border-top pt-0">
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
                <div class="col"><p>Liked by {{ $post->likes[0]->user->username }} and others</p></div>         
            @else
                <div class="col"><p>Not liked yet.</p></div>       
            @endif
        </div>
    </h5>
</div>