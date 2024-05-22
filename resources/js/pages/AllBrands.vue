<template>
    <div class="pb-6">
        <v-container>
            <h1 class="mb-7 mt-4">{{ $t('all_brands') }}</h1>
            <v-row v-if="brands.length" class="row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6">
                <v-col v-for="(brand, i) in brands" :key="i">
                    <div v-if="loading">
                        <v-skeleton-loader
                            type="image"
                            class=""
                            height="100"
                        ></v-skeleton-loader>
                    </div>
                    <v-card outlined class="text-center" v-else>
                        <router-link :to="{ name: 'Brand', params: {brandId: brand.id }}" class="align-center d-block d-flex justify-center pa-4 text-reset">
                            <span class="h-80px">
                                <img
                                    class="mw-100 mh-100"
                                    :src="brand.logo"
                                    :alt="brand.name"
                                    @error="imageFallback($event)"
                                />
                            </span>
                        </router-link>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    data: () => ({
        loading: true,
        brands: [{},{},{},{},{},{}]
    }),
    mounted: () => {},
    methods: {},
    async created() {
        const res = await this.call_api("get", "all-brands");
        if (res.data.success) {
            this.brands = res.data.data
            this.loading = false
        }
    }
}
</script>