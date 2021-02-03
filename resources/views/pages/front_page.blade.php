@extends('layout.app')

@section('content')

    <main class="main">
        @include('blocks/hero-block')

        @include('blocks/usps-block')

        @include('blocks/image-text-block')

        @include('blocks/how-it-works-block')

        @include('blocks/goals-block')

        @include('blocks/recipes-block')
    </main>

@endsection
