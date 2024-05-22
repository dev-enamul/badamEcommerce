let DashBoard = () => import("../pages/user/Dashboard");
let PurchaseHistory = () => import("../pages/user/PurchaseHistory");
let OrderDetails = () => import("../pages/user/OrderDetails");
let RefundRequests = () => import("../pages/user/refund_request/RefundRequestList");
let RefundRequestCreate = () => import("../pages/user/refund_request/RefundRequestCreate");
let Wishlist = () => import("../pages/user/Wishlist");
let Conversations = () => import("../pages/user/Conversations");
let ConversationDetails = () => import("../pages/user/ConversationDetails");
let FollowedShops = () => import("../pages/user/FollowedShops");
let Wallet = () => import("../pages/user/Wallet");
let Coupon = () => import("../pages/user/Coupon");
let Profile = () => import("../pages/user/Profile");
let UserLayout = () => import("../components/user/UserLayout");
let Error404 = () => import('../pages/errors/404')

export default [
    {
        path: "/user/",
        component: UserLayout,
        redirect: "/user/dashboard",
        children: [
            {
                path: "dashboard",
                component: DashBoard,
                name: "DashBoard",
                meta: { requiresAuth: true },
            },
            {
                path: "purchase-history",
                component: PurchaseHistory,
                name: "PurchaseHistory",
                meta: { requiresAuth: true },
            },
            {
                path: "purchase-history/:code",
                component: OrderDetails,
                name: "OrderDetails",
                meta: { requiresAuth: true },
            },
            {
                path: "refund-requests",
                component: RefundRequests,
                name: "RefundRequests",
                meta: { requiresAuth: true },
            },
            {
                path: "create-refund-request/:orderId",
                component: RefundRequestCreate,
                name: "CreateRefundRequest",
                meta: { requiresAuth: true },
            },
            {
                path: "wishlist",
                component: Wishlist,
                name: "Wishlist",
                meta: { requiresAuth: true },
            },
            {
                path: "followed-shops",
                component: FollowedShops,
                name: "FollowedShops",
                meta: { requiresAuth: true },
            },

            {
                path: "product-query",
                component:
                    window.shopSetting.general_settings.conversation_system == 1
                        ? Conversations
                        : Error404,
                name: "Conversations",
                meta: { requiresAuth: true },
            },
            {
                path: "product-query/:slug",
                component:
                    window.shopSetting.general_settings.conversation_system == 1
                        ? ConversationDetails
                        : Error404,
                name: "ConversationsDetails",
                meta: { requiresAuth: true },
            },
            {
                path: "wallet",
                component:
                    window.shopSetting.general_settings.wallet_system == 1
                        ? Wallet
                        : Error404,
                name: "Wallet",
                meta: { requiresAuth: true },
            },
            {
                path: "coupon",
                component: Coupon,
                name: "Coupon",
                meta: { requiresAuth: true },
            },
            {
                path: "profile",
                component: Profile,
                name: "Profile",
                meta: { requiresAuth: true },
            },
        ],
    },
];
