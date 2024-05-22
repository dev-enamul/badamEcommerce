import Vue from 'vue'
import helpers from '../utils/helpers'

export default {
    install: (Vue) => {
        Vue.helpers = helpers
        Vue.prototype.$helpers = helpers

        Vue.prototype.imageFallback = function(e,size = 'square') {
            e.target.src = helpers.imagePlaceholder(size);
        };
    }
}