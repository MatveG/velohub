@extends('layouts.master')

@section('content')
    <main role="main" class="content">
        <h1><span>{{ $content->name }}</span></h1>

      {{ $content->text }}
    </main>
@stop
