@extends('backpack::layouts.top_left')

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        trans('backpack::base.my_account') => false,
    ];
@endphp

@section('header')
<div class="container mb-4">
    <section class="content-header">
        <h1 class="content-header__title">{{ __('account.profile') }}</h1>
        <a class="content-header__edit" href="{{ route('profile.edit', ['id' => backpack_user()->userInfo->id]) }}">
            <i class="fa fa-pencil"></i>
            {{ __('general.edit') }}
        </a>
    </section>
</div>
@endsection

@section('content')

<section class="user-info">
    @if (session('success'))
        <div class="row">
            <div class="col-lg-8">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if ($errors->count())
        <div class="row">
            <div class="col-lg-8">
                <div class="alert alert-danger">
                    <ul class="mb-1">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- ACCOUNT INFO FORM --}}
    <div class="row d-flex align-items-center">
        <div class="col-9 col-lg-8 order-1 order-lg-0">
            <h4 class="user-info__title">{{ __('account.name') }}</h4>
            <p class="user-info__name">{{ $user_info->name ?? '-' }}</p>
        </div>
        <div class="col-lg-4 order-0 order-lg-1">
            {!! $user_info->profileImage !!}
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-3">
            <h4 class="user-info__title">{{ __('account.age') }}</h4>
            <p class="user-info__variable">{{ $user_info->age ?? '-' }}</p>
        </div>
        <div class="col-md-3">
            <h4 class="user-info__title">{{ __('account.length') }}</h4>
            <p class="user-info__variable">{{ $user_info->length ?? '-' }} cm.</p>
        </div>
        <div class="col-md-3">
            <h4 class="user-info__title">{{ __('account.bmi') }} {!! $user_bmi->bmiDotsHtml() !!}</h4>
            <p class="user-info__variable">{{ $user_bmi->bmi ?? '-' }}</p>
        </div>
    </div>

    <div class="row my-5">
        <div class="col-md-3">
            <h4 class="user-info__title">{{ __('account.gender') }}</h4>
            <p class="user-info__variable">{{ __('account.genders.'.$user_info->gender) }}</p>
        </div>
        <div class="col-md-3">
            <h4 class="user-info__title">{{ __('account.weight') }}</h4>
            <p class="user-info__variable">{{ $user_info->weight ?? '-' }} kg.</p>
        </div>
        <div class="col-md-3">
            <h4 class="user-info__title">{{ __('account.target_weight') }}</h4>
            <p class="user-info__variable">{{ $user_info->target_weight ?? '-' }} kg.</p>
        </div>
    </div>
</section>

<section class="user-goals mt-5">
    <div id="user-goals">
        @include(backpack_view('profile.goals.partials.user-goals', ['user_goals' => $user_goals]))
    </div>

    <div class="button" id="addGoal" data-uid="{{ backpack_user()->id }}">+ Voeg doel toe</div>
</section>

@if(!empty($favorite_recipes) && sizeof($favorite_recipes) > 0)
<section class="favorite-recipes my-5">
    <h4 class="user-info__title py-3">{{ __('account.favorite_recipes') }}</h4>
    <div class="row">
        @foreach($favorite_recipes as $recipe)
            <div class="col-lg-4">
                <div class="favorite-recipes__recipe">
                    <img class="favorite-recipes__image" src="{{ asset('/uploads/'. $recipe->image) }}" alt="{{ $recipe->title }}"/>
                    <a class="favorite-recipes__title" href="{{ route('profile.recipes.show', ['slug' => $recipe->slug]) }}">{{ $recipe->title }}</a>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

