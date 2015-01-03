(function(){
    $('.multi_select > select').multiSelect({
        selectableHeader: "<div class='pool-header'>Avaliable</div>" +
        "<input type='text' class='search-input' autocomplete='off' placeholder='Search'>",
        selectionHeader: "<div class='pool-header'>Selection</div>" +
        "<input type='text' class='search-input' autocomplete='off' placeholder='Search'>",
        selectableFooter: "<div class='pool-footer'><a href='#' class='addall'>add all</a></div>",
        selectionFooter: "<div class='pool-footer'><span class='count'></span><a href='#' class='deleteall pull-right'>delete all</a></div>",
        afterInit: function(ms){
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function(e){
                    if (e.which === 40){
                        that.$selectableUl.focus();
                        return false;
                    }
                    else if (e.which === 13) {
                        return false;
                    }
                });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function(e){
                    if (e.which == 40){
                        that.$selectionUl.focus();
                        return false;
                    }
                    else if (e.which === 13) {
                        return false;
                    }
                });

            that.$selectionUl.next().find('.deleteall')
                .on('click', function() {
                    that.deselect_all();
                    return false;
                });

            that.$selectableUl.next().find('.addall')
                .on('click', function() {
                    that.select_all();
                    return false;
                });

            that.updateCount = function() {
                var $select = that.$element,
                    selection = $select.val(),
                    selectionLength = selection ? selection.length : 0,
                    selectableLength = $select.find('option').length - selectionLength;

                that.$container.find('span.count').html(selectionLength+' items');
            };
            that.updateCount();
        },
        afterSelect: function(){
            this.qs1.cache();
            this.qs2.cache();
            this.updateCount();
        },
        afterDeselect: function(){
            this.qs1.cache();
            this.qs2.cache();
            this.updateCount();
        },
        keepOrder: true,
        dblClick: true
    });

    $(function() {
        $('textarea.wysiwyg').ckeditor();
    });
})();
