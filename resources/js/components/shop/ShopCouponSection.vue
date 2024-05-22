<template>
    <div class="">
        <h2 class="mb-4">{{ $t('coupons') }}</h2>
        <swiper :options="carouselOption" class="mb-4">
            <swiper-slide v-for="(coupon, i) in coupons" :key="i" class="">
                <coupon-box :is-loading="isLoading" :coupon-details="coupon" />
            </swiper-slide>
        </swiper>
    </div>
</template>

<script>
import CouponBox from '../coupon/CouponBox'
export default {
    components: { CouponBox },
    props: {
        isLoading: { type: Boolean, required: true, default: true },
        coupons: { type: Array, required: true, default: [] }
    },
    data: () => ({
        carouselOption: {
            slidesPerView: 3,
            spaceBetween: 20,
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                // when window width is >= 320px
                599: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                // when window width is >= 480px
                960: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                // when window width is >= 640px
                1264: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                1904: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
            }
        },
    }),
}
</script>