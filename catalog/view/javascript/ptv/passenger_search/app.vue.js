import store from './store.vue.js';

import SearchSelect from './components/search-select.vue.js';
import RadioButtonImg from './components/radio-button-img.vue.js';

new Vue({
    el: '#passenger-search',
    delimiters: ['${', '}'],
    components: {
        'search-select': SearchSelect,
        'radio-button-img': RadioButtonImg
    },
    store,
    data() {
        return {
        }
    },
    created() {
        this.storeBasicData();
    },
    methods: {
        storeBasicData() {            
            var url = new URL(window.location.href);
            this.$store.commit('setBasicUrlData', {
                site_url: url.href.split("index.php")[0]
            });
        }
    }

})