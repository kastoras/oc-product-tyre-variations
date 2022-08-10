export default new Vuex.Store({
    state: {
        selected_tyre_variation: '',
        basic_url_data:''
    },
    getters: {
        getSelectedVariation: state => { return state.selected_tyre_variation },
        getBasicUrlData: state      => { return state.basic_url_data },
    },
    mutations: {
        setSelectedVariation(state, tyreVariation) {
            state.selected_tyre_variation = tyreVariation;
        },
        setBasicUrlData(state, basicUrlData){
            state.basic_url_data = basicUrlData;
        }   
    }
});