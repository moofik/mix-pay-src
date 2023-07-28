import { createWebHistory, createRouter } from 'vue-router'
import store from '@/store'


/* Guest Component */
const Login = () => import('@/components/Login.vue')
const Register = () => import('@/components/Register.vue')
const Payment = () => import('@/components/Payment.vue');
const PaymentRegistered = () => import('@/components/PaymentRegistered.vue');
/* Guest Component */

/* Layouts */
const DahboardLayout = () => import('@/components/layouts/Default.vue')
/* Layouts */

/* Authenticated Component */
const Dashboard = () => import('@/components/Dashboard.vue')
/* Authenticated Component */


const routes = [
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {
        name: "payment",
        path: "/",
        component: Payment,
        meta: {
            title: `Payment`
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    mode: "history",
    routes, // short for `routes: routes`
})


export default router