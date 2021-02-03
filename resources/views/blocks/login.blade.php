@php $username = ''; @endphp
<section class="login">
    <h3 class="text-center mb-5">Ben jij er al klaar voor? Activeer je account!</h3>
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-8 col-lg-4">
            <div class="login__card">
                <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.login') }}">
                    {!! csrf_field() !!}

                    <div class="login__email">
                        <input type="text" class="{{ $errors->has($username) ? 'is-invalid' : '' }}" name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}" placeholder="{{ config('backpack.base.authentication_column_name') }}">

                        @if ($errors->has($username))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first($username) }}</strong>
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

                    <div class="text-center">
                        <button type="submit" class="button button--primary">
                            {{ trans('backpack::base.register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
