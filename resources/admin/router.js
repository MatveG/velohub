
import Vue from 'vue'
import Router from 'vue-router'
import products from "./modules/products/router";
import categories from "./modules/categories/router";

Vue.use(Router);

export default new Router({
    routes: [
        ...products,
        ...categories
    ],
})

