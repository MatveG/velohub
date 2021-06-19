<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\MetaService;

class DocumentController extends Controller
{
    public function __invoke(Document $document, string $slug)
    {
        $document = $document->where('slug', $slug)->where('is_active', true)->firstOrFail();

        $meta = MetaService::title($document->meta_title ?? $document->title)
            ->description($document->meta_description)
            ->keywords($document->meta_keywords);

        return view('document', compact(['document', 'meta']));
    }
}
