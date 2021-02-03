<section class="usps">
    <div class="container">
        <div class="row">
            @if(isset($page->extras['title_usp1']))
                <div class="col-md-4 col-12 usps__item">
                    <img src="{{ asset(mix('images/icons/mealplan-icon.svg')) }}" alt="HealthyBy Mealplan icon">
                    <span>{!! $page->extras['title_usp1'] !!}</span>
                </div>
            @endif

            @if(isset($page->extras['title_usp2']))
                <div class="col-md-4 col-12 usps__item">
                    <img src="{{ asset(mix('images/icons/dashboard-icon.svg')) }}" alt="HealthyBy Dashbord icon">
                    <span>{!! $page->extras['title_usp2'] !!}</span>
                </div>
            @endif

            @if(isset($page->extras['title_usp3']))
                <div class="col-md-4 col-12 usps__item">
                    <img src="{{ asset(mix('images/icons/coaching-icon.svg')) }}" alt="HealthyBy Coaching icon">
                    <span>{!! $page->extras['title_usp3'] !!}</span>
                </div>
            @endif
        </div>
    </div>
</section>
