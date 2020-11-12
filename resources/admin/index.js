
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

    beforeMount() {
        this.$store.dispatch('setSettings', this.$el.getAttribute('settings'));
    }
}).$mount('#app');
