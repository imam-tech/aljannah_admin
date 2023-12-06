import hasLoggedIn from "../../middleware/hasLoggedIn";

const dashboardRouter = [
    {
        path: 'akademik',
        name: 'dashboard-akademik',
        component:  () => import('../../pages/admin/dashboard/Akademik'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'ppdb',
        name: 'dashboard-ppdb',
        component:  () => import('../../pages/admin/dashboard/Ppdb'),
        meta: {
            middleware: hasLoggedIn
        }
    }
];

export default dashboardRouter
