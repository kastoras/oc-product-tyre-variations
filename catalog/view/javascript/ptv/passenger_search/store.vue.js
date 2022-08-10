export default new Vuex.Store({
    state: {
        basic_url_data: {},
        selected_values: {
            width: '',
            height: '',
            diameter: '',
        },
    },
    getters: {
        getBasicUrlData: state => { return state.basic_url_data },
        getSelectedValues: state => { return state.selected_values }
    },
    mutations: {
        setBasicUrlData(state, basicUrlData) {
            state.basic_url_data = basicUrlData;
        },        
        setSelectedValues(state, selectedValues) {
            state.selected_values = selectedValues;
        }
    }
});