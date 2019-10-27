require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.$successMsg = function (msg) {
    this.$bvToast.toast(msg, {
        title: 'Success',
        variant: 'success',
        solid: true,
    });
};

Vue.prototype.$errorMsg = function (msg) {
    this.$bvToast.toast(msg, {
        title: 'Error',
        variant: 'danger',
        solid: true,
    });
};

import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);


const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const app = new Vue({
    el: '#app',
});

$('.ajax-link').on('click', async function (e) {
    e.preventDefault();

    if (!confirm('Are you sure?')) {
        return false;
    }

    const $el = $(e.target).hasClass('ajax-link') ? $(e.target) : $(e.target).parent('.ajax-link');
    const method = $el.data('method');

    if (typeof method === 'undefined') {
        Vue.$errorMsg('ajax-link method not defined');
        return false;
    }

    if (method === 'delete' && ! confirm('Are you sure?')) {
        return false;
    }

    const response = await $.ajax($el.attr('href'), { method: method });

    if (response.status === 'error') {
        Vue.$errorMsg(response.message);
    }

    if (response.status !== 'success') {
        console.error('Error deleting data');
        console.log(response);
    }

    if (typeof response.redirect !== 'undefined') {
        window.location = response.redirect;
    }

    if ($el.data('delete')) {
        $('#' + $el.data('delete')).remove();
    }
});
