import hasLoggedIn from "../../middleware/hasLoggedIn";

const adminRouter = [
    {
        path: 'user',
        name: 'administrator-user',
        component:  () => import('../../pages/admin/admin/User'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'jabatan',
        name: 'administrator-role',
        component:  () => import('../../pages/admin/admin/Jabatan'),
        meta: {
            middleware: hasLoggedIn
        }
    }
];

export default adminRouter
