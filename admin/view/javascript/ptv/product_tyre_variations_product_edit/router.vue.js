import TyreVariationTable from './components/tyre-variation-table.vue.js';
import TyreVariationEditForm from './components/tyre-variation-edit-form.vue.js';
import TyreVariationAddForm from './components/tyre-variation-add-form.vue.js';

export default new VueRouter({
    routes : [
        {
            path:'/',
            component:TyreVariationTable
        }, 
        {
            path:'/edit-variation',
            component:TyreVariationEditForm
        }, 
        {
            path:'/add-variation',
            component:TyreVariationAddForm
        },            
    ]
})