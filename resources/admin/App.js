
import "./sass/app.scss";

import Vue from 'vue';
import Buefy from 'buefy';
import router from './Router';

Vue.use(Buefy);

const app = new Vue({
    router
}).$mount('#app');







// window.axios = Axios;
// window.axios.defaults.headers.common = {
//     'X-Requested-With': 'XMLHttpRequest',
//     'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
// };
