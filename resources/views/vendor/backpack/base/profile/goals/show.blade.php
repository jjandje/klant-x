@php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 2020-04-22
 * Time: 14:24
 */
@endphp

@extends('backpack::layouts.top_left')

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        __('account.goals') => route('profile.goals'),
        $goal->title => false,
    ];
@endphp

@section('header')
    <div class="container mb-4">
        <section class="content-header">
            <h1 class="content-header__title">{{ $goal->title }}</h1>
        </section>
    </div>
@endsection

@section('content')
<section class="goals-detail">
    <div class="row">
        <div class="col-lg-6">
            <p>{!! $goal->content !!}</p>

            @if(!empty($goal->workbook))
                <a href="/uploads/{!! $goal->workbook !!}" class="button button--primary mt-4 mb-5" download>Download werkboek</a>
            @endif

            <div class="my-5">
                <a href="{{ route('profile.recipes') }}#.goal-{{ $goal->slug }}" class="button button--secondary">Recepten</a>
            </div>
            <div class="my-3">
                <a href="{{ route('profile.articles') }}#.goal-{{ $goal->slug }}" class="button button--secondary">Blogs</a>
            </div>
            <div class="my-5">
                <a href="{{ route('profile.goals') }}" class="button button__previous button--secondary">Terug naar doelen</a>
            </div>
        </div>
    </div>
</section>
@endsection
