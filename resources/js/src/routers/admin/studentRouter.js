import hasLoggedIn from "../../middleware/hasLoggedIn";

const studentRouter = [
    {
        path: '',
        name: 'student-index',
        component:  () => import('../../pages/admin/student/Index'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: ':id/detail',
        name: 'student-detail',
        component:  () => import('../../pages/admin/student/Detail'),
        meta: {
            middleware: hasLoggedIn
        }
    }
];

export default studentRouter
