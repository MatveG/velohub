<?php

namespace App\Http\Controllers;

use App\Models\Document;

class DocumentController extends Controller
{
    public function show(Document $document, string $slug)
    {
        $document = $document
            ->where('slug', $slug)
            ->isActive()
            ->firstOrFail();

        $meta = (object)[
            'title' => $document->seo_title,
            'description' => $document->seo_description,
            'keywords' => $document->seo_keywords,
        ];

        return view('document', compact(['document', 'meta']));
    }
}
