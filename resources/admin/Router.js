
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

import ProductIndex from './views/ProductIndex'
import ProductEdit from './views/ProductEdit'
import CategoryIndex from "./views/CategoryIndex"
import CategoryEdit from "./views/CategoryEdit"

export default new Router({
    routes: [
        {
            path: '/product',
            name: 'product.index',
            component: ProductIndex
        },
        {
            path: '/product-edit/:id',
            name: 'product.edit',
            component: ProductEdit,
            props: true
        },
        {
            path: '/category',
            name: 'category.index',
            component: CategoryIndex
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
