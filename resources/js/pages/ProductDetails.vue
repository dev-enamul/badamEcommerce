<template>
    <v-container class="pt-7">
        <v-row align="start">
            <v-col lg="10" cols="12" class="main-bar">

                <add-to-cart class="mb-10" :is-loading="detailsLoading" :product-details="productDetails" />

                <div cols="12" class="mb-6">
                    <v-expansion-panels
                        v-model="panel"
                        class="product-details-expansion"
                        flat
                        multiple
                    >
                        <v-expansion-panel class="mb-3">
                            <v-expansion-panel-header expand-icon="las la-arrow-circle-right">
                                <div class="d-flex align-center">
                                    <svg id="_004-product-description" data-name="004-product-description" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" >
                                        <g id="Group_1264" data-name="Group 1264" > <path id="Path_3166" data-name="Path 3166" d="M18.75,5H1.25A1.252,1.252,0,0,1,0,3.75V1.25A1.252,1.252,0,0,1,1.25,0h17.5A1.252,1.252,0,0,1,20,1.25v2.5A1.252,1.252,0,0,1,18.75,5ZM1.25.833a.417.417,0,0,0-.417.417v2.5a.417.417,0,0,0,.417.417h17.5a.417.417,0,0,0,.417-.417V1.25A.417.417,0,0,0,18.75.833Z" fill="#f5a100"/> </g> <g id="Group_1265" data-name="Group 1265" transform="translate(15 7.5)" > <path id="Path_3167" data-name="Path 3167" d="M20.5,14A2.5,2.5,0,1,1,23,11.5,2.5,2.5,0,0,1,20.5,14Zm0-4.167A1.667,1.667,0,1,0,22.167,11.5,1.668,1.668,0,0,0,20.5,9.833Z" transform="translate(-18 -9)" fill="#f5a100"/> </g> <g id="Group_1266" data-name="Group 1266" transform="translate(15 15)" > <path id="Path_3168" data-name="Path 3168" d="M20.5,23A2.5,2.5,0,1,1,23,20.5,2.5,2.5,0,0,1,20.5,23Zm0-4.167A1.667,1.667,0,1,0,22.167,20.5,1.668,1.668,0,0,0,20.5,18.833Z" transform="translate(-18 -18)" fill="#f5a100"/> </g> <g id="Group_1267" data-name="Group 1267" transform="translate(0 8.333)" > <path id="Path_3169" data-name="Path 3169" d="M12.917,10.833H.417a.417.417,0,1,1,0-.833h12.5a.417.417,0,1,1,0,.833Z" transform="translate(0 -10)" fill="#f5a100"/> </g> <g id="Group_1268" data-name="Group 1268" transform="translate(0 10.833)" > <path id="Path_3170" data-name="Path 3170" d="M12.917,13.833H.417a.417.417,0,1,1,0-.833h12.5a.417.417,0,1,1,0,.833Z" transform="translate(0 -13)" fill="#f5a100"/> </g> <g id="Group_1269" data-name="Group 1269" transform="translate(0 15.833)" > <path id="Path_3171" data-name="Path 3171" d="M12.917,19.833H.417a.417.417,0,1,1,0-.833h12.5a.417.417,0,1,1,0,.833Z" transform="translate(0 -19)" fill="#f5a100"/> </g> <g id="Group_1270" data-name="Group 1270" transform="translate(0 18.333)" > <path id="Path_3172" data-name="Path 3172" d="M12.917,22.833H.417a.417.417,0,0,1,0-.833h12.5a.417.417,0,1,1,0,.833Z" transform="translate(0 -22)" fill="#f5a100"/> </g>
                                    </svg>
                                    <span class="fs-16 ms-5">{{ $t("description") }}</span>
                                </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <div v-html="productDetails.description"></div>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel class="mb-3">
                            <v-expansion-panel-header expand-icon="las la-arrow-circle-right">
                                <div class="d-flex align-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" >
                                        <g id="Group_1286" data-name="Group 1286" transform="translate(-567 -1260.5)" > <g id="Group_1272" data-name="Group 1272" transform="translate(567 1260.5)" > <g id="Group_1271" data-name="Group 1271" transform="translate(0 0)" > <path id="Path_3173" data-name="Path 3173" d="M6.65,2.545a.417.417,0,0,0-.287-.273L4.655,1.805,3.684.325a.433.433,0,0,0-.7,0l-.971,1.48L.307,2.271a.417.417,0,0,0-.216.663L1.2,4.316,1.115,6.085a.417.417,0,0,0,.564.41l1.656-.627,1.656.627a.417.417,0,0,0,.564-.41L5.471,4.316,6.579,2.935A.417.417,0,0,0,6.65,2.545ZM4.722,3.917a.418.418,0,0,0-.091.281L4.692,5.49,3.483,5.032a.416.416,0,0,0-.3,0L1.978,5.49,2.04,4.2a.417.417,0,0,0-.091-.281L1.14,2.909l1.248-.341a.417.417,0,0,0,.239-.174l.709-1.081.709,1.081a.417.417,0,0,0,.239.174l1.247.341Z" transform="translate(0 -0.148)" fill="#fff"/> </g> </g> <g id="Group_1285" data-name="Group 1285" transform="translate(567 1274.127)" > <g id="Group_1271-2" data-name="Group 1271" transform="translate(0 0)" > <path id="Path_3173-2" data-name="Path 3173" d="M6.65,2.545a.417.417,0,0,0-.287-.273L4.655,1.805,3.684.325a.433.433,0,0,0-.7,0l-.971,1.48L.307,2.271a.417.417,0,0,0-.216.663L1.2,4.316,1.115,6.085a.417.417,0,0,0,.564.41l1.656-.627,1.656.627a.417.417,0,0,0,.564-.41L5.471,4.316,6.579,2.935A.417.417,0,0,0,6.65,2.545ZM4.722,3.917a.418.418,0,0,0-.091.281L4.692,5.49,3.483,5.032a.416.416,0,0,0-.3,0L1.978,5.49,2.04,4.2a.417.417,0,0,0-.091-.281L1.14,2.909l1.248-.341a.417.417,0,0,0,.239-.174l.709-1.081.709,1.081a.417.417,0,0,0,.239.174l1.247.341Z" transform="translate(0 -0.148)" fill="#fff"/> </g> </g> <g id="Group_1278" data-name="Group 1278" transform="translate(567 1267.314)" > <g id="Group_1277" data-name="Group 1277" > <path id="Path_3174" data-name="Path 3174" d="M6.65,169.895a.418.418,0,0,0-.287-.273l-1.708-.466-.971-1.48a.433.433,0,0,0-.7,0l-.971,1.48-1.708.466a.417.417,0,0,0-.216.663L1.2,171.666l-.084,1.769a.417.417,0,0,0,.564.41l1.656-.627,1.656.627a.417.417,0,0,0,.564-.41l-.084-1.769,1.108-1.381A.417.417,0,0,0,6.65,169.895Zm-1.928,1.372a.418.418,0,0,0-.091.281l.062,1.292-1.209-.458a.416.416,0,0,0-.3,0l-1.209.458.062-1.291a.417.417,0,0,0-.091-.281l-.809-1.009,1.248-.34a.417.417,0,0,0,.239-.174l.709-1.081.709,1.081a.417.417,0,0,0,.239.174l1.247.34Z" transform="translate(0 -167.498)" fill="#fff"/> </g> </g> <rect id="Rectangle_1289" data-name="Rectangle 1289" width="6.667" height="0.833" rx="0.417" transform="translate(575.333 1262.583)" fill="#fff"/> <rect id="Rectangle_1293" data-name="Rectangle 1293" width="6.667" height="0.833" rx="0.417" transform="translate(575.333 1276.21)" fill="#fff"/> <rect id="Rectangle_1291" data-name="Rectangle 1291" width="6.667" height="0.833" rx="0.417" transform="translate(575.333 1269.25)" fill="#fff"/> <rect id="Rectangle_1290" data-name="Rectangle 1290" width="11.667" height="0.833" rx="0.417" transform="translate(575.333 1265.083)" fill="#fff"/> <rect id="Rectangle_1294" data-name="Rectangle 1294" width="11.667" height="0.833" rx="0.417" transform="translate(575.333 1278.71)" fill="#fff"/> <rect id="Rectangle_1292" data-name="Rectangle 1292" width="11.667" height="0.833" rx="0.417" transform="translate(575.333 1271.75)" fill="#fff"/> </g>
                                    </svg>
                                    <span class="fs-16 ms-5">{{ $t("rating__reviews") }}</span>
                                </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content class="">
                                <ProductReviews
                                    :id="productDetails.id"
                                    :is-loading="detailsLoading"
                                    :review-summary="reviewSummary"
                                />
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </div>
                <div v-if="boughtTogetherProducts.length > 0" class="mb-5">
                    <h2 class="mb-3 fs-21 opacity-80">
                        {{ $t("frequently_bought_together") }}
                    </h2>
                    <swiper :options="carouselOption" class="">
                        <swiper-slide
                            v-for="(product, i) in boughtTogetherProducts"
                            :key="i"
                            class=""
                        >
                            <product-box :product-details="product" :is-loading="togetherLoading" />
                        </swiper-slide>
                    </swiper>
                </div>
                <div class="mb-5">
                    <h2 class="mb-3 fs-21 opacity-80">
                        {{ $t("more_items_to_explore") }}
                    </h2>
                    <swiper :options="carouselOption" class="">
                        <swiper-slide v-for="(product, i) in moreProducts" :key="i" class="">
                            <product-box :product-details="product" :is-loading="moreLoading" />
                        </swiper-slide>
                    </swiper>
                </div>
            </v-col>
            <v-col lg="2" cols="12" class="sticky-top right-bar">
                <v-row>
                    <v-col lg="12" md="3" sm="4" cols="12">
                        <template v-if="is_addon_activated('multi_vendor')">
                            <template v-if="detailsLoading">
                                <v-skeleton-loader type="image" height="158" class="mb-3" />
                            </template>
                            <div v-else class="border rounded bg-light px-3 py-2 mb-3 grey lighten-5 border-gray-300">
                                <div class="fw-700 fs-12 mb-2">{{ $t('shop') }}</div>
                                <div class="d-flex mb-2">
                                    <img :src="productDetails.shop.logo" :alt="productDetails.shop.name" class="flex-shrink-0 border rounded-circle shadow-xl size-50px mb-2">
                                    <div class="fs-13 fw-500 ms-3 mt-2 text-truncate-2 minw-0">{{ productDetails.shop.name }}</div>
                                </div>
                                <div class="d-flex align-center fs-12 mb-2">
                                    <span class="">{{ productDetails.shop.rating.toFixed(2) }}</span>
                                    <v-rating
                                        class="lh-1-5 mx-1"
                                        background-color=""
                                        empty-icon="las la-star"
                                        full-icon="las la-star active"
                                        half-icon="las la-star half"
                                        hover
                                        half-increments
                                        readonly
                                        size="12"
                                        length="5"
                                        :value="productDetails.shop.rating"
                                    >
                                    </v-rating>
                                    <span class="opacity-50"> ({{ productDetails.shop.review_count }} {{ $t("ratings") }}) </span>
                                </div>
                                <router-link :to="{ name: 'ShopDetails', params: {slug: productDetails.shop.slug}}" class="text-primary fw-500 fs-11">
                                    {{ $t('visit_store') }}
                                </router-link>
                            </div>
                        </template>
                        <template v-if="detailsLoading">
                            <v-skeleton-loader type="image" height="200" class="" />
                        </template>
                        <template v-else>
                            <banner :loading="false" :banner="$store.getters['app/banners'].product_page" class="" />
                        </template>

                        <div v-if="productDetails.has_warranty == 1" class="bg-soft-primary border border-primary d-flex rounded px-4 py-3 mt-3" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16.667" height="20" viewBox="0 0 16.667 20" >
                                <g id="Policy" transform="translate(-8.752 -4.644)" > <path id="Path_3102" data-name="Path 3102" d="M17.085,24.644a.7.7,0,0,1-.211-.033,17.254,17.254,0,0,1-6.395-4.9C8.608,17.09,8.647,11.575,8.841,7.654a.368.368,0,0,1,.133-.267.353.353,0,0,1,.28-.077,9.543,9.543,0,0,0,7.578-2.558.354.354,0,0,1,.509,0,9.507,9.507,0,0,0,7.578,2.558.353.353,0,0,1,.28.077.368.368,0,0,1,.133.267c.194,3.921.233,9.436-1.638,12.06a17.431,17.431,0,0,1-6.395,4.9A.7.7,0,0,1,17.085,24.644ZM9.558,8.063c-.172,3.779-.161,8.855,1.516,11.2A16.654,16.654,0,0,0,17.1,23.9a16.743,16.743,0,0,0,6.029-4.634c1.66-2.339,1.67-7.415,1.5-11.2A9.979,9.979,0,0,1,17.1,5.505,10,10,0,0,1,9.558,8.063Z" fill="#b8b8b8"/> <path id="Path_3103" data-name="Path 3103" d="M25.523,30.137a.358.358,0,0,1-.258-.111L23.387,28.1a.359.359,0,1,1,.513-.5l1.613,1.652,3.405-3.724a.359.359,0,0,1,.531.484l-3.66,4a.376.376,0,0,1-.258.118Z" transform="translate(-9.323 -13.133)" fill="#b8b8b8"/> </g>
                            </svg>
                            <span class="ms-2">
                                <div class="fw-700">
                                    {{ $t("warranty_available") }}
                                </div>
                                <router-link :to="{ name: 'CustomPage', params: { pageSlug: 'warranty-policy' }, }" class="text-decoration-underline grey--text fs-12" >
                                    * {{ $t("view_warranty_policy") }}
                                </router-link>
                            </span>
                        </div>
                    </v-col>
                    <v-col lg="12" md="9" sm="8" cols="12">
                        <div class="mb-4">
                            <div class="mb-3">{{ $t("related_products") }}</div>
                            <v-row class="row-cols-2 row-cols-md-3 row-cols-lg-1 gutters-10">
                                <v-col v-for="(product, i) in relatedProducts" :key="i" class="py-2">
                                    <product-box :product-details="product" :is-loading="relatedLoading" box-style="two"/>
                                </v-col>
                            </v-row>
                        </div>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";
