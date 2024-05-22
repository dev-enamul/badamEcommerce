import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

const i18n = new VueI18n({
    locale: 'en',
    fallbackLocale: 'en',
    silentTranslationWarn: true
})
const loadedLanguages = []

function setI18nLanguage (lang,data) {
    
    loadedLanguages.push(lang)

    i18n.locale = lang
    i18n.setLocaleMessage(lang, data)

    // document.querySelector('html').setAttribute('lang', lang)
    // return lang
}

async function loadLanguageAsync (lang) {
    if (loadedLanguages.includes(lang)) {
        if (i18n.locale !== lang) setI18nLanguage(lang)
        return Promise.resolve()
    }
    const response = await axios.get(`/api/v1/locale/${lang}`)
    if (response.status === 200) {
        setI18nLanguage(lang,response.data)
    }
}

export {
    i18n, setI18nLanguage, loadLanguageAsync
}
