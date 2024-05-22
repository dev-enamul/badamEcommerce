let Error404 = () => import("../pages/errors/404");
let Error500 = () => import("../pages/errors/500");
let CustomPage = () => import("../pages/CustomPage");
let AboutUs = () => import("../pages/AboutUs");

export default [
    // {
    //     path: '/500',
    //     component: Error500,
    //     name: '500',
    //     meta: { requiresAuth: false },
    // },
    {
        path: "/404",
        component: Error404,
        name: "404",
        meta: { requiresAuth: false },
    },
    {
        path: "/about-badami",
        component: AboutUs,
        name: "AboutUs",
        meta: { requiresAuth: false },
    },
    {
        path: "/:pageSlug?",
        component: CustomPage,
        name: "CustomPage",
        meta: { requiresAuth: false },
    },
    {
        path: "*",
        component: Error404,
        name: "NotFound",
        meta: { requiresAuth: false },
    },
];
