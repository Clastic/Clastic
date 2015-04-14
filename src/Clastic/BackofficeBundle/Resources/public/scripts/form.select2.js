(function() {
    $('select.select2').select2();

    $('form').on('clastic.form.change', function() {
        $(this).find('select.select2:visible').select2();
    });
}());