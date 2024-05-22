<template>
    <div>
        <form :action="'/social-login/redirect/'+selectedsocialOption" ref="socialLoginForm" method="POST">
            <input type="hidden" name="redirect_to" :value="$route.path">
        </form>
        <button class="lh-0 me-3" @click="socialAuth('facebook')" v-if="generalSettings.social_login.facebook == 1">
            <img :src="socialIcons.facebook" alt="">
        </button>
        <button class="lh-0 me-3" @click="socialAuth('twitter')" v-if="generalSettings.social_login.twitter == 1">
            <img :src="socialIcons.twitter" alt="">
        </button>
        <button class="lh-0" @click="socialAuth('google')" v-if="generalSettings.social_login.google == 1">
            <img :src="socialIcons.google" alt="">
        </button>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data: () => ({
        selectedsocialOption: null,
        socialIcons: {
            facebook: Vue.helpers.asset("/assets/img/icons/facebook.svg"),
            twitter: Vue.helpers.asset("/assets/img/icons/twitter.svg"),
            google: Vue.helpers.asset("/assets/img/icons/google.svg"),
        },
    }),
    computed:{
        ...mapGetters('app',[
            'appUrl',
            'generalSettings'
        ])
    },
    methods:{
        socialAuth(provider){
            this.selectedsocialOption = provider
            let self = this
            setTimeout(function(){
                self.$refs.socialLoginForm.submit()
            }, 300)
        }
    }
}
</script>