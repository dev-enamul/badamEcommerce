<template>
    <div :class="[ boxStyle == 'two' ? 'product-box-two' : boxStyle == 'three' ? 'product-box-three' : boxStyle == 'four' ? 'product-box-four' : 'product-box-one']">
        <div v-if="isLoading">
            <v-skeleton-loader type="image" :height="boxStyle == 'two' ? '70' : boxStyle == 'three' ? '150' : boxStyle == 'four' ? '130' : '310'"/>
        </div>
        <div :class="['overflow-hidden', {'rounded border':!noBorder}]" v-else>
            <v-row align="center" no-gutters :class="[{'flex-nowrap': boxStyle != 'one'}]">
                <v-col :cols="boxStyle == 'one' ? '12' : 'auto'" class="flex-shrink-0">
                    <div class="position-relative">
                        <div v-if="discount > 0 && boxStyle != 'two'" class="discount-badge">
                            {{ $t('off') }} {{ discount }}%
                        </div>
                        <router-link
                            :to="{ name: 'ProductDetails', params: {slug: productDetails.slug}}"
                            class="text-reset d-block lh-0 text-center"
                        >
                            <img
                                :src="productDetails.thumbnail_image"
                                :alt="productDetails.name"
                                @error="imageFallback($event)"
                                :class="['img-fit', boxStyle == 'two' ? 'size-70px' : boxStyle == 'three' ? 'size-150px' : boxStyle == 'four' ? 'size-130px' : 'h-180px' ]"
                            >
                        </router-link>
                    </div>
                </v-col>
                <v-col :cols="boxStyle == 'one' ? '12' : null" class="minw-0 flex-shrink-0">
                    <div :class="['px-3 d-flex flex-column', boxStyle == 'two' ? 'py-1' : 'py-2']">
                        <div :class="[ boxStyle == 'two' ? 'order-2 fs-14 lh-1' : 'fs-16 mb-2']">
                            <template v-if="productDetails.base_price > productDetails.base_discounted_price">
                                <del class="opacity-40">{{ format_price(productDetails.base_price) }}</del>
                                <span class="fw-700">{{ format_price(productDetails.base_discounted_price) }}</span>
                            </template>
                            <template v-else>
                                <span class="fw-700">{{ format_price(productDetails.base_discounted_price) }}</span>
                            </template>
                        </div>
                        <h5 :class="['opacity-60 fw-400 mb-2 lh-1-6', boxStyle == 'two' ? 'text-truncate fs-12' : 'fs-13 text-truncate-2 h-40px' ]">
                            <router-link
                                :to="{ name: 'ProductDetails', params: {slug: productDetails.slug}}"
                                class="text-reset"
                            >{{ productDetails.name }}</router-link>
                            
                        </h5>
                        <div class="d-flex align-center" v-if="boxStyle != 'two'">
                            <div :class="[ boxStyle == 'three' || boxStyle == 'four' ? 'me-3' : 'flex-grow-1 me-1' ]">
                                <template v-if="productDetails.stock">
                                    <button class="text-reset py-1 lh-1 align-center d-flex" @click="showAddToCartDialog({status:true,slug:productDetails.slug})">
                                        <i class="la la-shopping-cart fs-20 ts-05 me-1"></i>
                                        <span class="fw-700 fs-13">{{ $t('buy_now') }}</span>
                                    </button>
                                    <!-- <span v-else-if="!productDetails.is_variant && isThisInCart(productDetails.variations[0].id)" class="d-flex align-center">
                                        <button class="btn-xxs size-20px d-inline-flex align-center justify-center" @click="updateCart('minus',findCartItemByVariationId(productDetails.variations[0].id).cart_id)" type="button">
                                            <i class="las la-minus fs-16 ts-05"></i>
                                        </button>
                                        <span class="mx-4">{{ findCartItemByVariationId(productDetails.variations[0].id).qty }}</span>
                                        <button class="btn-xxs size-20px d-inline-flex align-center justify-center" @click="updateCart('plus',findCartItemByVariationId(productDetails.variations[0].id).cart_id)" type="button">
                                            <i class="las la-plus fs-16 ts-05"></i>
                                        </button>
                                    </span>
                                    <button class="py-1 lh-1 align-center d-flex" v-else @click="addCart" type="button">
                                        <i class="la la-shopping-cart fs-20 ts-05 me-1"></i>
                                        <span class="fw-700 fs-13">Add to Cart</span>
                                    </button> -->
                                </template>
                                <template v-else>
                                    <span class="fw-700 fs-13 opacity-60">{{ $t('Sold Out') }}</span>
                                </template>
                            </div>
                            <div>
                                <template v-if="isThisWishlisted(productDetails.id)">                        
                                    <button class="primary--text pa-1 lh-1" @click="removeFromWishlist(productDetails.id)" type="button"><i class="la la-heart ts-02 fs-18"></i></button>
                                </template>
                                <template v-else>                        
                                    <button class="primary--text pa-1 lh-1" @click="addNewWishlist(productDetails.id)" type="button"><i class="la la-heart-o ts-02 fs-18"></i></button>
                                </template>
                            </div>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script>
import { mapGetters,mapActions,mapMutations } from "vuex";
export default {
    props: {
        isLoading: { type: Boolean, required: true, default: true },
        boxStyle: { type: String, default: 'one' },
        noBorder: { type: Boolean, default: false },
        productDetails: { type: Object, required: true, default: {} }
    },
    data: () => ({
    }),
    computed: {
        ...mapGetters("wishlist",[
            "isThisWishlisted"
        ]),
        ...mapGetters("cart",[
            "isThisInCart",
            "findCartItemByVariationId"
        ]),
        discount() {
            return this.discount_percent(this.$props.productDetails.base_price,this.$props.productDetails.base_discounted_price)
        },
    },
    methods:{
        ...mapActions("wishlist",[
            "addNewWishlist",
            "removeFromWishlist",
        ]),
        ...mapActions("cart",[
            "addToCart",
            "updateQuantity",
        ]),
        ...mapMutations('auth', ['showAddToCartDialog']),
        addCart(){
            if(!this.$props.productDetails.is_variant){
                this.addToCart({
                    variation_id: this.$props.productDetails.variations[0].id,
                    qty: this.$props.productDetails.min_qty
                })
            }
        },
        updateCart(type,cart_id){
            this.updateQuantity({
                    type:type,
                    cart_id:cart_id
                })
        }
    }
}
</script>