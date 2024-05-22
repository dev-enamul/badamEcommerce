<template>
    <div>
        <v-overlay :value="checkoutLoading" z-index="99999">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
export default {
    data(){
        return{
            checkoutLoading:true
        }
    },

    created(){
        this.executePayment()
    },

    methods:{
        async executePayment(){
            let paymentID = this.$route.query.paymentID;
            const res = await this.call_api('post', 'bkash/execute-payment', {
                paymentID:paymentID
            })
            // success?payment_type=bkash
            console.log('execute payment', res);
    
            if(res.data.statusMessage == "Successful"){
                this.$router
                .push({
                    name: "OrderConfirmed",
                    query: { orderCode: res.data.merchantInvoiceNumber },
                })
            }

            if(res.data.txrID == null  || res.data.txrID == undefined || res.data.txrID == 'undefined'){
               
              window.location.href = window.location.origin+'/failed?txrID=null' 

            }
        }
    }
}
</script>