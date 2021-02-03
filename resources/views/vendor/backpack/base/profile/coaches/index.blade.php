@extends('backpack::layouts.top_left')

@section('after_styles')
@endsection

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        __('account.coaches') => false
    ];
@endphp

@section('header')
    <div class="container mb-4">
        <section class="content-header">
            <h1 class="content-header__title">Coaches</h1>
        </section>
    </div>
@endsection

@section('content')
<section class="coaches">
    <div class="row">
        <div class="col-md-6 col-lg-12 col-xl-6">
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
            @if(!empty($coaches) && sizeof($coaches) > 0)
            <form class="form" role="form" method="POST" action="{{ route('profile.coaches.send') }}">
                @csrf
                @if(!empty($coaches) && sizeof($coaches) > 1)
                    <div class="form-row">
                        <label for="coach_ids">Ik heb een vraag voor:</label>
                        <div class="row">
                            @foreach($coaches as $coach)
                                <div class="d-flex align-items-center col">
                                    <input type="checkbox" name="coach_ids[]" id="coach-{{ $coach->id }}" value="{{ $coach->id }}" class="filter-checkbox">
                                    <label for="coach-{{ $coach->id }}" class="m-0">{{ $coach->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif(sizeof($coaches) === 1)
                    <input type="hidden" name="coach_ids[]" value="{{ implode(', ', $coaches->pluck('id')->toArray()) }}">
                @endif
                <div class="form-row">
                    <label class="coaches__label">Ik heb een vraag over:</label>
                    <div class="select-wrap">
                        <select name="subject">
                            <option>Maak een keuze</option>
                            @if(!empty($goals) && sizeof($goals) > 0)
                                @foreach($goals as $goal)
                                    <option value="{{ $goal['slug'] }}">{{ $goal['title'] }}</option>
                                @endforeach
                            @else
                            <option value="doelen">Doelen</option>
                            <option value="recepten">Recepten</option>
                            @endif
                            <option value="anders">Anders</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <label class="coaches__label">Stel je vraag:</label>
                    <textarea class="form-input" rows="8" cols="10" name="message"></textarea>
                </div>
                <input type="hidden" name="user_id" value="{{ backpack_user()->id }}">
                <button type="submit" class="button button--primary">Versturen</form>
            </form>
            @else
                <label class="coaches__label">Geen coach(es)</label>
                <div class="coaches__coach">
                    <div class="coaches__description">
                        <p>Je hebt nog geen coach(es), vraag je manager of je één coach of meerdere coaches toegewezen kan krijgen.</p>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-6 col-lg-12 col-xl-6 my-5 my-md-0 my-lg-5 my-xl-0">
            @if(!empty($coaches) && sizeof($coaches) > 0)
                <label class="coaches__label">Je {{ $coaches->count() > 1 ? 'coaches' : 'coach' }}</label>
                @foreach($coaches as $coach)
                    <div class="coaches__coach">
                        @if(!empty($coach->image) && $coach->image !==  '#')<img class="coaches__image" src="{{ asset($coach->image) }}" alt="{{ $coach->name }}"/>@endif
                        <div class="coaches__description">
                            {{--@php $last_response = $coach->receivedMessagesFrom(backpack_user()->id)->last(); @endphp--}}
                            {{--@if($last_response)--}}
                                {{--<label class="coaches__label">{{ $coach->name }}'s vorige antwoord:</label>--}}
                                {{--<p>Onderwerp: {{ ucfirst($last_response->subject) }}</p>--}}
                                {{--<p>Bericht: {{ $last_response->message }}</p>--}}
                            {{--@else--}}
                                <label class="coaches__label">{{ $coach->name }}</label>
                                <p>{{ $coach->about }}</p>
                            {{--@endif--}}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
@endsection
