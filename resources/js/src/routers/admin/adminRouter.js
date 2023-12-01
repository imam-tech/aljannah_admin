const adminRouter = [
    {
        path: 'user',
        name: 'administrator-user',
        component:  () => import('../../pages/admin/admin/User')
    },
    {
        path: 'role',
        name: 'administrator-role',
        component:  () => import('../../pages/admin/admin/Role')
    }
];

export default adminRouter
