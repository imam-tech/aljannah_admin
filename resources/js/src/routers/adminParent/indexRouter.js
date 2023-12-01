const indexRouter = [
    {
        path: '',
        name: 'admin-parent-index',
        component:  () => import('../../pages/adminParent/Index')
    },
    {
        path: 'profile',
        name: 'admin-parent-profile',
        component:  () => import('../../pages/adminParent/Profile')
    },
    {
        path: 'payment',
        name: 'admin-parent-payment',
        component:  () => import('../../pages/adminParent/Payment')
    }
];

export default indexRouter
