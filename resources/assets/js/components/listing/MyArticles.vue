<template>
    <div class="profile-listing">
        <div spacer class="ajax-section with-transparency" :class="loading ? 'is-loading' : ''">
            <div class="profile-listing__container">
                <div class="profile-listing__panel">
                    <a :href="data.manageUrl" class="btn is-purple" target="_blank">{{ trans.buttons.manage_articles }}</a>
                    <page-size :size="pageSize"></page-size>
                </div>
                <div class="profile-listing__content">
                    <ul class="grid">
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

    import item from './items/ItemArticle.vue';
    import PageSize from './toolbar/PageSize.vue';

    export default {
        components: {
            item,
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
            pager() {return this.data.pager;}
        },
        created() {
        },
        mounted() {
            // var self = this,
            //     $el = $(self.$el);
        }
    }
</script>