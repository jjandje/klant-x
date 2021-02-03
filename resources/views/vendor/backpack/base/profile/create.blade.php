@extends('backpack::layouts.top_left')

@section('after_styles')
    <style media="screen">
        .backpack-profile-form .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        trans('backpack::base.my_account') => false,
    ];
@endphp

@section('header')
    <div class="container">
        <div class="row">
            <section class="content-header">
                <div class="container-fluid mb-3">
                    <h1>Profiel aanmaken</h1>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">

            @if (session('success'))
                <div class="col-lg-8">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if ($errors->count())
                <div class="col-lg-8">
                    <div class="alert alert-danger">
                        <ul class="mb-1">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- UPDATE INFO FORM --}}
            <div class="col-lg-6">
                <form action="{{ route('backpack.account.create') }}" class="form" method="post">
                    @csrf
                    <div class="form-row">
                        <label>Naam</label>
                        <input class="full-width" type="text" name="name" placeholder="Wat is je voor en achternaam?" value="{{ !empty($user_info->name) ? $user_info->name : '' }}"/>
                    </div>
                    <div class="form-row">
                        <label>Leeftijd</label>
                        <input type="text" name="age" placeholder="Wat is je leeftijd?" value="{{ !empty($user_info->age) ? $user_info->age : '' }}"/>
                    </div>
                    <div class="form-row">
                        <label class="select">Geslacht</label>
                        <div class="select-wrap">
                            <select name="gender">
                                <option>Kies een optie</option>
                                <option value="male" {{ !empty($user_info->gender) && $user_info->gender == 'male' ? 'selected' : '' }}>Man</option>
                                <option value="female" {{ !empty($user_info->gender) && $user_info->gender == 'female' ? 'selected' : '' }}>Vrouw</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label>Lengte</label>
                        <input type="text" name="length" placeholder="Vul je lengte in in centimeters" value="{{ !empty($user_info->length) ? $user_info->length : '' }}"/> cm.
                    </div>
                    <div class="form-row">
                        <label>Gewicht</label>
                        <input type="text" name="weight" placeholder="Vul je gewicht in in kilogrammen" value="{{ !empty($user_info->weight) ? $user_info->weight : '' }}"/> kg.
                    </div>
                    <div class="form-row">
                        <label></label>
                        <button class="button button--primary" type="submit">Profiel aanmaken</button>
                    </div>
                </form>
                {{--<form class="form" action="{{ route('backpack.account.info') }}" method="post">--}}

                    {{--{!! csrf_field() !!}--}}

                    {{--<div class="card padding-10">--}}

                        {{--<div class="card-header">--}}
                            {{--{{ trans('backpack::base.update_account_info') }}--}}
                        {{--</div>--}}

                        {{--<div class="card-body backpack-profile-form bold-labels">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-md-6 form-group">--}}
                                    {{--@php--}}
                                        {{--$label = trans('backpack::base.name');--}}
                                        {{--$field = 'name';--}}
                                    {{--@endphp--}}
                                    {{--<label class="required">{{ $label }}</label>--}}
                                    {{--<input required class="form-control" type="text" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">--}}
                                {{--</div>--}}

                                {{--<div class="col-md-6 form-group">--}}
                                    {{--@php--}}
                                        {{--$label = config('backpack.base.authentication_column_name');--}}
                                        {{--$field = backpack_authentication_column();--}}
                                    {{--@endphp--}}
                                    {{--<label class="required">{{ $label }}</label>--}}
                                    {{--<input required class="form-control" type="{{ backpack_authentication_column()=='email'?'email':'text' }}" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="card-footer">--}}
                            {{--<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('backpack::base.save') }}</button>--}}
                            {{--<a href="{{ backpack_url() }}" class="btn">{{ trans('backpack::base.cancel') }}</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</form>--}}
            </div>

        </div>
    </div>
@endsection
