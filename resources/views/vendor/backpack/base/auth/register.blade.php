@extends('layout.app')


@dump( $locale = App::getLocale() )

@section('content')
    <main class="login">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-4">
                <h3 class="mb-4">{{ trans('backpack::base.register') }}</h3>
                <p>Laat uw gegevens achter en wij nemen zo spoedig mogelijk contact met u op.</p>
                <div class="row login__card">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.register') }}">
                        {!! csrf_field() !!}

                        <div class="login__name">
                            <input type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" value="{{ old('name') }}" placeholder="{{ trans('backpack::base.name') }}">

                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
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

                        <div class="login__password">
                            <input type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" id="password" placeholder="{{ trans('backpack::base.password') }}">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="login__password">
                            <input type="password" class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" name="password_confirmation" id="password_confirmation" placeholder="{{ trans('backpack::base.confirm_password') }}">

                            @if ($errors->has('password_confirmation'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="text-center">
                            <button type="submit" class="button button--primary">
                                {{ trans('backpack::base.register') }}
                            </button>
                        </div>
                    </form>
                </div>
                @if (backpack_users_have_email())
                    <div class="text-center"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
                @endif
                <div class="text-center"><a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a></div>
            </div>
        </div>
        @include('blocks/contact-info-block')
    </main>
@endsection
