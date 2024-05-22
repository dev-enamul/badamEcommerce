let Checkout = () => import('../pages/Checkout')
let Success = () => import('../pages/Success')
let Cancel = () => import('../pages/Cancel')
let Failed = () => import('../pages/Failed')
let Proceed = () => import('../pages/Proceed')
let OrderConfirmed = () => import('../pages/OrderConfirmed')

export default [
    {
        path: '/checkout',
        component: Checkout,
        name: 'Checkout',
        meta: { requiresAuth: true },
    },

    {
        path: '/order-confirmed',
        component: OrderConfirmed,
        name: 'OrderConfirmed',
        meta: { requiresAuth: true },
    },
    {
        path: '/success',
        component: Success,
        name: 'Success',
        meta: { requiresAuth: true },
    },
    {
        path: '/cancel',
        component: Cancel,
        name: 'Cancel',
        meta: { requiresAuth: true },
    },
    {
        path: '/failed',
        component: Failed,
        name: 'Failed',
        meta: { requiresAuth: true },
    },
    {
        path: '/proceed',
        component: Proceed,
        name: 'Proceed',
        meta: { requiresAuth: true },
    },
]