<section class="recipes">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Minder verzuim — Fittere werknemers</h3>
                @if($page->image2)
                    <img class="recipes__intro-image" src="{{ $page->image2 }}" alt="Advocado" />
                @else
                    <img class="recipes__intro-image" src="{{ asset(mix('images/content/team.png')) }}" alt="Advocado" />
                @endif
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="offset-xl-6 col-xl-6 recipes__text">
                <h4>Enkele feiten op een rij:</h4>
                @php
                    $extras = $page->extras;
                    $facts = json_decode($extras['facts']);
                @endphp

                @if($facts)
                    <ul>
                        @foreach($facts as $fact)
                            @if(!empty($fact->name))
                                <li>{{ $fact->name }}</li>
                            @endif
                        @endforeach

    {{--                    <li>@dump($page)</li>--}}
    {{--                    <li>Gezondere werknemers zijn minder vaak en minder lang ziek.</li>--}}
    {{--                    <li>Gezondere werknemers hebben tot 40% minder kans op een burn-out.</li>--}}
    {{--                    <li>Fittere werknemers zijn minder vatbaar voor ziekten, virussen, RSI en rugklachten en herstellen beter.</li>--}}
    {{--                    <li>Gezonde werknemers presteren tot wel 40 procent beter op de werkvloer.</li>--}}
    {{--                    <li>Gezondere werknemers zijn gelukkiger in hun functie.</li>--}}
    {{--                    <li>Fitte werknemers die lekker in hun vel zitten en blij zijn met hun baan, zijn minder snel gestresst.</li>--}}
    {{--                    <li>Gezonde werknemers zijn alerter, actiever en mentaal sterker.</li>--}}
    {{--                    <li>Gezonder werknemers hebben minder kans op een depressie.</li>--}}
    {{--                    <li>Fittere werknemers hebben minder kans op een burn-out en dus minder kans op langdurig verzuim.</li>--}}
                    </ul>
                @endif
                <a href="@php echo e(url('/aanmelden')) @endphp" class="button button--secondary">Meld uw team aan</a>
                <img src="{{ asset(mix('images/content/Advocado.png')) }}" alt="Advocado" />
            </div>
        </div>
    </div>
</section>
