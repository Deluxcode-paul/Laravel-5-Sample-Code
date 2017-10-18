<template>
    <div class="listing">
        <div class="site-width">
            <ul class="search-tabs">
                <li v-for="item in tabs">
                    <a :href="item.url" :class="item.isActive ? 'is-active' : ''">
                        {{ item.title }} <span class="count">({{ item.isActive ? resultsCount : item.count }})</span>
                    </a>
                </li>
            </ul>
            <div class="listing__spacer ajax-section with-transparency" :class="loading ? 'is-loading' : ''">
                <aside class="listing__aside">
                    <filters :filters="parameters"></filters>
                </aside>
                <div class="listing__container">
                    <div class="listing__panel">
                        <button class="listing__filters-btn btn is-purple j-show-filters">FILTER</button>
                        <sort-by :sort="sort" :_key="sort.key"></sort-by>
                        <page-size :size="pageSize"></page-size>
                    </div>
                    <selected-filters :parameters="parameters"></selected-filters>
                    <div class="listing__content">
                        <ul class="grid">
                            <item v-for="item in items" :item="item"></item>
                        </ul>
                        <div class="no-results" v-if="!items.length">
                            <h2 class="no-results__title">{{ trans.no_results.heading }} <span v-if="$store.state.data.keyword.selected">{{ trans.no_results.heading_for }} "{{ $store.state.data.keyword.selected }}"</span></h2>
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
    import SelectedFilters from './toolbar/SelectedFilters.vue'
    import SearchHeading from './heading/SearchHeading.vue'

    export default {
        components: {
            SortBy,
            PageSize,
            SelectedFilters,
            SearchHeading
        },
        computed: {
            // 1st lvl properties
            data() {return this.$store.state.data;},
            trans() {return this.$store.state.trans;},
            loading() {return this.$store.state.loading;},

            // 2nd lvl properties
            resultsCount() {return this.data.resultsCount;},
            tabs() {return this.data.tabs;},
            noResults() {return this.data.noResults;},
            pageSize() {return this.data.pageSize;},
            sort() {return this.data.sort;},
            parameters() {return this.data.parameters;},
            items() {return this.data.items;},
            pager() {return this.data.pager;}
        }
    }
</script>