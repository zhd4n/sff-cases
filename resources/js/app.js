require('./bootstrap');

window.Vue = require('vue');

import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);
// Vue.component(BRow);
// Vue.component(BCol);
// Vue.component(BForm);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const app = new Vue({
    el: '#app',
});


$('.ajax-delete').on('click', function (e) {
    e.preventDefault();

    if (!confirm('Are you sure?')) {
        return false;
    }

    let $el = $(e.target);

    if (! $el.hasClass('ajax-delete')) {
        $el = $el.parent('.ajax-delete');
    }

    $el.addClass('loading');

    $.ajax($el.attr('href'), {
        method: 'DELETE',
    }).done(function (response) {
        if (typeof response.redirect !== 'undefined') {
            window.location = response.redirect;
        }

        if (response.status === 'error') {
            alert(response.message);
        }

        if ($el.data('delete')) {
            $('#' + $el.data('delete')).remove();
        }

        $('body').toast({
                class: 'success',
                message: 'Photo deleted'
            })
        ;
    });
});

function readURL(input) {
    $preview = $('#preview-images');

    for(var i =0; i< input.files.length; i++){
        if (input.files[i]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var card = $('<div class="ui card"><div class="image"><img></div></div>');
                card.find('img').attr('src', e.target.result);
                card.appendTo('#preview-images');
            };
            reader.readAsDataURL(input.files[i]);
        }
    }
}

$("#upload-images").change(function(){
    readURL(this);
});
