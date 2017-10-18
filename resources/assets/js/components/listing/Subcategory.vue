<template>
    <div class="subcategory ajax-section with-transparency" :class="loading ? 'is-loading' : ''">
        <page-heading :heading0="trans.title_recipes" :heading1="this.$store.state.data.header" :bg="this.$store.state.data.header_bg"></page-heading>
        <div class="listing">
            <div class="site-width">
                <div class="listing__spacer">
                    <aside class="listing__aside">
                        <filters :filters="parameters"></filters>
                    </aside>
                    <div class="listing__container">
                        <div class="listing__panel">
                            <button class="listing__filters-btn btn is-purple j-show-filters">FILTER</button>
                            <div class="listing__sorting">
                                <sort-by :sort="sort" :_key="sort.key"></sort-by>
                            </div>
                            <page-size :size="pageSize"></page-size>
                        </div>
                        <selected-filters :parameters="parameters"></selected-filters>
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
                                            <a :href="noResults.postRequest" target="_blank">{{ trans.no_results.link }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="separator"></div>
                                <div class="no-results__top">
                                    <strong>{{ trans.title_featured }}</strong>
                                    <ul class="grid">
                                        <item v-for="item in noResults.itemsFeatured" :item="item"></item>
                                    </ul>
                                    <div class="a-center">
                                        <a :href="noResults.viewAll" class="btn is-brown">{{ trans.view_all_recipes }}</a>
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
                </div>
            </div>
        </div>
        <div class="preloader">
            <div class="preloader__icon"></div>
        </div>
    </div>
</template>

<script>

    import FiltersRecipe from './filters/FiltersRecipe.vue';
    import ItemRecipe from './items/ItemRecipe.vue';
    import SortBy from './toolbar/SortBy.vue';
    import PageSize from './toolbar/PageSize.vue';
    import SelectedFilters from './toolbar/SelectedFilters.vue';
    import PageHeading from './heading/PageHeading.vue';

    export default {
        components: {
            filters: FiltersRecipe,
            item: ItemRecipe,
            SortBy,
            PageSize,
            SelectedFilters,
            PageHeading
        },
        computed: {
            // 1st lvl properties
            trans() {return this.$store.state.trans;},
            data() {return this.$store.state.data;},
            loading() {return this.$store.state.loading;},

            // 2nd lvl properties
            noResults() {return this.data.noResults;},
            pageSize() {return this.data.pageSize;},
            sort() {return this.data.sort;},
            parameters() {return this.data.parameters;},
            items() {return this.data.items;},
            pager() {return this.data.pager;}
        }
    }
</script>
