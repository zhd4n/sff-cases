require('./bootstrap');



$('.ajax-delete').on('click', function (e) {
    e.preventDefault();

    if (!confirm('Are you sure?')) {
        return false;
    }

    let $el = $(e.target);

    if (! $el.hasClass('ajax-delete')) {
        $el = $el.parent('.ajax-delete');
    }


    $.ajax($el.attr('href'), {
        method: 'DELETE',
    }).done(function (response) {
        if (typeof response.redirect !== 'undefined') {
            window.location = response.redirect;
        }

        if (response.status === 'error') {
            alert(response.message);
        }
    });
});
