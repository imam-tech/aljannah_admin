const masterPaymentRouter = [
    {
        path: 'type',
        name: 'master-payment-type',
        component:  () => import('../../pages/admin/masterPayment/Type')
    },
    {
        path: 'pos',
        name: 'master-payment-pos',
        component:  () => import('../../pages/admin/masterPayment/Pos')
    },
    {
        path: 'tariff',
        name: 'master-payment-tariff',
        component:  () => import('../../pages/admin/masterPayment/Tariff')
    },
    {
        path: 'discount',
        name: 'master-payment-discount',
        component:  () => import('../../pages/admin/masterPayment/Discount')
    },
    {
        path: 'account-bank',
        name: 'master-payment-account-bank',
        component:  () => import('../../pages/admin/masterPayment/AccountBank')
    }
];

export default masterPaymentRouter
