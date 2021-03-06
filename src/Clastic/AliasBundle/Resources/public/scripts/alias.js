$(function() {
    var aliasSelector = '#clastic_node_tabs_alias_alias';
    var titleSelector = '#clastic_node_tabs_general_title';
    if (!$(titleSelector).val()) {
        var pattern = $(aliasSelector).data('alias-pattern');
        if (pattern) {
            $(aliasSelector).slugify(titleSelector, {
                'postSlug': function(sourceString) {
                    return pattern.replace('{title}', sourceString);
                }
            });
        }
    }
});