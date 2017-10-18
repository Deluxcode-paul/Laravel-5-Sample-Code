<template>
    <div class="listing">
        <div class="site-width">

            <div class="listing__spacer ajax-section with-transparency" :class="loading ? 'is-loading' : ''">
                <aside class="listing__aside">
                    <filters :filters="parameters" :is_open="filtersOpen"></filters>
                </aside>
                <div class="listing__container">
                    <div class="listing__panel">
                        <button class="listing__filters-btn btn is-purple j-show-filters">FILTER</button>
                        <sort-by :sort="sort" :_key="sort.key"></sort-by>
                        <page-size :size="pageSize"></page-size>
                    </div>
                    <div class="listing__content">
                        <ul class="grid">
                            <item v-for="item in items" :item="item"></item>
                        </ul>
                        <div class="no-results" v-if="!items.length">
                            <h2 class="no-results__title">{{ trans.no_results.heading }}</h2>
                            <div class="no-results__suggestions">
                                <strong>{{ trans.no_results.title_suggestions }}</strong>
                                <ul>
                                    <li v-for="suggestion in trans.no_results.suggestions">{{ suggestion }}</li>
                                    <li>
                                        <a :href="noResults.postRequest" target="_blank">{{ trans.request_link }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="separator"></div>
                            <div class="no-results__top" v-if="noResults.itemsFeatured.length">
                                <strong>{{ trans.title_featured }}</strong>
                                <ul class="grid">
                                    <item v-for="item in noResults.itemsFeatured" :item="item"></item>
                                </ul>
                                <div class="a-center">
                                    <a :href="noResults.viewAll" class="btn is-brown">{{ trans.view_all }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="listing__pager" v-if="pager">
                        <div class="separator"></div>
                        <div class="listing__panel">
                            <div class="js-pager" v-html="pager" @click.prevent="changePage"></div>
                            <page-size :size="pageSize"></page-size>
                        </div>
                    </div>
                </div>
                <div class="preloader">
                    <div class="preloader__icon"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import SortBy from './toolbar/SortBy.vue'
    import PageSize from './toolbar/PageSize.vue'
    import item from './items/ItemArticle.vue'
    import filters from './filters/FiltersLifestyle.vue'

    export default {
        components: {
            SortBy,
            PageSize,
            filters,
            item
        },
        data() {
            return {filtersOpen: false}
        },
        computed: {
            // 1st lvl properties
            loading() {return this.$store.state.loading;},
            data() {return this.$store.state.data;},
            trans() {return this.$store.state.trans;},

            // 2nd lvl properties
            items() {return this.data.items;},
            parameters() {return this.data.parameters;},
            pageSize() {return this.data.pageSize;},
            pager() {return this.data.pager;},
            sort() {return this.data.sort;},
            noResults() {return this.data.noResults;}
        },
        created() {
        },
        mounted() {
            // const self = this,
            //     $el = $(self.$el);
        }
    }
</script>
