import store  from './store.vue.js';
import router from './router.vue.js';


new Vue({
    el: '#tyre-variation-edit-feature',
    delimiters: ['${', '}'],
    store,
    router,
    data(){
        return {
        }
    },
    created(){
        this.storeBasicData();
    },
    methods:{
        storeBasicData(){
            var url = new URL(window.location.href);
            this.$store.commit('setBasicUrlData', {
                token : url.searchParams.get("user_token"),
                site_url : url.href.split("index.php")[0],
                product_id : url.searchParams.get("product_id")
            });
        }
    }

})