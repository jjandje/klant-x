@extends('backpack::layouts.top_left')

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        __('account.recipes') => route('profile.recipes'),
        $recipe->title => false,
    ];
@endphp

@section('header')
    <div class="container mb-4">
        <section class="content-header">
            <h1 class="content-header__title">{{ $recipe->title }}</h1>
        </section>
    </div>
@endsection

@section('content')
    <section class="recipes-detail">
        <div class="row">
            <div class="col-lg-6 order-1 order-lg-0 mt-5 mt-lg-0">
                <div class="recipes-detail__recipe-info d-flex flex-row align-items-center">
                    @if($recipe->getAuthorName())
                        <div class="recipes-detail__text d-flex flex-row align-items-center">
                            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="user-chart" class="nav-icon svg-inline--fa fa-user-chart fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M608 0H192c-17.67 0-32 14.33-32 32v96c-53.02 0-96 42.98-96 96s42.98 96 96 96 96-42.98 96-96c0-41.74-26.8-76.9-64-90.12V32h416v352H305.34c-.59-.94-1.03-1.96-1.65-2.88-17.25-25.62-46.67-39.11-76.9-39.11C199 342.02 192.02 352 160 352c-31.97 0-38.95-9.98-66.79-9.98-30.23 0-59.65 13.48-76.9 39.11C6.01 396.42 0 414.84 0 434.67V472c0 22.09 17.91 40 40 40h240c22.09 0 40-17.91 40-40v-37.33c0-6.41-.84-12.6-2.04-18.67H608c17.67 0 32-14.33 32-32V32c0-17.67-14.33-32-32-32zM224 224c0 35.29-28.71 64-64 64s-64-28.71-64-64 28.71-64 64-64 64 28.71 64 64zm64 248c0 4.41-3.59 8-8 8H40c-4.41 0-8-3.59-8-8v-37.33c0-12.79 3.75-25.13 10.85-35.67 10.53-15.64 29.35-24.98 50.36-24.98 21.8 0 29.99 9.98 66.79 9.98 36.79 0 45.01-9.98 66.79-9.98 21 0 39.83 9.34 50.36 24.98 7.1 10.54 10.85 22.88 10.85 35.67V472zm50.62-319.31c-9.38-9.38-24.56-9.38-33.94 0l-25.49 25.49c4.56 11.72 7.3 24.17 8.21 37.04l34.25-34.25L384.69 244c4.69 4.69 10.81 7.02 16.97 7.02s12.28-2.33 16.97-7.02l58.97-58.97 33.24 33.24c3.96 3.96 8.82 5.73 13.6 5.73 9.99 0 19.57-7.76 19.57-19.47v-95.58c0-7.15-5.8-12.95-12.95-12.95h-95.58c-17.31 0-25.98 20.93-13.74 33.17l33.24 33.24-53.31 53.31-63.05-63.03zM512 128v46.18L465.82 128H512z"></path></svg>
                            <p>{{ $recipe->getAuthorName() }}</p>
                        </div>
                    @endif

                    @if($recipe->getGoalNames())
                        <div class="recipes-detail__text d-flex flex-row align-items-center">
                            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="bullseye" class="nav-icon svg-inline--fa fa-bullseye fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="currentColor" d="M248 92c-90.65 0-164 73.36-164 164 0 90.65 73.36 164 164 164 90.65 0 164-73.36 164-164 0-90.65-73.36-164-164-164zm0 296c-72.79 0-132-59.21-132-132s59.21-132 132-132 132 59.21 132 132-59.21 132-132 132zm0-212c-44.11 0-80 35.89-80 80s35.89 80 80 80 80-35.89 80-80-35.89-80-80-80zm0 128c-26.47 0-48-21.53-48-48s21.53-48 48-48 48 21.53 48 48-21.53 48-48 48zm0-296C111.03 8 0 119.03 0 256s111.03 248 248 248 248-111.03 248-248S384.97 8 248 8zm0 464c-119.1 0-216-96.9-216-216S128.9 40 248 40s216 96.9 216 216-96.9 216-216 216z"></path></svg>
                            {!! $recipe->getGoalsHTML() !!}
                        </div>
                    @endif
                    @if($recipe->getCategoryNames())
                        <div class="recipes-detail__text d-flex flex-row align-items-center">
                            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="tag" class="svg-inline--fa fa-tag fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.941 225.941L286.059 14.059A48 48 0 0 0 252.118 0H48C21.49 0 0 21.49 0 48v204.118a48 48 0 0 0 14.059 33.941l211.882 211.882c18.745 18.745 49.137 18.746 67.882 0l204.118-204.118c18.745-18.745 18.745-49.137 0-67.882zm-22.627 45.255L271.196 475.314c-6.243 6.243-16.375 6.253-22.627 0L36.686 263.431A15.895 15.895 0 0 1 32 252.117V48c0-8.822 7.178-16 16-16h204.118c4.274 0 8.292 1.664 11.314 4.686l211.882 211.882c6.238 6.239 6.238 16.39 0 22.628zM144 124c11.028 0 20 8.972 20 20s-8.972 20-20 20-20-8.972-20-20 8.972-20 20-20m0-28c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48z"></path></svg>
                            {!! $recipe->getCategoriesHTML() !!}
                        </div>
                    @endif
                </div>

                <p>{!! $recipe->content !!}</p>

                @if(!empty($recipe->preparation))
                    <div class="recipes-detail__subtitle">Bereiding</div>
                    <p>{!! $recipe->preparation !!}</p>
                @endif
            </div>
            <div class="offset-lg-1 col-lg-5 order-0 order-lg-1">
                <div class="recipes-detail__actions d-flex flex-row align-items-center">
                    <div class="recipes-detail__link d-flex flex-row align-items-center{{ backpack_user()->favoriteRecipes->contains($recipe->id) ? ' active' : '' }}" id="addRecipeToFavorites" data-uid="{{ backpack_user()->id }}" data-rid="{{ $recipe->id }}">
                        <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="heart" class="svg-inline--fa fa-heart fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M462.3 62.7c-54.5-46.4-136-38.7-186.6 13.5L256 96.6l-19.7-20.3C195.5 34.1 113.2 8.7 49.7 62.7c-62.8 53.6-66.1 149.8-9.9 207.8l193.5 199.8c6.2 6.4 14.4 9.7 22.6 9.7 8.2 0 16.4-3.2 22.6-9.7L472 270.5c56.4-58 53.1-154.2-9.7-207.8zm-13.1 185.6L256.4 448.1 62.8 248.3c-38.4-39.6-46.4-115.1 7.7-161.2 54.8-46.8 119.2-12.9 142.8 11.5l42.7 44.1 42.7-44.1c23.2-24 88.2-58 142.8-11.5 54 46 46.1 121.5 7.7 161.2z"></path></svg>
                        <p>Favoriet</p>
                    </div>
                    <a href="#" class="recipes-detail__link d-flex flex-row align-items-center" onclick="window.print()">
                        <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="print" class="svg-inline--fa fa-print fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M432 192h-16v-82.75c0-8.49-3.37-16.62-9.37-22.63L329.37 9.37c-6-6-14.14-9.37-22.63-9.37H126.48C109.64 0 96 14.33 96 32v160H80c-44.18 0-80 35.82-80 80v96c0 8.84 7.16 16 16 16h80v112c0 8.84 7.16 16 16 16h288c8.84 0 16-7.16 16-16V384h80c8.84 0 16-7.16 16-16v-96c0-44.18-35.82-80-80-80zM320 45.25L370.75 96H320V45.25zM128.12 32H288v64c0 17.67 14.33 32 32 32h64v64H128.02l.1-160zM384 480H128v-96h256v96zm96-128H32v-80c0-26.47 21.53-48 48-48h352c26.47 0 48 21.53 48 48v80zm-80-88c-13.25 0-24 10.74-24 24 0 13.25 10.75 24 24 24s24-10.75 24-24c0-13.26-10.75-24-24-24z"></path></svg>
                        <p>Print recept</p>
                    </a>
                </div>

                <div class="recipes-detail__image">
                    <img src="/uploads/{!! $recipe->image !!}" alt="{{ $recipe->title }}"/>
                </div>

                @if(count($recipe->ingredients) > 0)
                    <div class="recipes-detail__ingredients">
                        <div class="recipes-detail__subtitle">INGREDIËNTEN</div>
                        <ul>
                            @foreach($recipe->ingredients as $ingredient)
                                <li>{{ $ingredient['name'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection


@section('after_scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        function ajaxCall(user_id, recipe_id) {
            $.ajax({
                type: 'POST',
                url: '/platform/recipes/addtofavorite',
                data: {uid: user_id, rid: recipe_id},
                success: function(data) {
                    console.log(data);
                    if(data.success) {
                        // Add success message (data.message) with success class
                        $('#addRecipeToFavorites').addClass('active');
                        new Noty({
                            type: 'success',
                            text: data.message,
                            timeout: 2000,
                        }).show();
                    } else {
                        // Add "error" message (data.message) with error class
                        $('#addRecipeToFavorites').removeClass('active');
                        new Noty({
                            type: 'success',
                            text: data.message,
                            timeout: 2000,
                        }).show();
                    }
                }
            })
        }

        $('#addRecipeToFavorites').on('click', function(e) {
            e.preventDefault();
            var $this = $(this),
                user_id = $this.attr('data-uid'),
                recipe_id = $this.attr('data-rid');
            ajaxCall(user_id, recipe_id);
        });


    </script>
@endsection
