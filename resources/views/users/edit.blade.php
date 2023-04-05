@extends('layouts.app')

@section('title','Edit Profile')

@section('content')

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="row mt-2 mb-3">
            <div class="col-4">
                @if ($user->picture)
                    <img src="{{ asset('storage/pictures/'.$user->picture) }}" alt="{{ $user->picture }}" class="img-thumbnail w-100">
                @else
                    <i class="fa-solid fa-image fa-10x d-block text-center"></i>
                @endif
            </div>
            <div class="col-8">
                <input type="file" name="picture" class="form-control mt-1" aria-describedby="image-info" accept="image/*">
                <div id="image-info" class="form-text">
                    Acceptable formats: jpeg, jpg, png, gif only <br>
                    Maximum file size: 1048kb
                </div>
                @error('picture')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name',$user->name) }}">
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username',$user->username) }}">
            @error('username')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" id="email" class="form-control" value="{{ old('email',$user->email) }}">
            @error('email')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-warning px-5">Save</button>
    </form>
    <button type="button" class="btn btn-danger text-white mt-5" data-bs-toggle="modal" data-bs-target="#delete-{{ $user->id }}">
        <i class="fa-solid fa-trash-can me-2"></i>Delete Account
    </button>
    @include('users.components.delete')
@endsection
