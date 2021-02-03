@extends('backpack::layouts.top_left')

@section('after_styles')
@endsection

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        __('account.goals') => false
    ];
@endphp

@section('header')
    <div class="container mb-4">
        <section class="content-header">
            <h1 class="content-header__title">{{ __('account.goals') }}</h1>
        </section>
    </div>
@endsection

@section('content')
    <section class="goals-overview">
        <div class="row">
            @if(count($goals) > 0)
                @foreach($goals as $key => $goal)
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <a href="goals/{{ $goal['slug'] }}">
                            <div class="goals-overview__image" style="background-image: url('/uploads/{!! $goal->image !!}');"></div>
                            <span class="button button--secondary mt-2 mb-5">{{ $goal['title'] }}</span>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="goals-overview___emtpy-state col-12 mt-3">
                    <h3>Er zijn nog geen doelen toegevoegd</h3>
                    <p>Neem <a href="{{ route('profile.coaches') }}">hier</a> contact met je coach</p>
                </div>
            @endif
        </div>
    </section>
@endsection
