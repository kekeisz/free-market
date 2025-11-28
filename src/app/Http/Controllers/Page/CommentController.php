<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item) {
        $data = $request->validated();

        Comment::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'body' => $data['body'],
        ]);
    }
}
