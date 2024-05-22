<template>
    <div class="logobar">
        <v-container class="pb-md-0 pt-4">
            <div class="d-flex align-center">
                <div class="logo">
                    <router-link :to="{ name: 'Home' }" class="d-block lh-0">
                        <img :src="appLogo" :alt="appName" height="40" />
                    </router-link>
                </div>
                <v-spacer />
                <div :class="['flex-grow-1 search-box', { open: openSearch }]">
                    <v-form
                        class="border rounded flex-grow-1"
                        @submit.stop.prevent="search()"
                    >
                        <v-row align="center" dense>
                            <v-col cols="auto ms-1" class="d-md-none">
                                <v-btn icon @click.stop="toggleSearch(false)">
                                    <i class="las la-arrow-left fs-18 ts-05" ></i>
                                </v-btn>
                            </v-col>
                            <v-col>
                                <v-text-field
                                    :placeholder="$t('search_for_products_brands_and_more')"
                                    type="text"
                                    hide-details="auto"
                                    class=""
                                    v-model="searchKeyword"
                                    required
                                    solo
                                    flat
                                ></v-text-field>
                            </v-col>
                            <v-col cols="auto me-1" class="d-none d-md-block">
                                <v-btn
                                    block
                                    color="primary"
                                    elevation="0"
                                    @click.stop.prevent="search()"
                                    >{{ $t("search") }}</v-btn
                                >
                            </v-col>
                        </v-row>
                    </v-form>
                </div>
                <v-btn
                    class="d-md-none border-gray-300"
                    fab
                    outlined
                    small
                    @click.stop="toggleSearch(true)"
                >
                    <i class="las la-search fs-18 ts-05"></i>
                </v-btn>
                <v-spacer class="d-none d-md-block" />
                <div class="d-none d-md-block">
                    <div class="d-flex align-center" v-if="!isAuthenticated">
                        <i class="las la-user fs-30 lh-1 me-3 opacity-70"></i>
                        <router-link
                            :to="{ name: 'Login' }"
                            class="text-reset opacity-80 fw-500"
                            >{{ $t("login") }}</router-link
                        >
                        <span class="mx-3 opacity-60">{{ $t("or") }}</span>
                        <router-link
                            :to="{ name: 'Registration' }"
                            class="text-reset opacity-80 fw-500"
                            >{{ $t("registration") }}</router-link
                        >
                    </div>
                    <div class="d-flex align-center" v-else>
                        <i class="las la-user fs-30 lh-1 me-3 opacity-70"></i>
                        <router-link
                            :to="{ name: 'DashBoard' }"
                            class="text-reset opacity-80 fw-500"
                            >{{ $t("dashboard") }}</router-link
                        >
                        <span class="mx-3 opacity-60">{{ $t('or') }}</span>
                        <div
                            class="text-reset opacity-80 fw-500 c-pointer"
                            @click.stop="logout"
                        >
                            {{ $t("logout") }}
                        </div>
                    </div>
                </div>
            </div>
        </v-container>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    props: {
        loading: { type: Boolean, required: true, default: true },
        data: {
            type: Object,
            default: {},
        },
    },
    data: () => ({
        openSearch: false,
        searchKeyword: "",
    }),
    computed: {
        ...mapGetters("app", ["appLogo", "appName"]),
        ...mapGetters("auth", ["isAuthenticated"]),
    },
    methods: {
        ...mapActions(["auth/logout"]),
        ...mapActions("cart", ["resetCart"]),
        ...mapActions("wishlist", ["resetWishlist"]),
        search() {
            this.$router
                .push({
                    name: "Search",
                    params:
                        this.searchKeyword.length > 0
                            ? { keyword: this.searchKeyword }
                            : {},
                    query: {
                        page: 1,
                    },
                })
                .catch(() => {});
        },
        async logout() {
            const res = await this.call_api("get", "auth/logout");
            this["auth/logout"]();
            this.resetCart();
            this.resetWishlist();
            this.$router.push({ name: "Home" }).catch(() => {});
        },
        toggleSearch(status) {
            this.openSearch = status;
        },
    },
};
</script>
<style scoped>
.logobar {
    min-height: 68px;
    position: relative;
    z-index: 1;
}
@media (max-width: 959px) {
    .search-box {
        position: absolute;
        width: calc(100% - 24px);
        padding: 9px 0;
        height: 100%;
        left: 12px;
        right: 12px;
        top: -100%;
        background: #fff;
        display: flex;
        align-items: center;
        z-index: 3;
        transition: top 0.3s;
        -webkit-transition: top 0.3s;
    }
    .search-box.open {
        top: 0px;
    }
}
@media (min-width: 960px) {
    .search-box {
        position: static;
    }
}
</style>
