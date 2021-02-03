@extends('backpack::layouts.top_left')

@section('after_styles')
@endsection

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        __('coach.clients') => false
    ];
@endphp

@section('header')
    <div class="container mb-4">
        <section class="content-header">
            <h1 class="content-header__title">{{ __('coach.clients') }}</h1>
        </section>
    </div>
@endsection

@section('content')
    <section class="coaches">
        <div class="row">
            <div class="col-lg-8">
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

                    @if(!empty($clients) && sizeof($clients) > 0)
                        <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Cliënt</th>
                                    <th>Bedrijf</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->company->name }}</td>
                                        <td><a href="{{ route('coach.clients.show', ['id' => $client->id]) }}" class="btn btn-sm btn-link"><i class="fa fa-edit"></i> Antwoorden</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
            </div>
        </div>
    </section>
@endsection
