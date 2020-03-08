<?php

namespace App\Http\Controllers;

use App\Models\Content;

class ContentController extends Controller
{
    public function index(Content $content)
    {
        $content = $content->where('is_active', true)->orderBy('name')->get();

        return view('content', compact(['content']));
    }

    public function show(Content $content, string $latin)
    {
        $content = $content
            ->where('latin', $latin)
            ->where('is_active', true)
            ->firstOrFail();

        $seo = (object)[
            'title' => $content->seo_title,
            'description' => $content->seo_description,
            'keywords' => $content->seo_keywords,
        ];

        return view('content', compact(['seo', 'content']));
    }
}
