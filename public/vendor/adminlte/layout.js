// To make Pace works on Ajax calls
$(document).ajaxStart(function () {
    Pace.restart();
});

// Ajax calls should always have the CSRF token attached to them, otherwise they won't work
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

if (!String.prototype.startsWith) {
    String.prototype.startsWith = function(searchString, position){
        position = position || 0;
        return this.substr(position, searchString.length) === searchString;
    };
}

// Set active state on menu element
$("ul.sidebar-menu li a").each(function () {
    if ($(this).attr('href').startsWith(current_url) || current_url.startsWith($(this).attr('href'))) {
        $(this).parents('li').addClass('active');
    }
});