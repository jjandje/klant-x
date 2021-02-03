<section class="image-text-block">
    <div class="container">
        <div class="image-text-block__text-block col-lg-7">
            <h3>{{ $page->content_text_title }}</h3>

            {!! $page->content_text_block !!}
        </div>
    </div>

    <img class="image-text-block__image" src="{{ asset(mix('images/content/Fruit.png')) }}" alt="Company image"/>
</section>
