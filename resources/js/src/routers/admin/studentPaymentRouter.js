import hasLoggedIn from "../../middleware/hasLoggedIn";

const studentPaymentRouter = [
    {
        path: 'bill',
        name: 'student-payment-bill',
        component:  () => import('../../pages/admin/studentPayment/Bill'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'balance',
        name: 'student-payment-balance',
        component:  () => import('../../pages/admin/studentPayment/Balance'),
        meta: {
            middleware: hasLoggedIn
        }
    }
];

export default studentPaymentRouter
