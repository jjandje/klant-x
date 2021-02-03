<section class="text-image-block">
    <div class="container">
        @if(!empty($page->image))
            <img class="text-image-block__image" src="{{ $page->image }}" alt="Company image"/>
        @else
            <img class="text-image-block__image" src="{{ asset(mix('images/content/company-image.png')) }}" alt="Company image"/>
        @endif
    </div>

    <div class="text-image-block__card">
        <div class="text-image-block__text-block">
            <h3>{{ $page->content_text_block_title }}</h3>
            {!! $page->content_text_block !!}
            <a href="@php echo e(url('/aanmelden')) @endphp" class="button button--secondary">Meld uw team aan</a>
        </div>
    </div>
</section>
