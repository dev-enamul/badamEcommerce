<template>
    <v-container class="pt-7 m-5 p-5 py-5">
        <v-row align="center">
            <v-col lg="10" cols="12" class="main-bar">
                <v-alert dense outlined type="error" v-html="errorMsg">
                </v-alert>
                <!-- <div class="alert alert-danger">Bkash Payment has been cancelled!</div> -->
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            errorMsg: "",
        };
    },

    created() {
        window.localStorage.removeItem("tmt");
        if (this.$route.query.payment_type == "bkash") {
            console.log(this.$route.query);
            this.errorMsg = this.$route.query.errorMsg;
        }

        if (this.$route.query.payment_type == "upay") {
            this.errorMsg =
                "Upay Payment has been <strong>cancelled!</strong> Try again";
        }

        if (this.$route.query.payment_type == "nagad") {
            this.errorMsg =
                "Nagad Payment has been <strong>cancelled!</strong> Try again";
        }

        if (this.$route.query.payment_type == "aamarpay") {
            this.errorMsg =
                "Aamarypay Payment has been <strong>cancelled!</strong> Try again";
        }

        setTimeout(() => {
            location.href = location.origin + "/checkout";
        }, 2000);
    },
};
</script>
