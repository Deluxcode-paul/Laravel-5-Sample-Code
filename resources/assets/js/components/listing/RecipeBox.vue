<template>
    <div class="profile-listing">
        <div spacer class="ajax-section with-transparency" :class="loading ? 'is-loading' : ''">
            <div class="profile-listing__container">
                <div class="profile-listing__panel">

                    <div class="profile-listing__search">
                        <form class="form form-search-recipe-box js-form" id="js-form-search-recipe-box" @submit.prevent="submit">
                            <div class="form-input">
                                <input type="text" :name="keyword.key" v-model="keywordValue" :placeholder="trans.placeholders.search">
                                <button type="submit" class="btn-submit" @submit.prevent="submit">
                                    <svg class="icon icon-search" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="446.25px" height="446.25px" viewBox="0 0 446.25 446.25">
                                        <path d="M318.75,280.5h-20.4l-7.649-7.65c25.5-28.05,40.8-66.3,40.8-107.1C331.5,73.95,257.55,0,165.75,0S0,73.95,0,165.75    S73.95,331.5,165.75,331.5c40.8,0,79.05-15.3,107.1-40.8l7.65,7.649v20.4L408,446.25L446.25,408L318.75,280.5z M165.75,280.5    C102,280.5,51,229.5,51,165.75S102,51,165.75,51S280.5,102,280.5,165.75S229.5,280.5,165.75,280.5z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <page-size :size="pageSize"></page-size>
                </div>
                <div class="profile-listing__content">
                    <ul class="grid" v-if="items.length">
                        <item v-for="item in items" :item="item"></item>
                    </ul>
                    <div class="profile-listing__no-results" v-if="!items.length">
                        <i>{{ data.emptyMsg || 'Sorry, no results were found' }}</i>
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

    import item from './items/ItemRecipe.vue';
    import PageSize from './toolbar/PageSize.vue';

    export default {
        components: {
            item,
            PageSize
        },
        data() {
            return {
                keywordValue: ''
            }
        },
        computed: {
            // 1st lvl properties
            loading() {return this.$store.state.loading;},
            data() {return this.$store.state.data;},
            trans() {return this.$store.state.trans;},

            // 2nd lvl properties
            items() {return this.data.items;},
            parameters() {return this.data.parameters;},
            pager() {return this.data.pager;},
            pageSize() {return this.data.pageSize;},
            keyword() {return this.parameters.keyword;}
        },
        created() {
            var self = this;

            self.keywordValue = self.keyword.selected || '';
        },
        watch: {
            keyword() {
                var self = this;
                self.keywordValue = self.keyword.selected || '';
            }
        },
        mounted() {
            // var self = this,
            //     $el = $(self.$el);
        },
        methods: {
            submit() {
                var self = this,
                    $el = $(self.$el),
                    $form = $el.find('#js-form-search-recipe-box'),
                    query = {page: undefined};

                query[self.keyword.key] = $form.find('input[name="' + self.keyword.key + '"]').val();

                self.$router.push({
                    path: self.$route.fullPath,
                    query
                });
            }
        }
    }
</script>