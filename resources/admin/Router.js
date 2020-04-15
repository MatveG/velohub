
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Products from './views/Products.vue';
import ProductEdit from './views/ProductEdit.vue';
import Category from "./views/Category";
import CategoryEdit from "./views/CategoryEdit";

export default new Router({
    routes: [
        {
            path: '/products',
            name: 'products',
            component: Products
        },
        {
            path: '/product/:id',
            name: 'product.edit',
            component: ProductEdit,
            props: true
        },
        {
            path: '/category',
            name: 'category',
            component: Category
        },
        {
            path: '/category/:id',
            name: 'category.edit',
            component: CategoryEdit,
            props: true
        },
    ],

    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    }
});
