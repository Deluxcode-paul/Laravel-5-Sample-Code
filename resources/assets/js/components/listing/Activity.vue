<template>
    <div class="profile-listing">
        <div spacer class="ajax-section with-transparency" :class="loading ? 'is-loading' : ''">
            <div class="profile-listing__container">
                <div class="profile-listing__panel">
                    <nav class="nav-activity switcher is-flexible is-brown with-dividers">
                        <ul>
                            <li v-for="item in nav">
                                <a :href="item.url" class="switcher__item" :class="isActive(item.url) ? 'is-active' : ''">
                                    <span class="switcher__title">{{ item.title }}</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <sort-by2 :sort="sort"></sort-by2>
                </div>
                <div class="profile-listing__content">
                    <ul v-if="items.length">
                        <item v-for="item in items" :item="item"></item>
                    </ul>
                    <div class="profile-listing__no-results" v-if="!items.length">
                        <i>{{ data.emptyMsg }}</i>
                    </div>
                </div>
                <div class="profile-listing__pager" v-if="pager">
                    <div class="separator"></div>
                    <div class="profile-listing__panel">
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

    import item from './items/ItemActivity.vue';
    import SortBy2 from './toolbar/SortBy2.vue';
    import PageSize from './toolbar/PageSize.vue';

    export default {
        components: {
            item,
            SortBy2,
            PageSize
        },
        computed: {
            // 1st lvl properties
            loading() {return this.$store.state.loading;},
            data() {return this.$store.state.data;},
            trans() {return this.$store.state.trans;},

            // 2nd lvl properties
            items() {return this.data.items;},
            parameters() {return this.data.parameters;},
            sort() {return this.parameters.sort;},
            pager() {return this.data.pager;},
            pageSize() {return this.data.pageSize;},
            nav() {return this.data.nav;}
        },
        created() {
        },
        mounted() {
            // var self = this,
            //     $el = $(self.$el);
        },
        methods: {
            isActive(url) {return url.indexOf(this.$route.path) > -1;}
        }
    }
</script>