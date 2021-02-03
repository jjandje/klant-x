<section class="benefits">
    <div class="container">
        <h3 class="text-center">Minder verzuim  —  Fittere werknemers</h3>
        <div class="row">
            <div class="benefits__left-block col-lg-6">
                <h4>{{ $page->why_title }}</h4>
                @php
                    $extras = $page->extras;
                    $why = json_decode($extras['why']);
                @endphp

                @if($why)
                    <ul>
                        @foreach($why as $item)
                            @if(!empty($item->name))
                                <li>{{ $item->name }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif
                <img src="{{ asset(mix('images/content/Advocado.png')) }}" alt="Advocado"/>
            </div>

            <div class="benefits__right-block col-lg-6">
                <h4>{{ $page->afford_title }}</h4>
                @php
                    $extras = $page->extras;
                    $afford = json_decode($extras['afford']);
                @endphp

                @if($afford)
                    <ul>
                        @foreach($afford as $item)
                            @if(!empty($item->name))
                                <li>{{ $item->name }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif
                <a href="{{ route('application.index') }}" class="button button--secondary">Meld uw team aan</a>
            </div>
        </div>
    </div>
</section>
