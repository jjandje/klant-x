@extends('backpack::layouts.top_left')

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        __('account.recipes') => false,
    ];
@endphp

@section('header')
    <div class="container">
        <section class="content-header">
            <h1>Recepten</h1>
        </section>
    </div>
@endsection

@section('content')
    <section class="recipes-overview">
        @if(!empty($dishes) && sizeof($dishes) > 0 || !empty($categories) && sizeof($categories) > 0)
            <div class="filters">
                @if(!empty($dishes) && sizeof($dishes) > 0)
                    <div class="filters__row d-flex flex-column flex-xl-row align-items-start align-items-lg-center">
                        <div class="filters_col">
                            <h3>Gerechtgang:</h3>
                        </div>
                        <div class="filters_col d-flex flex-column flex-lg-row flex-wrap">
                            @foreach($dishes as $dish)
                                <div class="filters__filter-item">
                                    <input name="dish" type="radio" class="filter-checkbox" value="{{ $dish->slug }}" id="{{ $dish->slug }}" data-class="recipe" data-type="dish" data-filter_value="dish-{{ $dish->slug }}">
                                    <label for="{{ $dish->slug }}">{{ $dish->title }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="filters_col">
                            <div class="filters__filter-item">
                                <a href="#" onclick="return false;" id="resetFilters" data-type="dish">Wis selectie</a>
                            </div>
                        </div>
                    </div>
                @endif
                {{--@if(!empty($goals) && sizeof($goals) > 0)--}}
                {{--<div class="filters__row d-flex flex-column flex-xl-row align-items-start align-items-lg-center">--}}
                    {{--<div class="filters_col">--}}
                        {{--<h3>Doelen:</h3>--}}
                    {{--</div>--}}
                    {{--<div class="filters_col d-flex flex-column flex-lg-row flex-wrap">--}}
                        {{--@foreach($goals as $goal)--}}
                            {{--<div class="filters__filter-item">--}}
                                {{--<input name="filter" type="radio" class="filter-checkbox" value="{{ $goal->slug }}" id="{{ $goal->slug }}" data-class="recipe" data-type="filter" data-filter_value="goal-{{ $goal->slug }}">--}}
                                {{--<label for="{{ $goal->slug }}">{{ $goal->title }}</label>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                    {{--<div class="filters_col">--}}
                        {{--<div class="filters__filter-item">--}}
                            {{--<a href="#" onclick="return false;" id="resetFilters" data-type="filter">Wis selectie</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--@endif--}}

                @if(!empty($categories) && sizeof($categories) > 0)
                    <div class="filters__row d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                        <div class="filters_col">
                            <h3>Eigenschappen:</h3>
                        </div>
                        <div class="filters_col d-flex flex-column flex-lg-row flex-wrap">
                            @foreach($categories as $category)
                                <div class="filters__filter-item">
                                    <input name="category" type="checkbox" class="filter-checkbox" value="{{ $category->slug }}" id="cat-{{ $category->slug }}" data-class="recipe" data-type="category" data-filter_group="category" data-filter_value="cat-{{ $category->slug }}"/>
                                    <label for="cat-{{ $category->slug }}">{{ $category->title }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="filters_col">
                            <div class="filters__filter-item">
                                <a href="#" onclick="return false;" id="resetFilters" data-type="category">Wis selectie</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div class="row overview" data-class="recipes-overview__recipe">
            @if(count($recipes) > 0)
                @foreach($recipes as $recipe)
                    <div class="recipes-overview__recipe col-md-6 col-lg-6 col-xl-4 my-5 {{ $recipe->getDishClasses() }} {{ $recipe->getGoalClasses() }} {{ $recipe->getCategoryClasses() }}" data-goals="{{ $recipe->getGoalClasses() }}" data-categories="{{ $recipe->getCategoryClasses() }}">
                        <a href="{{ route('profile.recipes.show', ['slug' => $recipe['slug']]) }}">
                            <div class="recipes-overview__image" style="background-image: url('/uploads/{{ $recipe->image }}');"></div>
                            <h3>{{ $recipe->title }}</h3>
                            <p>{!! substr(strip_tags($recipe->content),0,100).'...' !!}</p>
                            <span class="button button--secondary">Bekijk recept</span>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="recipes-overview__empty-state col-12 mt-3" data-goal="{{ $recipe->goal->slug ?? '' }}" data-category="{{ $recipe->category->slug ?? '' }}">
                    <h3>Er zijn nog geen recepten toegevoegd</h3>
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
