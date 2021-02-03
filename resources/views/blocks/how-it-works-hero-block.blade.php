<section class="how-it-works-hero">
    <div class="container">
        <h1>{{ $page->name }}</h1>
    </div>

    <div class="how-it-works-hero__card">
        <div class="row">
            <div class="how-it-works-hero__progress">
                <ul>
                    @if($page->extras['title_tab1'])
                        <li class="active">
                            <a href="#tab1">{!! $page->extras['title_tab1'] !!}</a>
                        </li>
                    @endif

                    @if($page->extras['title_tab1'])
                        <li>
                            <a href="#tab2">{!! $page->extras['title_tab2'] !!}</a>
                        </li>
                    @endif

                    @if($page->extras['title_tab3'])
                        <li>
                            <a href="#tab3">{!! $page->extras['title_tab3'] !!}</a>
                        </li>
                    @endif

                    @if($page->extras['title_tab4'])
                        <li>
                            <a href="#tab4">{!! $page->extras['title_tab4'] !!}</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="how-it-works-hero__explaniation offset-md-1 col-md-6">
                <div id="tab1" class="how-it-works-hero__tab active">
                    <h2>{!! $page->extras['title_tab1'] !!}</h2>
                    <p>{!! $page->extras['content_tab1'] !!}</p>
                </div>
                <div id="tab2" class="how-it-works-hero__tab">
                    <h2>{!! $page->extras['title_tab2'] !!}</h2>
                    <p>{!! $page->extras['content_tab2'] !!}</p>
                </div>
                <div id="tab3" class="how-it-works-hero__tab">
                    <h2>{!! $page->extras['title_tab3'] !!}</h2>
                    <p>{!! $page->extras['content_tab3'] !!}</p>
                </div>
                <div id="tab4" class="how-it-works-hero__tab">
                    <h2>{!! $page->extras['title_tab4'] !!}</h2>
                    <p>{!! $page->extras['content_tab4'] !!}</p>
                </div>

                <a href="#" class="button button__previous button--secondary">Vorige</a>
                <a href="#" class="button button__next button--secondary">Volgende</a>
            </div>
        </div>
    </div>
</section>
