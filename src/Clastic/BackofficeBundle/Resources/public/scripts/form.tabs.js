(function() {
    $('[role="tablist"]').each(function(i, el) {
        $(el).siblings('div.tab-content').css('min-height', $(el).height() + 1);
    });
}());
