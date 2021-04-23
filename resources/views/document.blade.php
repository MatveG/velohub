@extends('layouts.main')

@section('content')
    <main role="main" class="content">
        <h1><span>{{ $document->title }}</span></h1>

        <div class="w-75 m-auto">
            {!! $document->text !!}
        </div>
    </main>
@stop
