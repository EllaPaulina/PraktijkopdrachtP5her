<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'body' => 'required|max:500',
        ]);

        Comment::create([
            'article_id' => $articleId,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return redirect()->route('articles.index', $articleId)->with('success', 'Comment added successfully!');
    }
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Check if the authenticated user is an admin
        if (auth()->user()->is_admin) {
            $comment->delete();

            return back()->with('success', 'Comment deleted successfully.');
        }

        return back()->with('error', 'You are not authorized to delete this comment.');
    }

}
