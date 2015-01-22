$(function() {
    $('.media-browser').on('click', '.add  a', function() {
        $(this).siblings('.form').toggle();

        return false;
    });

    $('.media-browser .tree').each(function() {
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

                loadFiles(dirId)
                $('#clastic_media_file_directory').val(dirId);
            });
    });

    $('#clastic_media_file_directory').val(1);

    var filesDiv = $('.media-browser .files');
    var loadFiles = function(directoryId) {
        filesDiv.html('Loading ...');
        $.ajax($('.media-browser .files').data('media').source, {
            "data": {"id": directoryId},
            "success": function(data) {
                var itemCount = data.length;
                if (itemCount === 0) {
                    filesDiv.html('No files.');
                    return;
                }
                var ul = $('<ul/>');
                for (var i = 0; i < itemCount; i++) {
                    ul.append($('<li>' + data[i].text + '</li>'));
                }
                filesDiv.html(ul);
            }
        });
    };
});