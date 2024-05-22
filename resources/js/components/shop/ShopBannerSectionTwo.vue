<template>
    <div class="">
        <swiper :options="carouselOption" class="mb-4">
            <swiper-slide v-for="(banner, i) in banners" :key="i" class="">
                <banner :loading="isLoading" :banner="banner"/>
            </swiper-slide>
        </swiper>
    </div>
</template>

<script>
export default {
    props: {
        isLoading: { type: Boolean, required: true, default: true },
        banners: { type: Array, required: true, default: [] }
    },
    data: () => ({
        carouselOption: {
            slidesPerView: 1,
        },
    }),
}
</script>