<template>
    <v-dialog
        v-model="dialog"
        :max-width="options.width"
        :style="{ zIndex: options.zIndex }"
        @keydown.esc="cancel"
    >
        <v-card>
            <v-toolbar :color="options.color" dense flat>
                <v-toolbar-title class="">{{ $t('change_language') }}</v-toolbar-title>
            </v-toolbar>
            <v-card-text class="pa-4 black--text">
                <v-radio-group v-model="selectedCode">
                    <v-radio
                        v-for="(language, i) in  allLanguages"
                        on-icon="la-dot-circle"
                        off-icon="la-circle ts-06 opacity-50"
                        :key="i"
                        :value="language.code"
                    >
                        <template v-slot:label>
                            <span class="fs-14">{{ language.name }}</span>
                        </template>
                    </v-radio>
                </v-radio-group>
            </v-card-text>
            <v-card-actions class="pt-3">
                <v-spacer></v-spacer>
                <v-btn
                    v-if="!options.noconfirm"
                    color="grey darken-3"
                    text
                    class=""
                    @click.native="cancel"
                >{{ $t('cancel') }}</v-btn>
                <v-btn
                    color="primary"
                    elevation="0"
                    @click.native="agree"
                >{{ $t('Update') }}</v-btn
            ></v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapGetters,mapActions } from "vuex";
export default {
    name: "ConfirmDialog",
    data() {
        return {
            dialog: false,
            selectedCode: null,
            options: {
                color: "grey lighten-3",
                width: 400,
                zIndex: 615,
                noconfirm: false,
            },
        };
    },
    computed:{
        ...mapGetters("app",[
            "userLanguageObj",
            "allLanguages"
        ]),
    },
    methods: {
        ...mapActions("app",[
            "setLanguage",
        ]),
        open() {
            this.selectedCode = this.userLanguageObj.code
            this.dialog = true;
        },
        agree() {
            if(this.$i18n.locale !== this.selectedCode){
                this.setLanguage(this.selectedCode)
                window.location.reload();
            }
        },
        cancel() {
            this.dialog = false;
        },
    },
};
</script>