<template>
    <div class="listing">
        <div class="ajax-section with-transparency" :class="loading ? 'is-loading' : ''">
            <div class="listing__container">
                <div class="listing__panel">
                    <sort-by2 :sort="sort"></sort-by2>
                    <page-size :size="pageSize"></page-size>
                </div>
                <div class="listing__content">
                    <ul>
                        <item v-for="item in items" :item="item"></item>
                    </ul>
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
</template>

<script>

    import SortBy2 from './toolbar/SortBy2.vue'
    import PageSize from './toolbar/PageSize.vue'
    import item from './items/ItemActivity.vue'

    export default {
        components: {
            SortBy2,
            PageSize,
            item
        },
        computed: {
            // 1st lvl properties
            loading() {return this.$store.state.loading;},
            data() {return this.$store.state.data;},
            trans() {return this.$store.state.trans;},

            // 2nd lvl properties
            parameters() {return this.data.parameters;},
            sort() {return this.parameters.sort;},
            items() {return this.data.items;},
            pageSize() {return this.data.pageSize;},
            pager() {return this.data.pager;},
            noResults() {return this.data.noResults;}
        }
    }
</script>