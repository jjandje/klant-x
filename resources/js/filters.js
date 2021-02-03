const $overview = $('div.overview'),
    post_class = $overview.attr('data-class');

var filter_string = '',
    filters = {},
    $grid = $overview.isotope({
        itemSelector: '.'+post_class,
    });


if(window.location.hash) {
    filter_string = location.hash.replace('#', '');

    // set checked state to checkbox
    $('.filter-checkbox[data-filter_value="'+filter_string.replace('.', '')+'"]').trigger('click');

    $grid.isotope({filter: filter_string});
}

function removeHash() {
    var scrollV, scrollH, loc = window.location;
    if ('pushState' in history)
        history.pushState('', document.title, loc.pathname + loc.search);
    else {
        // Prevent scrolling by storing the page's current scroll offset
        scrollV = document.body.scrollTop;
        scrollH = document.body.scrollLeft;

        loc.hash = '';

        // Restore the scroll offset, should be flicker free
        document.body.scrollTop = scrollV;
        document.body.scrollLeft = scrollH;
    }
}

function filter() {
    filter_string = '';

    $('.filter-checkbox:checked').each(function(i, e) {
        var filter_value = $(e).attr('data-filter_value');
        filter_string += '.'+filter_value;
    });

    if(filter_string.length > 1) {
        $grid.isotope({filter: filter_string});

        location.hash = filter_string;
    } else {
        $grid.isotope({filter: '*'});
        removeHash();
    }

}

$('.filter-checkbox').on('change', function() {
    filter();
});

$('a#resetFilters').on('click', function(e) {
    e.preventDefault();

    var filter_type = $(this).attr('data-type');

    // Remove checked state from corresponding checkboxes
    $('.filter-checkbox[data-type="'+filter_type+'"]').attr('checked', false).prop('checked', false);

    filter();
});

