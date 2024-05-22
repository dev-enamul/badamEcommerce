import Vue from "vue";
import Vuex from "vuex";
import addressModule from "./modules/address";
import appModule from "./modules/app";
import authModule from "./modules/auth";
import cartModule from "./modules/cart";
import recentlyViewed from "./modules/recentlyViewed";
import snackBar from "./modules/snackbar";
import wishlistModule from "./modules/wishlist";
import followModule from "./modules/follow";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        app: appModule,
        auth: authModule,
        address: addressModule,
        wishlist: wishlistModule,
        follow: followModule,
        cart: cartModule,
        snackbar: snackBar,
        recentlyViewed: recentlyViewed,
    },
});

export default store;
