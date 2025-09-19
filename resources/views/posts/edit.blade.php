@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Post</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>There were some problems with your input:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('posts.update', $post) }}" method="POST">
                        @csrf 
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $post->title) }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="5" 
                                      class="form-control @error('content') is-invalid @enderror" 
                                      required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="published_at" class="form-label">Published At</label>
                            <input type="date" 
                                   name="published_at" 
                                   id="published_at" 
                                   class="form-control @error('published_at') is-invalid @enderror" 
                                   value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d') : '') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection