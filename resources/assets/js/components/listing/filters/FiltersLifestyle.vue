<template>
    <form id="js-list-form" class="form form-listing form-filters-lifestyle box js-list-form" :class="isOpen ? 'is-open' : ''">
        <div class="form-listing__wrap">
            <div class="form-row">
                <div class="form-listing__title-wrap">
                    <h3 class="form-listing__title">{{ $store.state.trans.sidebar_title }}</h3>
                    <button class="form-listing__close j-hide-filters" @click.prevent="isOpen = !isOpen"></button>
                </div>
            </div>
            <div class="form-row">
                <div class="form-item">
                    <label>Filter:</label>
                    <div class="form-input">
                        <select :placeholder="$store.state.trans.placeholders.categories" :data-placeholder="$store.state.trans.placeholders.categories" :name="filters.category.key" data-allow-clear="true">
                            <option></option>
                            <option v-for="option, value in filters.category.all" :value="value" :selected="!!filters.category.selected[value]">{{ option }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-item">
                    <label>Archives:</label>
                    <div class="form-input">
                        <select :placeholder="$store.state.trans.placeholders.year" :data-placeholder="$store.state.trans.placeholders.year" :name="filters.year.key" data-allow-clear="true">
                            <option></option>
                            <option v-for="option, value in filters.year.all" :value="value" :selected="!!filters.year.selected[value]">{{ option }}</option>
                        </select>
                    </div>
                    <div class="form-input">
                        <select :placeholder="$store.state.trans.placeholders.month" :data-placeholder="$store.state.trans.placeholders.month" :name="filters.month.key" data-allow-clear="true">
                            <option></option>
                            <option v-for="option, value in filters.month.all" :value="value" :selected="!!filters.month.selected[value]">{{ option }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-actions">
                    <button type="submit" class="btn is-purple uppercase" @click.prevent="submit">{{ $store.state.trans.apply_filters }}</button>
                    <a href="javascript:;" class="link-reset" @click.prevent="clearAllFilters">{{ $store.state.trans.clear_filters }}</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        computed: {
            // 1st lvl properties
            loading() {return this.$store.state.loading;},
            data() {return this.$store.state.data;},
            trans() {return this.$store.state.trans;}
        },
        props: ['filters'],
        data() {
            return {
                isOpen: false
            }
        },
        mounted() {
            var self = this,
                $el = $(self.$el),
                $parent = $(self.$parent.$el),
                $select = $el.find('select'),
                query = {page: undefined};

            $select.select2({
                theme: 'basic is-white'
            });

            var $openFilters = $parent.find('.j-show-filters');

            $openFilters.on('click', function() {
                self.isOpen = !self.isOpen;
            });
        },
        methods: {
            submit() {
                var self = this,
                    $el = $(self.$el),
                    sort = self.data.sort,
                    keyword = self.data.keyword,
                    query = {page: undefined},
                    formSerialize = $el.find('input, select').serialize();

                query[sort.key] = self.$route.query[sort.key];

                if (keyword) query[keyword.key] = self.$route.query[keyword.key];

                self.$router.push({
                    path: self.$route.path + '?' + decodeURIComponent(formSerialize),
                    query
                });
                self.isOpen = false;
            },
            clearAllFilters() {
                var self = this,
                    $el = $(self.$el);

                $el.find('select').val('').trigger('change');
                self.submit();
            }
        }
    }
</script>