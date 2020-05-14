
import "./sass/app.scss"

import Vue from 'vue'
import Buefy from 'buefy'
import Vuelidate from 'vuelidate'
import router from './Router'

// global mixins
import toast from './mixins/toast.global'
import confirm from './mixins/confirm.global'


Vue.use(Buefy);
Vue.use(Vuelidate);

const app = new Vue({
    router
}).$mount('#app');




// window.axios = Axios;
// window.axios.defaults.headers.common = {
//     'X-Requested-With': 'XMLHttpRequest',
//     'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
// };
