@extends('layouts.main')

@section('content')
    <main role="main" class="content">
        <h1><span>{{ $document->name }}</span></h1>

      {{ $document->text }}
    </main>
@stop
