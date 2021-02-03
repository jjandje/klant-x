@extends('backpack::layouts.top_left')

@section('after_styles')
@endsection

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        __('coach.client') => false
    ];
@endphp

@section('header')
    <div class="container mb-4">
        <section class="content-header">
            <h1 class="content-header__title">{{ __('coach.client') }}</h1>
        </section>
    </div>
@endsection

@section('content')
    <section class="coaches">
        <div class="row">
            <div class="col-lg-6">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(session('errors'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach(session('errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form class="form" role="form" method="POST" action="{{ route('coach.clients.send', ['id' => $client->id]) }}">
                    @csrf
                    <div class="form-row">
                        <label class="coaches__label">{{ __('forms.the_subject') }}:</label>
                        <input type="text" name="subject" class="form-input">
                    </div>
                    <div class="form-row">
                        <label class="coaches__label">{{ __('forms.the_message') }}:</label>
                        <textarea class="form-input" rows="8" cols="10" name="message"></textarea>
                    </div>
                    <input type="hidden" name="coach_id" value="{{ $coach->id }}">
                    <button type="submit" class="button button--primary">{{ __('forms.send') }}</form>
                </form>
            </div>
            <div class="col-lg-6">
                <label class="coaches__label">{{ __('coach.your_client') }}</label>
                <div class="client">
                    <img class="client__image" src="{{ $client->image ? asset($client->image) : $client->defaultImage }}" alt="{{ $client->name }}"/>
                    <div class="client__description">
                        {{--@php $last_message = $client->sentMessagesTo($coach->id)->last(); @endphp--}}
                        {{--@if($last_message)--}}
                            {{--<label class="coaches__label">{{ $client->name }}'s vorige vraag:</label>--}}
                            {{--<p>Onderwerp: {{ ucfirst($last_message->subject) }},</p>--}}
                            {{--<p>Bericht: {{ $last_message->message }}</p>--}}
                        {{--@else--}}
                            <label class="coaches__label">{{ $client->name }}</label>
                            <p>{{ $client->about }}</p>
                        {{--@endif--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
