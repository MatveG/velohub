
import Index from '../views/Index'
import Edit from '../views/Edit'

export default [
    {
        path: '/products',
        name: 'products',
        component: Index
    },
    {
        path: '/product-edit/:id',
        name: 'product.edit',
        component: Edit,
        props: true
    },
];
