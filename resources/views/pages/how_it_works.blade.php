@extends('layout.app')

@section('content')

    <main class="main">
        @include('blocks/how-it-works-hero-block')

        @include('blocks/usps-block')

        @include('blocks/text-image-block')

        @include('blocks/benefits-block')
    </main>

@endsection
