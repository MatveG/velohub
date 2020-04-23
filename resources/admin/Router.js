
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

import Products from './views/vue/Products'
import ProductEdit from './views/vue/ProductEdit'
import Categories from "./views/vue/Categories"
import CategoryEdit from "./views/vue/CategoryEdit"

export default new Router({
    routes: [
        {
            path: '/products',
            name: 'products',
            component: Products
        },
        {
            path: '/product-edit/:id',
            name: 'product.edit',
            component: ProductEdit,
            props: true
        },
        {
            path: '/categories',
            name: 'categories',
            component: Categories
        },
        {
            path: '/category-create',
            name: 'category.create',
            component: CategoryEdit,
        },
        {
            path: '/category-edit/:id',
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
