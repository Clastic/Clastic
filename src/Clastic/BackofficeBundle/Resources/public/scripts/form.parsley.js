(function() {
    'use strict';

    $(function() {
        var $form = $('form');
        if (!$form.length) {
            return;
        }

        $form.parsley({
            errorClass: 'has-error',
            classHandler: function(ParsleyField) {
                return ParsleyField.$element.parents('.form-group');
            },
            errorsContainer: function(ParsleyField) {
                return ParsleyField.$element.parents('.form-group');
            },
            errorsWrapper: '<span class="bg-danger help-block">',
            errorTemplate: '<div></div>'
        });

        $.listen('parsley:form:validated', function() {
            var $tabPanel = $form.find('.tabpanel');
            if ($tabPanel.length) {
                var $firstError = $tabPanel.find('.has-error').first();
                if ($firstError.length) {
                    var $tab = $form.find('[role="tablist"] li').eq($firstError.closest('.tab-pane').index());
                    $tab.find('a').tab('show');
                }
            }
        });
    });
}());

