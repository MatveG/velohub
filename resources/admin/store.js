
import Vue from 'vue';
import Vuex from 'vuex';
import category from "@/modules/category/store";
import product from "@/modules/product/store";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        category,
        product
    }
});
