import Vue from 'vue'
import Router from 'vue-router'
import category from "./modules/category/router";
import product from "./modules/product/router";

Vue.use(Router);

export default new Router({
    routes: [
        ...category,
        ...product,
    ],
})

