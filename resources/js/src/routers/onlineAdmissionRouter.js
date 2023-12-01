const onlineAdmissionRouter = [
    {
        path: ':type',
        name: 'online-admission-form',
        component:  () => import('../pages/onlineAdmission/Index')
    }
];

export default onlineAdmissionRouter
