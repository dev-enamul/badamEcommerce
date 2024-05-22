<template>
    <v-container class="pt-7">
        <v-row align="center">
            <v-col lg="10" cols="12" class="main-bar">
                <v-alert
                dense
                outlined
                type="error"
                v-html="errorrMsg"
                >
                
                </v-alert>
               <!-- <div class<v-icon red left >mdi-cancel</v-icon> ="alert alert-danger">Bkash Payment has been failed!</div> -->
            </v-col>
            
        </v-row>
    </v-container>
</template>

<script>
export default {
    data(){
        return{
         errorrMsg:""   
        }
    },

    created(){
      if(this.$route.query.payment_type == "bkash")  {
        this.errorrMsg = "Bkash Payment has been <strong>failed! </strong>Try again"
      }

      if(this.$route.query.payment_type == "upay" && this.$route.query.status == undefined)  {
        this.errorrMsg = "Upay Payment has been <strong>failed! </strong>Try again"
      }

      if(this.$route.query.payment_type == "upay" && this.$route.query.status == "expired")  {
        this.errorrMsg = "Session expired! Upay Payment has been <strong>failed! </strong>Try again"
      }

      if(this.$route.query.payment_type == "nagad")  {
        this.errorrMsg = "Nagad Payment has been <strong>failed! </strong>Try again"
      }

      if(this.$route.query.payment_type == "aamarpay")  {
        this.errorrMsg = "Aamarypay Payment has been <strong>failed! </strong>Try again"
      }

      if(this.$route.query.txrID == "null")  {
        this.errorrMsg = "Insufficient Balance! But Your order is placed with unpaid"
      }
    }
}
</script>