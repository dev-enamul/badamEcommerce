<template>
    <div>
        <v-app class="d-flex flex-column">
            <Header />

            <v-main class="aiz-main-wrap">
                <router-view :key="['ShopDetails','ShopCoupons','ShopProducts'].includes($route?.name) ? null : $route.path"></router-view>
            </v-main>

            <Footer :class="['mt-auto', { 'd-none': routerLoading }]" />

            <BottomChat />
            <SidebarCart />
            <AddToCartDialog />
            <LoginDialog v-if="!isAuthenticated" />
            <MobileMenu class="d-lg-none" />
            <SnackBar />
        </v-app>
    </div>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import SidebarCart from "./cart/SidebarCart";
import BottomChat from "./inc/BottomChat";
import SnackBar from "./inc/SnackBar";
import MobileMenu from "./inc/MobileMenu";
import LoginDialog from "./auth/LoginDialog.vue";
import AddToCartDialog from './product/AddToCartDialog'; 
import { mapGetters, mapActions, mapMutations } from "vuex";
export default {
    metaInfo() {
        return {
            title: this.appMetaTitle,
        }
    },
    components: {
        Header,
        Footer,
        BottomChat,
        SidebarCart,
        SnackBar,
        LoginDialog,
        MobileMenu,
        AddToCartDialog
    },
    computed: {
        ...mapGetters("auth", ["isAuthenticated"]),
        ...mapGetters("app", ["appMetaTitle", "userLanguageObj", "routerLoading"]),
    },
    methods: {
        ...mapActions("auth", ["getUser", "checkSocialLoginStatus"]),
        ...mapMutations("auth", ["setSociaLoginStatus"]),
        changeRTL() {
            if (this.userLanguageObj?.rtl == 1) {
                this.$vuetify.rtl = true;
            } else {
                this.$vuetify.rtl = false;
            }
        },
    },
    async created() {
        this.changeRTL();
        await this.getUser();
        setTimeout(() => {
            this.checkSocialLoginStatus();
        }, 200);
    },
};
</script>
<style scoped>
.absolute-full {
    background: #fff;
    z-index: 10000;
}
</style>