import ProductReviews from "../components/product/ProductReviews";
import AddToCart from '../components/product/AddToCart.vue';
export default {
    metaInfo() {
        return {
            title: this.metaTitle,
        }
    },
    data: () => ({
        metaTitle: '',
        detailsLoading: true,
        productDetails: {},
        reviewSummary: { average: 0 },
        relatedLoading: true,
        relatedProducts: [{}, {}, {}, {}, {}],
        togetherLoading: true,
        boughtTogetherProducts: [{}, {}, {}, {}, {}],
        moreLoading: true,
        moreProducts: [{}, {}, {}, {}, {}],
        panel: [0,1],
        carouselOption: {
            slidesPerView: 5,
            spaceBetween: 20,
            breakpoints: {
                0: {
                    slidesPerView: 2,
                    spaceBetween: 12,
                },
                // when window width is >= 320px
                599: {
                    slidesPerView: 3,
                    spaceBetween: 16,
                },
                // when window width is >= 480px
                960: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
                // when window width is >= 640px
                1264: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
                1904: {
                    slidesPerView: 5,
                    spaceBetween: 20,
                },
            },
        },
    }),
    components: {
        ProductReviews,
        AddToCart
    },
    computed: {
    },
    methods: {
        ...mapActions("recentlyViewed", ["addNewRecentlyViewedProduct"]),
        async getDetails() {
            const res = await this.call_api( "get", `product/details/${this.$route.params.slug}`);
            if (res.data.success) {

                this.metaTitle = res.data.data.metaTitle;
                this.productDetails = res.data.data;
                this.reviewSummary = this.productDetails.review_summary;

                this.getRelatedProducts(this.productDetails.id);
                this.getBoughtTogetherProducts(this.productDetails.id);
                this.getMoreProducts(this.productDetails.id);
                this.addNewRecentlyViewedProduct(this.productDetails.id);
                
            } else {
                this.snack({
                    message: res.data.message,
                    color: "red",
                });
                this.$router.push({ name: "404" });
            }
            this.detailsLoading = false;
        },
        async getRelatedProducts(id) {
            const res = await this.call_api("get", `product/related/${id}`);
            if (res.data.success) {
                this.relatedProducts = res.data.data;
                this.relatedLoading = false;
            }
        },
        async getBoughtTogetherProducts(id) {
            const res = await this.call_api( "get", `product/bought-together/${id}` );
            if (res.data.success) {
                this.boughtTogetherProducts = res.data.data;
                this.togetherLoading = false;
            }
        },
        async getMoreProducts(id) {
            const res = await this.call_api("get", `product/random/10/${id}`);
            if (res.data.success) {
                this.moreProducts = res.data.data;
                this.moreLoading = false;
            }
        },
        
    },
    async created() {
        this.getDetails();
    },
};
</script>
<style scoped>
@media (max-width: 1263px) {
}
@media (min-width: 1264px) {
    .main-bar {
        max-width: calc(100% - 224px);
    }
    .right-bar {
        width: 224px;
        max-width: 224px;
    }
}
</style>