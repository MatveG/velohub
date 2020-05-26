
import Vue from 'vue'
import Router from 'vue-router'
import categories from "./modules/categories/router";
import products from "./modules/products/router";

Vue.use(Router);

export default new Router({
    routes: [
        ...categories,
        ...products,
    ],
})

