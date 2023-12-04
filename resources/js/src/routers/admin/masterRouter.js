import hasLoggedIn from "../../middleware/hasLoggedIn";

const masterRouter = [
    {
        path: 'school-year',
        name: 'master-school-year',
        component:  () => import('../../pages/admin/master/SchoolYear'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'grade',
        name: 'master-grade',
        component:  () => import('../../pages/admin/master/Grade'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'level',
        name: 'master-level',
        component:  () => import('../../pages/admin/master/Level'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'kelas',
        name: 'master-kelas',
        component:  () => import('../../pages/admin/master/Kelas'),
        meta: {
            middleware: hasLoggedIn
        }
    }
];

export default masterRouter
