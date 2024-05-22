<template>
    <v-container class="pt-6 pb-14">
        <v-row>
            <v-col cols="12" lg="6" md="8" sm="10" class="mx-auto text-center">
                <img :src="banner" alt="shop confirmation" class="h-md-300px mw-100">
                <h1>{{ $t('thanks_for_registering_your_shop') }}</h1>
                <div class="fs-16">{{ $t("we_will_get_back_to_very_soon") }}</div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        banner: Vue.helpers.asset("/assets/img/shop-confirmation.jpg"),
    }),
}
</script>