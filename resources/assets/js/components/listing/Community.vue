<template>
    <div class="listing">
        <div class="site-width">
            <div class="listing__spacer ajax-section with-transparency" :class="loading ? 'is-loading' : ''">
                <div class="listing__toolbar">
                    <div class="switcher is-flexible is-brown with-dividers" v-show="keyword.selected == null">
                        <ul>
                            <li v-for="item, index in type.all">
                                <label class="switcher__item">
                                    <input :value="index" :name="type.key" :checked="type.selected == index" type="radio" @change="submitType(index)">
                                    <span class="switcher__title">{{ item }}</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <sort-by2 :sort="sort" v-show="keyword.selected == null"></sort-by2>
                    <div v-show="keyword.selected !== null" class="listing__found">
                        {{ data.resultsCount }} Search Results for "{{ keyword.selected }}"
                    </div>
                    <page-size :size="pageSize"></page-size>
                    <a :href="data.askUrl" class="btn is-purple">{{ trans.buttons.ask_a_question }}</a>
                </div>
                <div class="layout">
                    <aside class="listing__aside">
                        <div class="aside">
                            <section class="aside__section">
                                <h2 class="title">{{ trans.headings.popular_tags }}</h2>
                                <ul class="popular-tags">
                                    <li v-for="tag in data.popularTags"><a :href="tag.communitySearchUrl">{{ tag.title }}</a></li>
                                </ul>
                            </section>
                            <section class="aside__section">
                                <h2 class="title">{{ trans.headings.most_popular }}</h2>
                                <ul class="popular">
                                    <li class="popular__item" v-for="item in data.popularItems">
                                        <div class="wrap">
                                            <a class="img" :href="item.user.publicProfileUrl">
                                                <img :src="item.user.activityImage" :alt="item.user.fullName">
                                            </a>
                                            <div class="desc">
                                                <a :href="item.detailsUrl">
                                                    {{ item.title }}
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    </aside>
                    <div class="listing__container">
                        <div class="listing__content">
                            <ul>
                                <item v-for="item in items" :item="item"></item>
                            </ul>
                            <div class="no-results" v-if="!items.length">
                                <h2 class="no-results__title">{{ trans.no_results.heading }} <span v-if="keyword.selected">{{ trans.no_results.heading_for }} "{{ keyword.selected }}"</span></h2>
                                <div class="no-results__suggestions">
                                    <strong>{{ trans.no_results.title_suggestions }}</strong>
                                    <ul>
                                        <li v-for="suggestion in trans.no_results.suggestions">{{ suggestion }}</li>
                                    </ul>
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
    </div>
</template>

<script>

    import SortBy2 from './toolbar/SortBy2.vue';
    import PageSize from './toolbar/PageSize.vue';
    import ItemActivity from './items/ItemActivity.vue';

    export default {
        components: {
            SortBy2,
            PageSize,
            item: ItemActivity
        },
        computed: {
            // 1st lvl properties
            trans() {return this.$store.state.trans;},
            data() {return this.$store.state.data;},
            loading() {return this.$store.state.loading;},

            // 2nd lvl properties
            // noResults() {return this.data.noResults;},
            pageSize() {return this.data.pageSize;},
            sort() {return this.data.sort;},
            parameters() {return this.data.parameters;},
            type() {return this.parameters.type;},
            items() {return this.data.items;},
            pager() {return this.data.pager;},
            keyword() {return this.parameters.keyword;}
        },
        methods: {
            submitType(value){
                var self = this,
                    $el = $(self.$el),
                    query = {page: undefined};

                query[self.type.key] = value;

                self.$router.push({
                    path: self.$route.fullPath,
                    query
                });
            }
        }
    }
</script>
