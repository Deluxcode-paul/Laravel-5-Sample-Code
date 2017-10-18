
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import mixins from './vuejs/mixins.js';
import router from './vuejs/router.js';
import store from './vuejs/vuex/store.js';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the specified block on the page, named $app. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

var $app = $('#vue-app');

if ($app.length) {

    Vue.mixin(mixins);

    const vueStore = new Vuex.Store(store);
    const vueRouter = new VueRouter(router);

    window.app = new Vue({
        router: vueRouter,
        store: vueStore,
        watch: {
            '$route': 'fetchData'
        },
        created() {
            this.$store.commit('SET_DATA', json);
            this.$store.commit('SET_TRANS', trans);
        },
        methods: {
            fetchData() {
                var self = this;

                this.$store.commit('TOGGLE_LOADING', true);

                self.$http.get('/ajax' + self.$route.fullPath).then((response) => {

                    var responseBody = JSON.parse(response.body);

                     // Update global data fields
                    this.$store.commit('UPDATE_ITEMS', responseBody.items);
                    this.$store.commit('UPDATE_PARAMETERS', responseBody.parameters);
                    this.$store.commit('UPDATE_PAGER', responseBody.pager);
                    this.$store.commit('UPDATE_PAGESIZE', responseBody.pageSize);

                    // Update data fields if exist
                    if (responseBody.header) this.$store.commit('UPDATE_HEADER', responseBody.header);
                    if (responseBody.resultsCount) this.$store.commit('UPDATE_RESULTS_COUNT', responseBody.resultsCount);
                    if (responseBody.breadcrumbs) this.$store.commit('UPDATE_BREADCRUMBS', responseBody.breadcrumbs);

                    this.$store.commit('TOGGLE_LOADING', false);

                    Front.scrollTo($(this.$root.$el), {
                        forced: false
                    });

                }, (response) => {
                    // error callback

                    console.log('Ajax Error');
                    console.log(response);

                    this.$store.commit('TOGGLE_LOADING', false);
                });
            }
        }
    }).$mount('#vue-app');

}