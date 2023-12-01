const masterRouter = [
    {
        path: 'school-year',
        name: 'master-school-year',
        component:  () => import('../../pages/admin/master/SchoolYear')
    },
    {
        path: 'grade',
        name: 'master-grade',
        component:  () => import('../../pages/admin/master/Grade')
    }
];

export default masterRouter
