import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        toast: {
            show: false,
            text: 'text default',
            type: 'success',
            timeout: 2000
        }
    },
    mutations: {
        UPDATE_TOAST(state, toast) {
            state.toast.show = toast.show ?? false
            state.toast.text = toast.text ?? 'text default'
            state.toast.type = toast.type ?? 'success'
            state.toast.timeout = toast.timeout ?? 2000
        }
    },

    getters: {
        toast: state => state.toast
    }
})

export default store
