@extends('layout.app')

@section('content')
    <main class="main content-page">
        <div class="container">
            <h1>{{ $page->title ?? 'Pagina niet gevonden' }}</h1>
            <div class="content-page__description">{!! $page->content ?? '' !!}</div>
        </div>
    </main>
@endsection
