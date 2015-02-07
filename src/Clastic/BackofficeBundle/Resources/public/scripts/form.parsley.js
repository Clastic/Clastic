(function() {
    'use strict';

    $(function() {
        var $form = $('form');
        if (!$form.length) {
            return;
        }

        $form.parsley();
        $.listen('parsley:form:validated', function() {
            var $tabpanel = $form.find('.tabpanel');
            if ($tabpanel.length) {
                var $firstError = $tabpanel.find('.parsley-error').first();
                if ($firstError.length) {
                    var $tab = $form.find('[role="tablist"] li').eq($firstError.closest('.tab-pane').index());
                    $tab.find('a').tab('show');
                }
            }
        });
    });
}());

