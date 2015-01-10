$(function() {
    $('div[data-tree] ul').each(function() {
        var props = $(this).parent().data("tree");
        var input = $(this).parent().find("input");

        $(this)
            .jstree({
                "core" : {
                    "multiple" : false,
                    "data" : {
                        "url" : props.source,
                        "data" : function (node) {
                            return {
                                "id" : node.id,
                                "currentId": props.currentId
                            };
                        }
                    },
                    "check_callback" : function(operation, node, node_parent, node_position, more) {

                        if (operation == 'move_node') {
                            // Wait for the parent to be opened before allowing to drop.
                            if (!node_parent.state.loaded) {
                                return false;
                            }
                        }

                        return true;
                    }
                },
                "dnd": {
                    "copy": false,
                    "is_draggable": function(data) {
                        return (data[0].id == props.currentId || data[0].id == 'current');
                    },
                    "open_onmove": true,
                    "inside_pos": 'last',
                    "open_timeout": 100,
                    "drag_selection": false,
                    "always_copy": false
                },
                "plugins" : [ 'dnd', 'wholerow' ]
            })
            .on('move_node.jstree', function (e, data) {
                var jstree = $(this).jstree(true);

                if (!jstree.get_node(data.node.parent).state.opened) {
                    jstree.open_node(data.node.parent);
                }

                console.log(data);
                input.val(JSON.stringify({
                    "parent": data.parent,
                    "position": data.position
                }));
            })
        ;
    });
});