<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

use App\Mail\PostPublishedMail;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%");
            });
        }

        if ($request->has('author')) {
            $query->where('user_id', $request->author);
        }

        if ($request->has('date')) {
            $query->whereDate('published_at', $request->date);
        }

        $posts = $query->latest()->paginate(10);

        if ($request->wantsJson()) {
            return response()->json($posts, 200);
        }

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $post = Post::create([
            'title'        => $validated['title'],
            'content'      => $validated['content'],
            'published_at' => $validated['published_at'] ?? null,
            'user_id'      => auth()->id(),
        ]);

        $adminEmail = config('mail.admin_address');
        Mail::to($adminEmail)->send(new PostPublishedMail($post));

        if ($request->wantsJson()) {
            return response()->json($post, 201);
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function show(Request $request, Post $post)
    {
        if ($request->wantsJson()) {
            return response()->json($post, 200);
        }

        return view('posts.show', compact('post'));
    }

    public function edit(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            abort(403, 'Unauthorized action.');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $post
            ], 200);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $post->update($validated);

        if ($request->wantsJson()) {
            return response()->json($post, 200);
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $post->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Post deleted successfully'], 200);
        }

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}
