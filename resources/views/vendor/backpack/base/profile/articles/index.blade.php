@extends('backpack::layouts.top_left')

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        __('account.articles') => false,
    ];
@endphp

@section('header')
    <div class="container">
        <section class="content-header">
            <h1>{{ __('account.articles') }}</h1>
        </section>
    </div>
@endsection

@section('content')
    <section class="articles-overview">
        @if(!empty($goals) && sizeof($goals) > 0)
        <div class="filters">
            <div class="filters__goals d-flex flex-column flex-xl-row align-items-start align-items-lg-center">
                <div class="filters_col">
                    <h3>Doelen:</h3>
                </div>
                <div class="filters_col d-flex flex-column flex-lg-row flex-wrap">
                    @foreach($goals as $goal)
                        <div class="filters__filter-item">
                            <input name="filter" type="radio" class="filter-checkbox" value="{{ $goal->slug }}" id="{{ $goal->slug }}" data-class="article" data-type="filter" data-filter_value="goal-{{ $goal->slug }}">
                            <label for="{{ $goal->slug }}">{{ $goal->title }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="filters_col">
                    <div class="filters__filter-item">
                        <a href="#" onclick="return false;" id="resetFilters" data-type="filter">Wis selectie</a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row overview" data-class="articles-overview__article">
            @if(count($articles) > 0)
                @foreach($articles as $article)
                    <div class="articles-overview__article col-md-6 col-lg-6 col-xl-4 my-5 {{ $article->getGoalClasses() }}" data-goal="{{ $article->getGoalClasses() }}">
                        <a href="{{ route('profile.articles.show', ['slug' => $article['slug']]) }}">
                            <div class="articles-overview__image" style="background-image: url('/uploads/{{ $article->image }}');"></div>
                            <h3>{{ $article->title }}</h3>
                            <p>{!! substr(strip_tags ($article->content),0,100).'...' !!}</p>
                            <span class="button button--secondary">Bekijk blog</span>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="articles-overview__empty-state col-12 mt-5">
                    <h3>Er zijn nog geen blogs toegevoegd</h3>
                    <p>Neem <a href="{{ route('profile.coaches') }}">hier</a> contact met je coach</p>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('after_scripts')
    <script type="text/javascript" src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>
    <script type="text/javascript" src="{{ asset('js/filters.js') }}"></script>
@endsection
