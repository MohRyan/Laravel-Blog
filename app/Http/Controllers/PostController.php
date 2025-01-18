<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    // ====================== View ======================
    public function index(Request $request)
    {
        $posts = Post::latest()->paginate(10);
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors('error', 'You must be logged in to create a post.');
        }

        return view('post.create');
    }

    public function showPost(Post $post)
    {
        return view('post.show', compact('post'));
    }

    // ====================== Post ======================
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors('error', 'You must be logged in to create a post.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('post.index')->with('success', 'Post created successfully.');
    }

    public function like($postId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $user = Auth::user();

        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json([
                'message' => 'Like removed',
                'status' => 'unliked',
                'likes_count' => $post->likes()->count()
            ]);
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            return response()->json([
                'message' => 'Like added',
                'status' => 'liked',
                'likes_count' => $post->likes()->count()
            ]);
        }
    }

    public function destroy(Post $post)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors('error', 'You must be logged in to delete a post.');
        }

        if ($post->user_id !== Auth::id()) {
            return redirect()->route('post.index')->withErrors('error', 'You do not have permission to delete this post.');
        }

        if ($post->image) {
            Storage::delete('public/' . $post->image);
        }

        $post->delete();

        return redirect()->route('post.index')->with('success', 'Post deleted successfully.');
    }
}
