<?php

namespace App\Http\Controllers;

use App\Models\Document;

class DocumentController extends Controller
{
    public function show(Document $content, string $slug)
    {
        $content = $content
            ->where('slug', $slug)
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
