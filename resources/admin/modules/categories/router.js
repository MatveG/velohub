
import CategoryIndex from "./views/CategoryIndex";
import CategoryEdit from "./views/CategoryEdit";

export default [
    {
        path: '/category',
        name: 'category',
        component: CategoryIndex
    },
    {
        path: '/category-create',
        name: 'category-create',
        component: CategoryEdit
    },
    {
        path: '/category-create-sub/:propParent',
        name: 'category-create-sub',
        component: CategoryEdit,
        props: true
    },
    {
        path: '/category-edit/:propId',
        name: 'category-edit',
        component: CategoryEdit,
        props: true
    },
];
