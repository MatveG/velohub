@extends('layouts.main')

@section('content')
    <main role="main" class="content">
        <div id="showCart"></div>

        <hr>

        <di class="m-auto w-25">
            <div id="buyProduct"></div>
        </di>

{{--        <h1><span>{{ $document->name }}</span></h1>--}}

      {{ $document->text }}
    </main>
@stop
