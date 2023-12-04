import hasLoggedIn from "../../middleware/hasLoggedIn";

const masterUser = [
    {
        path: '',
        name: 'master-user-index',
        component:  () => import('../../pages/admin/masterUser/Index'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'wali-kelas',
        name: 'master-user-wali-kelas',
        component:  () => import('../../pages/admin/masterUser/WaliKelas'),
        meta: {
            middleware: hasLoggedIn
        }
    }
];

export default masterUser
