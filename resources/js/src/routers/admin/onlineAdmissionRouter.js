import hasLoggedIn from "../../middleware/hasLoggedIn";

const onlineAdmissionsRouter = [
    {
        path: '',
        name: 'online-admissions-index',
        component:  () => import('../../pages/admin/onlineAdmission/Index'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'received',
        name: 'online-admissions-received',
        component:  () => import('../../pages/admin/onlineAdmission/Received'),
        meta: {
            middleware: hasLoggedIn
        }
    }
];

export default onlineAdmissionsRouter
