<template>
    <div :class="[ boxStyle == 'two' ? 'shop-box-two' : boxStyle == 'three' ? 'shop-box-three' : boxStyle == 'four' ? 'shop-box-four' : 'shop-box-one']">
        <div v-if="isLoading && is_empty_obj(shopDetails)">
            <v-skeleton-loader type="image" height="310" />
        </div>
        <div class="border rounded overflow-hidden" v-else>
            <v-row no-gutters align="center">
                <v-col :sm="(boxStyle == 'three') ? '6' : null" cols="12" class="minw-0 position-relative">
                    <div class="lh-0 position-relative" v-if="boxStyle != 'three'">
                        <router-link :to="{ name: 'ShopDetails', params: {slug: shopDetails.slug}}" class="text-reset d-block">
                            <img :src="shopDetails.banner" @error="imageFallback($event)" :alt="shopDetails.name" class="img-fit h-150px">
                        </router-link>
                        <div v-if="boxStyle == 'two'" class="absolute-bottom-left w-100 grey darken-3 white--text d-flex align-center py-2 fs-12 px-3">
                            <span class="me-1 fw-600">{{ shopDetails.rating.toFixed(2) }}</span>
                            <v-rating
                                class="lh-1-2"
                                background-color=""
                                empty-icon="las la-star"
                                full-icon="las la-star active"
                                half-icon="las la-star half"
                                hover
                                half-increments
                                readonly
                                size="11"
                                length="5"
                                :value="shopDetails.rating"
                            >
                            </v-rating>
                            <span class="ms-3 opacity-50">({{ shopDetails.reviews_count }} {{ $t('ratings') }})</span>
                        </div>
                    </div>
                    <div
                        :class="[
                            'text-center fs-12',
                            boxStyle == 'three' ? 'pa-4'
                            : boxStyle == 'four' ? 'absolute-left-center align-center d-flex ms-4'
                            : 'pa-5 position-relative'
                        ]"
                    >
                        <router-link :to="{ name: 'ShopDetails', params: {slug: shopDetails.slug}}" class="text-reset" v-if="boxStyle != 'two'">
                            <img
                                :src="shopDetails.logo"
                                :alt="shopDetails.name"
                                @error="imageFallback($event)"
                                :class="['border rounded-circle shadow-2xl border-2 size-90px', { 'mt-n15' : boxStyle == 'one' }, {'mb-2': boxStyle != 'four'}]"
                            >
                        </router-link>
                        <div :class="[{'ms-3 pt-1 pb-2 px-3 text-start position-relative': boxStyle == 'four'}]">
                            <div class="white absolute-full opacity-80" style="z-index:-1" v-if="boxStyle == 'four'"></div>
                            <router-link :to="{ name: 'ShopDetails', params: {slug: shopDetails.slug}}" class="text-reset">
                                <h4 :class="['fs-21', boxStyle == 'three' ? 'text-truncate-2 lh-1-4 h-60px' : 'text-truncate',{'mb-2': boxStyle != 'four'}]">{{ shopDetails.name }}</h4>
                            </router-link>
                            <div class="text-truncate-2 opacity-80 h-40px" v-if="boxStyle == 'one'">
                                <span v-for="(category, i) in shopDetails.categories.data" :key="i">
                                    {{ category.name }}<span v-if="(shopDetails.categories.data.length - i) != 1">,</span>
                                </span>
                            </div>
                            <div :class="['d-flex fs-12',{'my-2 justify-center': boxStyle != 'four'}]" v-if="boxStyle != 'two'">
                                <span :class="[boxStyle == 'three' ? '' : 'me-2']">{{ shopDetails.rating.toFixed(1) }}</span>
                                <v-rating
                                    class="lh-1-4"
                                    background-color=""
                                    empty-icon="las la-star"
                                    full-icon="las la-star active"
                                    half-icon="las la-star half"
                                    hover
                                    half-increments
                                    readonly
                                    size="11"
                                    length="5"
                                    :value="shopDetails.rating"
                                >
                                </v-rating>
                                <span class="opacity-80">({{ shopDetails.reviews_count }} {{ $t('ratings') }})</span>
                            </div>
                            <div class="opacity-80" v-if="boxStyle == 'one'">{{ $t('shop_since')+' '+ shopDetails.since }}</div>
                            <div class="opacity-80" v-if="boxStyle == 'one'">{{ $t('total_products')+' '+ shopDetails.products_count }}</div>
                        </div>
                        <div
                            :class="[boxStyle == 'two' ? 'd-flex flex-column mt-5' : boxStyle == 'three' ? 'd-flex flex-column mt-3' : 'mt-5']"
                            v-if="boxStyle != 'four'"
                        >
                            <template v-if="isThisFollowed(shopDetails.id)">                        
                                <v-btn
                                    elevation="0"
                                    :small="boxStyle == 'one' ? false : true"
                                    @click="removeFromFollowedShop(shopDetails.id)"
                                    :class="['grey', boxStyle == 'one' ? 'white--text darken-1' : 'lighten-2']"
                                    v-if="boxStyle == 'one' || boxStyle == 'two' "
                                >
                                    {{ $t('unfollow') }}
                                </v-btn>
                            </template>
                            <template v-else>
                                <v-btn
                                    elevation="0"
                                    :small="boxStyle == 'one' ? false : true"
                                    @click="addNewFollowedShop(shopDetails.id)"
                                    :class="[boxStyle == 'one' ? 'primary' : 'grey lighten-4 border border-gray-300']"
                                    v-if="boxStyle == 'one' || boxStyle == 'two' "
                                >
                                    {{ $t('follow') }}
                                </v-btn>
                            </template>
                            <v-btn
                                elevation="0"
                                :small="boxStyle == 'one' ? false : true"
                                :to="{ name: 'ShopDetails', params: {slug: shopDetails.slug}}"
                                :class="[
                                    boxStyle == 'one' ? 'ms-4 white--text grey darken-4'
                                    : boxStyle == 'two' ? 'mt-2 bg-soft-primary border border-primary'
                                    : boxStyle == 'three' ? 'mt-2 bg-soft-primary border border-primary'
                                    : 'mt-2 bg-soft-primary border border-primary'
                                ]"
                            >
                                {{ $t('visit_store') }}
                            </v-btn>
                        </div>
                    </div>
                </v-col>
                <v-col v-if="boxStyle == 'three' || boxStyle == 'four'" cols="12" :sm="(boxStyle == 'three') ? '6' : null" class="minw-0">
                    <div :class="[boxStyle == 'four' ? 'pa-4' : '']">
                        <v-row :no-gutters="boxStyle == 'four' ? false : true" class="gutters-10" v-if="$optional('shopDetails.top_3_products?.data').length">
                            <v-col
                                cols="12"
                                v-for="(product, i) in shopDetails.top_3_products.data"
                                :sm="boxStyle == 'four' ? '4' : null"
                                :key="i"
                            >
                                <product-box
                                    :product-details="product"
                                    :is-loading="isLoading"
                                    box-style="two"
                                    :class="[
                                        boxStyle == 'three' && i == 0 ? 'my-4 me-4'
                                        : boxStyle == 'three' ? 'mb-4 me-4'
                                        : ''
                                    ]"
                                />
                            </v-col>
                        </v-row>
                        <div style="height:73px" v-else></div>
                        <div v-if="boxStyle == 'four'" class="text-end mt-3">
                            <v-btn
                                small
                                link
                                elevation="0"
                                :to="{ name: 'ShopDetails', params: {slug: shopDetails.slug}}"
                                class="primary--text transparent"
                            >
                                <span>{{ $t('visit_store') }}</span>
                                <i class="las la-arrow-right"></i>
                            </v-btn>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script>
import { mapGetters,mapActions } from "vuex";
export default {
    props: {
        boxStyle: { type: String, default: 'one' },
        isLoading: { type: Boolean, required: true, default: true },
        shopDetails: { type: Object, required: true, default: {} }
    },
    computed:{
        ...mapGetters("follow",[
            "isThisFollowed"
        ]),
    },
    methods:{
        ...mapActions("follow",[
            "addNewFollowedShop",
            "removeFromFollowedShop",
        ]),
    },
}
</script>