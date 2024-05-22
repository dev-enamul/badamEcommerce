<template>
    <div class="">
        <v-container>
            <v-row no-gutters>
                <v-col lg="3" class="d-none d-lg-block">
                    <sidemenu></sidemenu>
                </v-col>
                <v-col cols="12" lg="9" class="pt-0">
                    <router-view></router-view>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import sidemenu from "./SideMenu";
export default {
    components: {
        sidemenu
    }
};
</script>

<style lang="scss" scoped></style>
