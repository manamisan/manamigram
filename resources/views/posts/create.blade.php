@extends('layouts.app')

@section('title','Create Post')

@section('content')
    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label text-muted">Title(optional)</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter title here" value="{{ old('title') }}" autofocus>
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label text-muted">Body</label>
            <textarea type="text" name="body" id="body" class="form-control" placeholder="Enter body here" value="{{ old('body') }}"></textarea>

            @error('body')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        @error('body')
                <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="mb-3">
            <label for="media" id="mediaLabel" class="form-label text-muted">Media(optional)</label>
            {{-- preview --}}
            <div class="row mb-2" id="preview"></div>

            <input type="file" name="media" id="media" class="form-control" accept="image/*, video/*" aria-describedby="media-info">

            <div class="form-text" id="media-info">
                Acceptable image formats: jpeg, jpg, png, gif only <br>
                Maximum image file size: 1048kB <br>
                <br>
                Acceptable video formats: mp4 only <br>
                Maximum video file size: 8MB (~10 seconds)<br>
            </div>

            @error('media')
                <p class="text-danger">{{ $message }}</p>
            @enderror

        </div>

        <button class="btn btn-primary px-5 mb-5">Post</button>
    </form>
@endsection
