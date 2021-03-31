
import ProductIndex from './views/ProductIndex'
import ProductEdit from './views/ProductEdit'

export default [
    {
        path: '/Product',
        name: 'product',
        component: ProductIndex
    },
    {
        path: '/Product-create',
        name: 'product-create',
        component: ProductEdit
    },
    {
        path: '/Product-edit/:propId',
        name: 'product-edit',
        component: ProductEdit,
        props: true
    },
];
