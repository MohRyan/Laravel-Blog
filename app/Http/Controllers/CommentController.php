<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'comment' => $request->comment,
            'post_id' => $request->post_id,
            'user_id' => Auth::user()->id,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function reply(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'required|exists:comments,id',
        ]);

        Comment::create([
            'comment' => $request->comment,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Reply added successfully!');
    }
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);


        if (Auth::id() !== $comment->user_id && !Auth::user()->is_admin) {
            return back()->with('error', 'You are not authorized to delete this comment.');
        }

        $comment->replies()->delete();

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }

    public function count($postId)
    {
        // Hitung semua komentar untuk post tertentu (termasuk balasan)
        $totalComments = Comment::where('post_id', $postId)->count();

        return response()->json([
            'post_id' => $postId,
            'total_comments' => $totalComments,
        ]);
    }
}
