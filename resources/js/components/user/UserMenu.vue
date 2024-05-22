<template>
    <v-list-item-group color="primary">
        <v-list-item
            v-for="(route, i) in routes"
            :key="i"
            :to="{ name: route.to }"
            class="mb-0"
        >
            <v-list-item-icon class="me-4 d-flex align-center">
                <i :class="route.icon" class="fs-17"></i>
            </v-list-item-icon>

            <v-list-item-content>
                <v-list-item-title
                    class="fw-500 fs-14"
                    v-text="route.label"
                ></v-list-item-title>
            </v-list-item-content>
        </v-list-item>
    </v-list-item-group>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    computed: {
        ...mapGetters("app", ["generalSettings","getUnseenProductQuerries"]),
        routes(){
            return this.getMenuItems().sort((a, b) => a.order - b.order);
        },
    },
    methods:{
        getMenuItems() {
            let items = [
                {
                    label: this.$i18n.t("dashboard"),
                    order: 10,
                    icon: "las la-th-large",
                    to: "DashBoard",
                },
                {
                    label: this.$i18n.t("purchase_history"),
                    order: 20,
                    icon: "las la-file-invoice-dollar",
                    to: "PurchaseHistory",
                },
                {
                    label: this.$i18n.t("wishlist"),
                    order: 30,
                    icon: "la la-heart-o",
                    to: "Wishlist",
                }, 
                {
                    label: this.$i18n.t("coupons"),
                    order: 50,
                    icon: "las la-tags",
                    to: "Coupon",
                },
                {
                    label: this.$i18n.t("manage_profile"),
                    order: 60,
                    icon: "las la-user",
                    to: "Profile",
                },
            ];

            let wallet = {
                label: this.$i18n.t("my_wallet"),
                order: 40,
                icon: "las la-wallet",
                to: "Wallet",
            };
            if (this.generalSettings.wallet_system == 1) {
                items.push(wallet);
            }

            let refund_request = {
                label: this.$i18n.t("refund_requests"),
                order: 21,
                icon: "las la-undo-alt",
                to: "RefundRequests",
            };
            if (this.is_addon_activated('refund')) {
                items.push(refund_request);
            }
            
            let shop = {
                label: this.$i18n.t("followed_shops"),
                order: 35,
                icon: "las la-store-alt",
                to: "FollowedShops",
            };

            if (this.is_addon_activated('multi_vendor')) {
                items.push(shop);
            }

            // conversation
            let conversation = {
                label: this.$i18n.t("product_querries") +'( '+ this.getUnseenProductQuerries+ ' )',
                order: 36,
                icon: "la la-comment",
                to: "Conversations",
            };
            if (this.generalSettings.conversation_system == 1 && this.is_addon_activated('multi_vendor') ) {
                items.push(conversation);
            }

            return items;
        }
    },
};
</script>
