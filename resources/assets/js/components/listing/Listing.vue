<template>
    <div class="listing site-width">
        <div class="listing__spacer ajax-section with-transparency" :class="loading ? 'is-loading' : ''">
            <div class="listing__container">
                <div class="listing__panel">
                    <sort-by :sort="sort" :_key="sort.key"></sort-by>
                    <page-size :size="pageSize"></page-size>
                </div>
                <div class="listing__content">
                    <ul class="grid">
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

    import SortBy from './toolbar/SortBy.vue'
    import PageSize from './toolbar/PageSize.vue'

    export default {
        components: {
            SortBy,
            PageSize
        },
        computed: {
            // 1st lvl properties
            loading() {return this.$store.state.loading;},
            data() {return this.$store.state.data;},
            trans() {return this.$store.state.trans;},

            // 2nd lvl properties
            items() {return this.data.items;},
            pageSize() {return this.data.pageSize;},
            pager() {return this.data.pager;},
            sort() {return this.data.sort;},
            noResults() {return this.data.noResults;}
        },
        created() {
        },
        mounted() {
            // var self = this,
            //     $el = $(self.$el);
        }
    }
</script>