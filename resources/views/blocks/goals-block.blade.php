@php
$goals = [];
if(isset($goals)) {
    $goal1 = [
        'page'  => $page->extras['goal_1'],
        'title' => $page->extras['goal_1_title'],
        'img'   => $page->extras['goal_1_img'],
    ];
    $goals[] = $goal1;

    $goal2 = [
        'page'  => $page->extras['goal_2'],
        'title' => $page->extras['goal_2_title'],
        'img'   => $page->extras['goal_2_img'],
    ];
    $goals[] = $goal2;

    $goal3 = [
        'page'  => $page->extras['goal_3'],
        'title' => $page->extras['goal_3_title'],
        'img'   => $page->extras['goal_3_img'],
    ];
    $goals[] = $goal3;

    $goal4 = [
        'page'  => $page->extras['goal_4'],
        'title' => $page->extras['goal_4_title'],
        'img'   => $page->extras['goal_4_img'],
    ];
    $goals[] = $goal4;
}
@endphp
<section class="goals">
    <div class="container">
        <div class="row">

            @foreach($goals as $goal)
                @php

                    if(empty($goal['page']) || empty($goal['img'])) continue;

                    $page = \App\Models\Page::find((int)$goal['page']);

                    if(empty($page->title)) continue;

                    $title = $goal['title'];
                    if(empty($title)) {
                        $title = $page->title;
                    }
                    $url = route('page.show', ['page' => $page->slug]);
                @endphp
                <div class="col-sm-6 col-lg-3">
                    <div class="goals__item">
                        <a href="{{ $url }}">
                            <img src="{{ $goal['img'] }}" alt="{{ $title }}">
                            <div class="goals__title">
                                <h3>{{ $title }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach

            <!--<div class="col-sm-6 col-lg-3">
                <div class="goals__item">
                    <img src="{{ asset(mix('images/content/goal-1.png')) }}">
                    <div class="goals__title">
                        <h3>Afvallen</h3>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="goals__item">
                    <img src="{{ asset(mix('images/content/goal-2.png')) }}">
                    <div class="goals__title">
                        <h3>Meer bewegen</h3>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="goals__item">
                    <img src="{{ asset(mix('images/content/goal-3.png')) }}">
                    <div class="goals__title">
                        <h3>Meer energie</h3>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="goals__item">
                    <img src="{{ asset(mix('images/content/goal-4.png')) }}">
                    <div class="goals__title">
                        <h3>Minder stress</h3>
                    </div>
                </div>
            </div> -->
        </div>


        <div class="row">
            <div class="col-12 offset-md-1 goals__text-wrap">
                <h3>{{ $page['content_text_block_goals_title'] }}</h3>
                <div class="goals__text col-lg-6">
                    {!! $page['content_text_block_goals'] !!}
                </div>
                @if($page['content_text_block_goals'])<a href="/hoe-werkt-het" class="button button--secondary">Hoe werkt het</a>@endif
            </div>
        </div>
    </div>
</section>
