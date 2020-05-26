
import Vue from 'vue';
import Vuex from 'vuex';
import categories from "@/modules/categories/store";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        categories
    }
});
