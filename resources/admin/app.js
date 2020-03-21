
import "./sass/app.scss";

import Vue from 'vue';
import Buefy from 'buefy';
import AxiosInstance from 'axios';

Vue.use(Buefy);

import router from './router';
import { ToastProgrammatic as Toast } from 'buefy'

window.error = (message) => {
    Toast.open({
        message: message,
        type: 'is-danger',
        queue: false
    });
};

window.axios = AxiosInstance;
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
};

const app = new Vue({
    router
}).$mount('#app');



// import Modal from './components/modal.vue'
// import List from "./components/list.vue"
//
// Vue.component('modal', Modal);
// Vue.component('list', List);

// const routes = [
//     { path: '/modal', component: Modal },
//     { path: '/list', component: List }
// ]
