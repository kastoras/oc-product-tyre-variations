export default Vue.component('radio-button-img',{
    template: `
        <div class="radio-selector">
            <a v-for="option in radio_options" v-bind:class="{ active: (active_option == option.id)}" v-on:click="selectRadio(option.id)" >
                <span v-if="option.label !== ''">{{option.label}}</span>
                <span v-else>
                    <span v-if="option.id==active_option">
                        <img :src="option.image.active" />
                    </span>
                    <span v-else>
                        <img :src="option.image.inactive" />
                    </span>
                </span>
            </a>
            <input type="hidden" name="season" v-model="active_option" />
        </div>
    `,
    data(){
        return {
            radio_options:[
                {
                    id:'all',
                    label: 'All',
                    image: {},
                    is_active: true
                },
                {
                    id: 'summer',
                    label: '',
                    image: {
                        inactive: this.$store.getters.getBasicUrlData.site_url+'/image/ptv/radio-button-images/sun.png',
                        active: this.$store.getters.getBasicUrlData.site_url+'/image/ptv/radio-button-images/sun-active.png'
                    },
                    is_active: false
                },                
                {
                    id: 'winter',
                    label: '',
                    image: {
                        inactive:this.$store.getters.getBasicUrlData.site_url+'/image/ptv/radio-button-images/snow.png',
                        active: this.$store.getters.getBasicUrlData.site_url+'/image/ptv/radio-button-images/snow-active.png'
                    },
                    is_active: false
                }
            ], 
            active_option: 'all',
            basic_url_data: ''
        }
    },
    methods: {
        selectRadio(option){
            this.active_option = option;
        }
    }
})