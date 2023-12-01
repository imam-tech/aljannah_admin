import Vue from 'vue'
import Router from 'vue-router'

import hasLoggedIn from "../middleware/hasLoggedIn";

import ParentLayout from '../layouts/ParentLayout.vue'
import AuthLayout from '../layouts/AuthLayout.vue'
import MenuLayout from '../layouts/MenuLayout.vue'

import authRouter from './authRouter';
import adminRouter from './adminRouter';
import onlineAdmissionRouter from './onlineAdmissionRouter'

import authParentRouter from './adminParent/authParentRouter';
import adminParentRouter from './adminParent/indexRouter';
import AdminLayout from "../layouts/AdminLayout";

Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: '/',
    scrollBehavior() {
        return {
            x: 0,
            y: 0
        }
    },
    routes: [
        {
            path: '/app',
            component: AdminLayout,
            children: [
                {
                    path: '',
                    component:  () => import('../pages/Index'),
                    meta: {
                        middleware: hasLoggedIn,
                        pageTitle: 'Dashboard',
                    },
                },
                {
                    path: 'admin',
                    component: MenuLayout,
                    children: adminRouter
                },
            ]
        },
        {
            path: '/online-admission',
            component: MenuLayout,
            children: onlineAdmissionRouter
        },
        {
            path: '/auth',
            component: AuthLayout,
            children: authRouter
        },
        {
            path: '/parent',
            component: MenuLayout,
            children: [
                {
                    path: 'app',
                    component: ParentLayout,
                    children: adminParentRouter
                },
                {
                    path: 'auth',
                    component: AuthLayout,
                    children: authParentRouter
                },
            ]
        },
    ]
})

function nextFactory(context, middleware, index){
    const subsequentMiddleware = middleware[index];
    if (!subsequentMiddleware) return context.next;

    return (...parameters) =>{
        context.next(...parameters);
        const nextMiddleware = nextFactory(context, middleware, index + 1);
        subsequentMiddleware({ ...context, next: nextMiddleware });
    }
}
router.beforeEach((to, from, next) =>{
    if (to.meta.middleware){
        const middleware = Array.isArray(to.meta.middleware) ? to.meta.middleware : [to.meta.middleware];
        const context = {
            from, next, router, to
        };
        const nextMiddleware = nextFactory(context, middleware, 1);
        return middleware[0]({ ...context, next: nextMiddleware });
    }
    return next();
})

export default router
