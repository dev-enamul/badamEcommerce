<script>
export default {
    data() {
        return {
            image_url: window.location.origin,
        };
    },
};
</script>
<template>
    <div>
        <v-container fluid>
            <v-layout justify-center align-center>
                <v-flex shrink>
                    <img
                        :src="`${image_url}/public/assets/img/about-us.jpg`"
                        alt="about us"
                        style="object-fit: cover"
                    />
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>
