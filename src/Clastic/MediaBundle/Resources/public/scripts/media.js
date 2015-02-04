$(function() {
    var $browser = $('.media-browser');
    if (!$browser.length) {
        return;
    }

    $browser.on('click', '.add  a', function() {
        $(this).siblings('.form').toggle();

        return false;
    });

    $browser.find('.tree').each(function() {
        var props = $(this).data("media");

        $(this)
            .jstree({
                "core": {
                    "multiple": false,
                    "data": {
                        "url": props.source,
                        "data": function (node) {
                            return {
                                "id": node.id,
                                "currentId": props.currentId
                            };
                        }
                    }
                }
            })
            .on('changed.jstree', function (e, data) {
                var dirId = data.instance.get_node(data.selected[0]).id;

                loadFiles(dirId);
                $('#clastic_media_file_directory').val(dirId);
            });
    });

    $('#clastic_media_file_directory').val(1);

    var $filesDiv = $('.media-browser .files');
    var template = Handlebars.compile($filesDiv.data('prototype'));
    var loadFiles = function(directoryId) {
        $filesDiv.html('Loading ...');
        $.ajax($browser.find('.files').data('media').source, {
            "data": {"id": directoryId},
            "success": function(data) {
                var itemCount = data.length;
                if (itemCount === 0) {
                    $filesDiv.html('No files.');
                    return;
                }
                var ul = $('<ul/>');
                for (var i = 0; i < itemCount; i++) {
                    ul.append(template({
                        "name": data[i].text,
                        "path": data[i].path
                    }));
                }
                $filesDiv.html(ul);
            }
        });
    };
    $filesDiv.on('click', 'a[data-link]', function() {
        alert($(this).data('link'));

        return false;
    });
});