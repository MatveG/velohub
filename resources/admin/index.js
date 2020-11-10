
import "./sass/app.scss"

import Vue from 'vue'
import Vuelidate from 'vuelidate'
import Buefy from 'buefy'
import store from './store'
import router from './router'
import './mixins/'

Vue.use(Buefy);
Vue.use(Vuelidate);

const app = new Vue({
    router,
    store,

    mounted() {
        this.$store.dispatch('fetchSettings');
    }
}).$mount('#app');
