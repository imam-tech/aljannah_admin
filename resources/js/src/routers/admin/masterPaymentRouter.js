import hasLoggedIn from "../../middleware/hasLoggedIn";

const masterPaymentRouter = [
    {
        path: 'type',
        name: 'master-payment-type',
        component:  () => import('../../pages/admin/masterPayment/Type'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'pos',
        name: 'master-payment-pos',
        component:  () => import('../../pages/admin/masterPayment/Pos'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'tariff',
        name: 'master-payment-tariff',
        component:  () => import('../../pages/admin/masterPayment/Tariff'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'discount',
        name: 'master-payment-discount',
        component:  () => import('../../pages/admin/masterPayment/Discount'),
        meta: {
            middleware: hasLoggedIn
        }
    },
    {
        path: 'account-bank',
        name: 'master-payment-account-bank',
        component:  () => import('../../pages/admin/masterPayment/AccountBank'),
        meta: {
            middleware: hasLoggedIn
        }
    }
];

export default masterPaymentRouter
