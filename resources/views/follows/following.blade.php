@extends('layouts.app')

@section('title','Home')

@section('content')

    <div class="row">
        <div class="col">
            <a href="{{ route('profile.show',$user->id) }}" class="text-decoration-none">
                <i class="fa-solid fa-arrow-left me-2"></i>
                <span class="h5">{{ $user->username }}</span>
            </a>
        </div>
    </div>

    <h2 class="display-6 mt-4">Following</h2>

    @forelse ($follows as $follow)
        {{-- display all the followers --}}

        <div class="mt-2 border border-2 rounded py-3 px-4">
            <a href="{{ route('profile.show',$follow->followee_id) }}">
                <div class="row">
                    <div class="col-2">
                        @if($follow->followee->picture)
                            <div class="rounded rounded-circle">
                                <img src="{{ asset('storage/pictures/'.$follow->followee->picture) }}" alt="{{ $follow->followee->picture }}" class="d-block mx-auto dashboard-photo img-thumbnail"
                                style="width:3.5rem; height:3.5rem; object-fit:cover;">
                            </div>
                        @else
                            <div>
                                <i class="fa-regular fa-user d-block text-center dashboard-icon" style="font-size: 1rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-6">
                        <span>{{ $follow->followee->username }}</span>
                    </div>

                    <div class="col-4">
                        <form action="{{ route('follow.unfollow',[$follow->followee_id,$follow->follower_id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary">Following</button>
                        </form>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <div style="margin-top: 100px;">
            <h2 class="text-muted text-center">Following No One...</h2>
            <p class="text-center">
                <a href="{{ route('post.create') }}" class="text-decoration-none">Create a New Post.</a>
            </p>
        </div>
    @endforelse

@endsection

