@extends('layout.app')

@section('content')
    <main class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <h3 class="mb-4">Aanmelden</h3>
                    <p>Laat uw gegevens achter en wij nemen zo spoedig mogelijk contact met u op.</p>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="row login__card">
                        <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('application.store') }}">
                            @csrf

                            <div class="login__name">
                                <input type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" value="{{ old('name') }}" placeholder="{{ trans('backpack::base.name') }}">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="login__row">
                                <input type="text" class="{{ $errors->has('company_name') ? 'is-invalid' : '' }}" name="company_name" id="company_name" value="{{ old('company_name') }}" placeholder="Bedrijfsnaam">

                                @if ($errors->has('company_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="login__row">
                                <input type="tel"  class="{{ $errors->has('phonenumber') ? 'is-invalid' : '' }}" name="phonenumber" id="phonenumber" value="{{ old('phonenumber') }}" placeholder="Telefoonnummer">

                                @if ($errors->has('phonenumber'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phonenumber') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{--                        <div class="login__company_name">--}}
                            {{--                            <input type="text" class="{{ $errors->has('company_name') ? 'is-invalid' : '' }}" name="name" id="name" value="{{ old('company_name') }}" placeholder="{{ trans('backpack::base.company_name') }}">--}}

                            {{--                            @if ($errors->has('company_name'))--}}
                            {{--                                <span class="invalid-feedback">--}}
                            {{--                                    <strong>{{ $errors->first('company_name') }}</strong>--}}
                            {{--                                </span>--}}
                            {{--                            @endif--}}
                            {{--                        </div>--}}

                            <div class="login__email">
                                <input type="{{ backpack_authentication_column()=='email'?'email':'text'}}" class="{{ $errors->has(backpack_authentication_column()) ? 'is-invalid' : '' }}" name="{{ backpack_authentication_column() }}" id="{{ backpack_authentication_column() }}" value="{{ old(backpack_authentication_column()) }}" placeholder="{{ config('backpack.base.authentication_column_name') }}">

                                @if ($errors->has(backpack_authentication_column()))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
                                    </span>
                                @endif
                            </div>

                            @if(!empty($packages))
                            <div class="login__row">
                                <select class="{{ $errors->has('package') ? 'is-invalid' : '' }}" name="package" id="package">
                                    <option>Voorkeur voor pakket:</option>
                                    @foreach($packages as $package)
                                        <option value="{{ $package->slug }}">{{ $package->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                                <div class="login__row">
                                    <select name="package" id="package">
                                        <option>Voorkeur voor pakket:</option>
                                        <option value="pakket-1">Pakket 1</option>
                                        <option value="pakket-2">Pakket 2</option>
                                        <option value="pakket-3">Pakket 3</option>
                                    </select>
                                </div>
                            @endif

                            <div class="login__row">
                                <textarea name="message" id="message" rows="10" class="{{ $errors->has('message') ? 'is-invalid' : '' }}" value="{{ old('message') }}" placeholder="Uw bericht aan ons:"></textarea>
                            </div>
                            <div class="login__row text-center">
                                <input id="general" type="checkbox" name="general-conditions"/><label for="general"> Ik ga akkoord met de <a href="@php echo e(url('/algemene-voorwaarden')) @endphp">algemene vooraarden</a>.</label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="button button--primary" disabled>
                                    Meld uw team aan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('blocks/contact-info-block')
    </main>
@endsection
