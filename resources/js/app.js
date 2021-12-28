require('./bootstrap');

import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import store from './vuex/store'

InertiaProgress.init()

import Vuetify from 'vuetify'
import pt from 'vuetify/lib/locale/pt'
import 'vuetify/dist/vuetify.min.css'

import LayoutDefault from './Layouts/LayoutDefault'
import { Link } from '@inertiajs/inertia-vue'



Vue.component('Link', Link)

const vuetifyConfig = {
    lang: {
        locales: { pt },
        current: 'pt',
    },
    theme: {
        themes: {
            light: {
                primary: '#28783B',
                secondary: '#7FBF50',
                accent: '#8c9eff',
                error: '#EF5350',
            },
        },
    },
}

const optionSweetAlert = {
    confirmButtonColor: vuetifyConfig.theme.themes.light.primary,
    cancelButtonColor: '#ff7674',
};

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2, optionSweetAlert);

Vue.prototype.$route = route

Vue.use(Vuetify)

import { format, parseISO } from 'date-fns'

Vue.mixin({
    computed: {
        isMobile() {
            return this.$vuetify.breakpoint.sm
        },
        roles() {
            return this.$page.props.auth.roles
                .map((r) => r.name.toUpperCase())
                .join(", ");
        },
        user() {
            return this.$page.props.auth.user;
        },
    },

    filters: {
        formatDate(value) {
            const date = parseISO(value)
            return format(date, 'dd/MM/yyyy')
        },
    },

    methods: {
        canRole(roles) {
            return ['administrador'].some(r => roles.indexOf(r) >= 0);
        },
    }
})

createInertiaApp({

    resolve: name => {
        const page = require(`./Pages/${name}`).default
        page.layout = page.layout || LayoutDefault
        return page
    },
    setup({ el, App, props }) {
        new Vue({
            render: h => h(App, props),
            vuetify: new Vuetify(vuetifyConfig),
            store: store
        }).$mount(el)
    },
})
