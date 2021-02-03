<section class="prices">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 d-flex">
                <div class="prices__card align-self-start">
                    <h2>{{ $page->package_block_1_title ?? 'Pakket 1' }}</h2>
                    @php $content = json_decode($page->package_block_1_content); @endphp

                    @if($content)
                        <ul>
                            @foreach($content as $item)
                                @if(!empty($item->name))
                                    <li>{{ $item->name }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                    <span class="prices__price">€ {{ $page->package_block_1_price ?? '...' }},-</span>
                    <span class="prices__per-employee">per medewerker<br/> per maand</span>

                    <p>{{ $page->package_block_1_text ?? '' }}</p>

                    <a href="@php echo e(url('/aanmelden')) @endphp" class="button button--primary text-center">Meld uw team aan</a>
                </div>
            </div>
            <div class="col-lg-4 d-flex my-5 my-lg-0">
                <div class="prices__card align-self-start">
                    <label class="prices__label">
                        <span>Meest gekozen</span>
                    </label>
                    <h2>{{ $page->package_block_2_title ?? 'Pakket 2' }}</h2>
                    @php $content = json_decode($page->package_block_2_content); @endphp

                    @if($content)
                        <ul>
                            @foreach($content as $item)
                                @if(!empty($item->name))
                                    <li>{{ $item->name }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                    <span class="prices__price">€ {{ $page->package_block_2_price ?? '...' }},-</span>
                    <span class="prices__per-employee">per medewerker<br/> per maand</span>

                    <p>{{ $page->package_block_2_text ?? '' }}</p>

                    <a href="@php echo e(url('/aanmelden')) @endphp" class="button button--primary text-center">Meld uw team aan</a>
                </div>
            </div>
            <div class="col-lg-4 d-flex">
                <div class="prices__card align-self-start">
                    <h2>{{ $page->package_block_3_title ?? 'Pakket 3' }}</h2>
                    @php $content = json_decode($page->package_block_3_content); @endphp

                    @if($content)
                        <ul>
                            @foreach($content as $item)
                                @if(!empty($item->name))
                                    <li>{{ $item->name }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                    <span class="prices__price">€ {{ $page->package_block_3_price ?? '...' }},-</span>
                    <span class="prices__per-employee">per medewerker<br/> per maand</span>

                    <p>{{ $page->package_block_3_text ?? '' }}</p>
{{--                    Bonus: Elk half jaar een bedrijfsbezoek van 1 vanonze coaches voor persoonlijk leefstijl- en voedingsadvies en coaching.--}}

                    <a href="@php echo e(url('/aanmelden')) @endphp" class="button button--primary text-center">Meld uw team aan</a>
                </div>
            </div>
        </div>
    </div>
</section>
