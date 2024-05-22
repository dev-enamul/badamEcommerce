
let AllShops = () => import('../pages/shop/AllShops')
let ShopRegistration = () => import('../pages/shop/ShopRegistration')
let ShopConfirmation = () => import('../pages/shop/ShopConfirmation')
let ShopLayout = () => import('../pages/shop/ShopLayout')
let ShopDetails = () => import('../pages/shop/ShopDetails')
let ShopCoupons = () => import('../pages/shop/ShopCoupons')
let ShopProducts = () => import('../pages/shop/ShopProducts')


export default [
    {
        path: '/all-shops',
        component: AllShops,
        name: 'AllShops',
        meta: { requiresAuth: false },
    },
    {
        path: '/register-shop',
        component: ShopRegistration,
        name: 'ShopRegistration',
        meta: { requiresAuth: false },
    },
    {
        path: '/register-shop-confirmation',
        component: ShopConfirmation,
        name: 'ShopConfirmation',
        meta: { requiresAuth: false },
    },
    {
        path: "/shop/",
        component: ShopLayout,
        children: [
            {
                path: ':slug',
                component: ShopDetails ,
                name: 'ShopDetails',
                meta: { requiresAuth: false },
            },
            {
                path: ':slug/coupons',
                component: ShopCoupons ,
                name: 'ShopCoupons',
                meta: { requiresAuth: false },
            },
            {
                path: ':slug/products/:categorySlug?',
                component: ShopProducts ,
                name: 'ShopProducts',
                meta: { requiresAuth: false },
            },
        ]
    }

]