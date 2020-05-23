
import Index from "@/modules/categories/views/Index"
import Edit from "@/modules/categories/views/Edit"

export default [
    {
        path: '/categories',
        name: 'categories',
        component: Index
    },
    {
        path: '/category-create',
        name: 'category.create',
        component: Edit
    },
    {
        path: '/category-edit/:id',
        name: 'category.edit',
        component: Edit,
        props: true
    },
];
