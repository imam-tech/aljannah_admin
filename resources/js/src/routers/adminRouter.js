import MenuLayout from "../layouts/MenuLayout";
import adminOnlineAdmissionRouter from './admin/onlineAdmissionRouter'
import masterPaymentRouter from './admin/masterPaymentRouter'
import studentPaymentRouter from './admin/studentPaymentRouter'
import masterUserRouter from './admin/masterUserRouter'
import masterRouter from './admin/masterRouter'
import adminRouter from './admin/adminRouter'

const auth = [
    {
        path: 'online-admission',
        component: MenuLayout,
        children: adminOnlineAdmissionRouter
    },
    {
        path: 'master-payment',
        component: MenuLayout,
        children: masterPaymentRouter
    },
    {
        path: 'student-payment',
        component: MenuLayout,
        children: studentPaymentRouter
    },
    {
        path: 'master-user',
        component: MenuLayout,
        children: masterUserRouter
    },
    {
        path: 'master',
        component: MenuLayout,
        children: masterRouter
    },
    {
        path: '',
        component: MenuLayout,
        children: adminRouter
    },
];

export default auth