@if(!empty($favorite_articles) && sizeof($favorite_articles) > 0)
<section class="favorite-articles my-5">
    <h4 class="user-info__title py-3">{{ __('account.favorite_articles') }}</h4>
    <div class="row">
        @foreach($favorite_articles as $article)
            <div class="col-lg-4">
                <div class="favorite-articles__article">
                    <img class="favorite-articles__image" src="{{ asset('/uploads/'. $article->image) }}" alt="{{ $article->title }}"/>
                    <a class="favorite-articles__title" href="{{ route('profile.articles.show', ['slug' => $article->slug]) }}">{{ $article->title }}</a>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<div class="popup-wrapper" id="addGoalPopup">
    <div class="popup">
        <div class="popup_head">
            <h2>Doel toevoegen</h2>
            <div class="popup_close">&times;</div>
        </div>
        <div class="popup_description">
            <p>Kies hieronder het doel dat je wilt toevoegen.</p>
        </div>
        <div class="popup_goals">
            <div class="form-row">
                <div class="select-wrap">
                    <select name="popupgoal" id="popupGoals">
                        @include(backpack_view('profile.goals.partials.inactive-user-goals', ['goals' => $goals]))
                    </select>
                </div>
            </div>
        </div>
        <div class="popup_actions d-flex align-items-center justify-content-between">
            <div class="button" id="popupStartGoalLater" data-uid="{{ backpack_user()->id }}">Start later</div>
            <div class="button button--primary" id="popupStartGoalNow" data-uid="{{ backpack_user()->id }}">Start nu</div>
        </div>
    </div>
</div>

@endsection

@section('after_scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $(document).ready(function(){
            if($('#popupGoals option').length > 0) {
                $('#addGoal').addClass('show');
            } else {
                $('#addGoal').removeClass('show');
            }
        });

        $(document).on('click', '#addGoal', function() {
            var user_id = $(this).attr('data-uid');
            $.ajax({
                type: 'POST',
                url: '/platform/goals/inactivegoals',
                data: {uid: user_id},
                success: function(data) {
                    if(data.success) {
                        $('#popupGoals').empty().append(data.view);
                    }
                }
            });
            $('#addGoalPopup').addClass('open');
        });

        $('.popup_close').on('click', function() {
            if($('#addGoalPopup').hasClass('open')) {
                $('#addGoalPopup').removeClass('open');
            }
        });


        function ajaxCall(user_id, goal_id, action) {
            $.ajax({
                type: 'POST',
                url: '/platform/goals/goalaction',
                data: {uid: user_id, gid: goal_id, action: action},
                success: function(data) {
                    if($('#addGoalPopup').hasClass('open')) {
                        $('#addGoalPopup').removeClass('open');
                    }
                    if(data.success) {
                        $('#user-goals').empty().append(data.view);
                    }
                }
            })
        }

        // popups
        $('#popupStartGoalNow').on('click', function(e) {
            e.preventDefault();
            var $this = $(this),
                user_id = $this.attr('data-uid'),
                goal_id = $('select#popupGoals option:selected').val();

            if($('#popupGoals option').length > 1) {
                $('#addGoal').addClass('show');
            } else {
                $('#addGoal').removeClass('show');
            }

            ajaxCall(user_id, goal_id, 'startgoal');
        });

        $('#popupStartGoalLater').on('click', function(e) {
            e.preventDefault();
            var $this = $(this),
                user_id = $this.attr('data-uid'),
                goal_id = $('select#popupGoals option:selected').val();

            ajaxCall(user_id, goal_id, 'addgoal');
        });

        // view
        $(document).on('click', '#startGoal', function(e) {
            e.preventDefault();
            var $this = $(this),
                goal_id = $this.attr('data-gid'),
                user_id = $this.attr('data-uid');

            ajaxCall(user_id, goal_id, 'startgoal');
        });
        $(document).on('click', '#restartGoal', function(e) {
            e.preventDefault();
            var $this = $(this),
                goal_id = $this.attr('data-gid'),
                user_id = $this.attr('data-uid');

            ajaxCall(user_id, goal_id, 'restartgoal');
        });
        $(document).on('click', '#stopGoal', function(e) {
            e.preventDefault();
            var $this = $(this),
                goal_id = $this.attr('data-gid'),
                user_id = $this.attr('data-uid');

            $('#addGoal').addClass('show');

            ajaxCall(user_id, goal_id, 'stopgoal');
        });
    </script>
@endsection
