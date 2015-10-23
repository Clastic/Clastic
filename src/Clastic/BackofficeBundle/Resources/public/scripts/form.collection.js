(function(){
    $(function() {
        $('ul.collection').each(function() {
            var $addTagLink = $('<a href="#" class="btn btn-primary add_link">Add</a>');
            var $newLinkLi = $('<li class="list-group-item"></li>').append($addTagLink);

            var $collectionHolder = $(this);
            $collectionHolder.find('li').each(function() {
                addCollectionDeleteLink($(this));
            });
            $collectionHolder.append($newLinkLi);
            $collectionHolder.data('index', $collectionHolder.find(':input').length);

            $addTagLink.on('click', function(e) {
                e.preventDefault();
                addCollectionNewForm($collectionHolder, $newLinkLi);
                $addTagLink.closest('form').trigger('clastic.form.change');
            });
        });
    });

    function addCollectionNewForm($collectionHolder, $newLinkLi) {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        $collectionHolder.data('index', index + 1);
        var $newFormLi = $('<li class="list-group-item"></li>').append(prototype.replace(/__name__/g, index));

        $newLinkLi.before($newFormLi);
        addCollectionDeleteLink($newFormLi);
    }
    function addCollectionDeleteLink($tagFormLi) {
        var $removeFormA = $('<a href="#" class="remove"><i class="fa fa-minus-circle"></i></a>');

        $tagFormLi.append($removeFormA);

        $removeFormA.on('click', function(e) {
            e.preventDefault();
            $tagFormLi.remove();
        });
    }
})();