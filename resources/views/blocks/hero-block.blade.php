<section class="hero">
    <div class="hero--top">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-5">
                    {!! '<h1>' . $page->title . '</h1>' ?? '' !!}
                    {!! $page->content ?? '' !!}
                </div>
                @if(!empty($page->image))
                    <div class="col-md-6 col-lg-7">
                        <div class="img-wrap">
                            <img src="{{ $page->image }}" alt="{{ $page->title ?? 'Hero image' }}"/>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="hero--bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="#usps" class="arrow-down linkto"></a>
                </div>
            </div>
        </div>
    </div>
</section>
