(function() {
    'use strict';

    $(function() {
        $('.input-group').on('click', 'span.input-group-addon', function() {
            $(this).parent().find('input').focus();
        })
    });
}());
