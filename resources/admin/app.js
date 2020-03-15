
import "./sass/app.scss";

import Vue from 'vue';
import Buefy from 'buefy';
import axiosApi from 'axios';

Vue.use(Buefy);

import router from './router';

const app = new Vue({
    router
}).$mount('#app');


window.axios = axiosApi;
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
};



// import Modal from './components/modal.vue'
// import List from "./components/list.vue"
//
// Vue.component('modal', Modal);
// Vue.component('list', List);

// const routes = [
//     { path: '/modal', component: Modal },
//     { path: '/list', component: List }
// ]
