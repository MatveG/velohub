<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, int $product_id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric',
            'text' => 'required|min:10',
            'author' => 'required|min:2',
        ]);

        if ($validator->fails()) {
            return back()->with('notify', 'Некорректно заполнены обязательные поля')->withInput();
        }

        $comment = new Comment();
        $comment->fill($request->all());
        $comment->product_id = $product_id;
        $comment->save();

        return back()->with('notify', 'Спасибо! Ваш отзыв будет скоро опубликован.');
    }
}
