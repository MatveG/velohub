
import "./../sass/app.scss";

import Vue from 'vue'
import Buefy from 'buefy'
import axiosApi from 'axios';

Vue.use(Buefy);
window.axios = axiosApi;
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
};


import modal from '../components/modal.vue'
import list from "../components/list.vue"

Vue.component('list', list);
Vue.component('modal', modal);

const app = new Vue({
    el: '#app',
});
