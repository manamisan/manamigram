@extends('layouts.app')

@section('title','Edit Post')

@section('content')

<form action="{{ route('post.update',$post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    {{-- patch update --}}
    <div class="mb-3">
        <label for="title" class="form-label text-muted">Title</label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Enter title here" value="{{ old('title',$post->title) }}" autofocus>
        @error('title')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="body" class="form-label text-muted">Body</label>
        <textarea type="text" name="body" id="body" class="form-control" placeholder="Enter body here">{{ old('title',$post->body) }}</textarea>

        @error('body')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label for="image" class="form-label text-muted">Image</label>

            <img src="{{ asset('/storage/images/'.$post->image) }}" alt="{{ $post->image }}" class="w-100 img-thumbnail">
            <input type="file" name="image" id="image" class="form-control" accept="image/*" aria-describedby="image-info">
            <div class="form-text" id="image-info">
                Acceptable formats: jpeg, jpg, png, gif only <br>
                Maximum file size: 1048kb
            </div>

            @error('body')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <button class="btn btn-warning px-5">Save</button>
</form>

@endsection
