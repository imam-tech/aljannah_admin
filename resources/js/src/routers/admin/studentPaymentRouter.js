const studentPaymentRouter = [
    {
        path: 'bill',
        name: 'student-payment-bill',
        component:  () => import('../../pages/admin/studentPayment/Bill')
    },
    {
        path: 'balance',
        name: 'student-payment-balance',
        component:  () => import('../../pages/admin/studentPayment/Balance')
    }
];

export default studentPaymentRouter
