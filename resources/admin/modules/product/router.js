
import ProductIndex from './views/ProductIndex';
import ProductEdit from './views/ProductEdit';

export default [
    {
        path: '/product',
        name: 'product',
        component: ProductIndex
    },
    {
        path: '/product-create',
        name: 'product-create',
        component: ProductEdit
    },
    {
        path: '/product-edit/:propId',
        name: 'product-edit',
        component: ProductEdit,
        props: true
    },
];
