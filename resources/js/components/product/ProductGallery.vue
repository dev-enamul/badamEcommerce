<template>
    <div>
        <template v-if="isLoading">
            <v-skeleton-loader
                type="image"
                class="mb-4"
                height="420"
            ></v-skeleton-loader>
            <v-row class="gutters-10">
                <v-col>
                    <v-skeleton-loader
                        type="image"
                        class="mb-2"
                        height="90"
                    ></v-skeleton-loader>
                </v-col>
                <v-col>
                    <v-skeleton-loader
                        type="image"
                        class="mb-2"
                        height="90"
                    ></v-skeleton-loader>
                </v-col>
                <v-col>
                    <v-skeleton-loader
                        type="image"
                        class="mb-2"
                        height="90"
                    ></v-skeleton-loader>
                </v-col>
                <v-col>
                    <v-skeleton-loader
                        type="image"
                        class="mb-2"
                        height="90"
                    ></v-skeleton-loader>
                </v-col>
            </v-row>
        </template>
        <div class="" v-show="!isLoading">
            <VueSlickCarousel
                ref="c1"
                :asNavFor="$refs.c2"
                v-bind="galleryImagesOption"
                v-if="galleryImgaes.length"
                class="mb-4 border rounded"
                @beforeChange="syncGallery"
            >
                <template
                    v-for="(photo, i) in galleryImgaes"
                >
                    <div :key="i" class="">
                        <img
                            :src="photo"
                            alt=""
                            class="img-fluid "
                        />
                    </div>
                </template>
            </VueSlickCarousel>
            <VueSlickCarousel
                ref="c2"
                :asNavFor="$refs.c1"
                v-bind="galleryThumbsOption"
                v-if="galleryImgaes.length"
                class="gutters-5 md-gutters-10 gallery-thumbs"
                @beforeChange="syncGallery"
            >
                <template
                    v-for="(photo, i) in galleryImgaes"
                >
                    <div :key="i" class="carousel-box">
                        <div class="border rounded overflow-hidden c-pointer">
                            <img
                                :src="photo"
                                alt=""
                                class="img-fluid"
                            />
                        </div>
                    </div>
                </template>
            </VueSlickCarousel>
        </div>
    </div>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'
export default {
    props: {
        isLoading: { type: Boolean, default: true },
        galleryImgaes: { type: Array, required: true, default: () => [] },
    },
    data: () => ({
        c1: undefined,
        c2: undefined,
        galleryImagesOption: {
            focusOnSelect: true,
            arrows: false,
            adaptiveHeight:true
        },
        galleryThumbsOption: {
            slidesToShow:4,
            arrows: false,
            focusOnSelect:true
        },
    }),
    components:{
        VueSlickCarousel,
    },
    methods: {
        syncGallery(currentPosition, nextPosition) {
            this.$refs.c1.goTo(nextPosition)
            this.$refs.c2.goTo(nextPosition)
        },
    },
    mounted() {
        this.c1 = this.$refs.c1;
        this.c2 = this.$refs.c2;
    }
}
</script>