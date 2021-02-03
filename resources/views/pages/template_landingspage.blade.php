@extends('layout.app')

@section('content')

    <main class="main">
        @include('blocks/hero-block')

        @include('blocks/login')

        @include('blocks/usps-block')
    </main>

@endsection
