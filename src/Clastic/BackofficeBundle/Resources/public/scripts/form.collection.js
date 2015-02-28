(function(){
    var $collectionHolder;

    var $addTagLink = $('<a href="#" class="btn btn-primary add_link">Add</a>');
    var $newLinkLi = $('<li class="list-group-item"></li>').append($addTagLink);

    $(function() {
        $collectionHolder = $('ul.collection');
        $collectionHolder.find('li').each(function() {
            addCollectionDeleteLink($(this));
        });
        $collectionHolder.append($newLinkLi);
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addTagLink.on('click', function(e) {
            e.preventDefault();
            addCollectionNewForm($collectionHolder, $newLinkLi);
        });
    });
    function addCollectionNewForm($collectionHolder, $newLinkLi) {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        $collectionHolder.data('index', index + 1);
        var $data = $('<div class="col-md-11"></div>').append(prototype.replace(/__name__/g, index));
        var $newFormLi = $('<li class="list-group-item row"></li>').append($data);

        $newLinkLi.before($newFormLi);
        addCollectionDeleteLink($newFormLi);
    }
    function addCollectionDeleteLink($tagFormLi) {
        var $linkDiv = $('<div class="col-md-1"></div>');
        var $removeFormA = $('<a href="#" class="remove"><i class="fa fa-minus-circle"></i></a>');

        $linkDiv.append($removeFormA);
        $tagFormLi.append($linkDiv);

        $removeFormA.on('click', function(e) {
            e.preventDefault();
            $tagFormLi.remove();
        });
    }
})();