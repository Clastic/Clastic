$(function() {
    if (!$('#clastic_node_tabs_general_title').val()) {
        $('#clastic_node_tabs_alias_alias').slugify('#clastic_node_tabs_general_title');
    }
});