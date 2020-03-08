<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, Comment $comment, int $product_id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric',
            'text' => 'required|min:10',
            'author' => 'required|min:2',
        ]);

        if ($validator->fails()) {
            return back()->with('notify', 'Некорректно заполнены обязательные поля')->withInput();
        }

        $comment->product_id = $product_id;
        $comment->fill($request->all());
        $comment->save();

        return back()->with('notify', 'Спасибо! Отзыв будет скоро опубликован.');
    }
}
