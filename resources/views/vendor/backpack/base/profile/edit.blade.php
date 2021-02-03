@extends(backpack_view('blank'))

@section('after_styles')
    <style media="screen">
        .backpack-profile-form .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection

@php
    $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.edit') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="container">
        <div class="row">
            <section class="content-header">
                <div class="container-fluid mb-3">
                    <h1>{{ __('account.edit_profile') }}</h1>
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

            {{-- ACCOUNT INFO FORM --}}
            <div class="col-lg-12">
                <form action="{{ route('backpack.account.edit') }}" class="form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-6">
                            <h4>{{ __('account.name') }}</h4>
                            <p class="large"><input type="text" class="full-width"  name="name" value="{{ $user_info->name ?? '' }}"></p>
                        </div>
                        <div class="col-6">
                            @include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-3">
                            <h4>{{ __('account.age') }}</h4>
                            <p class="medium"><input type="number" class="full-width" step="1" min="1" max="99" name="age" value="{{ $user_info->age ?? '' }}"></p>
                        </div>
                        <div class="col-3">
                            <h4>{{ __('account.length') }}</h4>
                            <p class="medium"><input type="number" class="full-width" step="1" min="100" max="300" name="length" value="{{ $user_info->length ?? '' }}"> cm.</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                            <h4>{{ __('account.gender') }}</h4>
                            <p class="medium"><select name="gender">
                                    <option value="male" {{ !empty($user_info->gender) && $user_info->gender == 'male' ? 'selected' : '' }}>Man</option>
                                    <option value="female" {{ !empty($user_info->gender) && $user_info->gender == 'female' ? 'selected' : '' }}>Vrouw</option>
                                </select></p>
                        </div>
                        <div class="col-3">
                            <h4>{{ __('account.weight') }}</h4>
                            <p class="medium"><input type="number" class="full-width" step="1" min="10" max="200" name="weight" value="{{ $user_info->weight ?? '' }}"> kg.</p>
                        </div>
                        <div class="col-3">
                            <h4>{{ __('account.target_weight') }}</h4>
                            <p class="medium">
                                <input type="number" class="full-width" step="1" min="10" max="200" name="target_weight_min" value="{{ $user_info->target_weight_min ?? '' }}"> -
                                <input type="number" class="full-width" step="1" min="10" max="200" name="target_weight_max" value="{{ $user_info->target_weight_max ?? '' }}">
                            </p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12">
                            <button class="button button--primary" type="submit">{{ __('account.edit_profile') }}</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
