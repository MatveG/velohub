
import "./sass/app.scss"

import Vue from 'vue'
import Vuelidate from 'vuelidate'
import Buefy from 'buefy'
import store from './store'
import router from './router'
import './mixins/'

Vue.use(Buefy);
Vue.use(Vuelidate);

window.settings = {
    perPage: 15
};

const app = new Vue({
    router,
    store
}).$mount('#app');



// window.axios = Axios;
// window.axios.defaults.headers.common = {
//     'X-Requested-With': 'XMLHttpRequest',
//     'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
// };
