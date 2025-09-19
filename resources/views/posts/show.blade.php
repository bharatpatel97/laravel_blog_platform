@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">{{ $post->title }}</h4>
                </div>
                <div class="card-body">
                    <p class="fs-5">{{ $post->content }}</p>
                    <div class="mb-3 text-muted">
                        <small>
                            <i class="bi bi-person"></i> By <strong>{{ $post->user->name }}</strong> <br>
                            <i class="bi bi-calendar"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : 'Not Published' }}
                        </small>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back</a>
                        @if($post->user_id === auth()->id())
                            <div>
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning me-2">Edit</a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
