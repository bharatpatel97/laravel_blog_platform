@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Posts</h1>

        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-primary">+ Add New Post</a>
        @endauth
    </div>

    <form method="GET" action="{{ route('posts.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" 
                   name="search" 
                   class="form-control" 
                   placeholder="Search posts by title or content..."
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Published At</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $index => $post)
                        <tr>
                            <td>{{ $posts->firstItem() + $index }}</td>
                            <td>
                                <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                                    {{ $post->title }}
                                </a>
                                <div class="text-muted small">
                                    {{ Str::limit($post->content, 60) }}
                                </div>
                            </td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->published_at ? $post->published_at->format('Y-m-d') : 'Not Published' }}</td>
                            <td class="text-end">
                                @if($post->user_id === auth()->id())
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this post?')">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-secondary">View Only</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
