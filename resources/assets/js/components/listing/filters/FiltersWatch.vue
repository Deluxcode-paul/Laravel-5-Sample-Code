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
                        <select :placeholder="$store.state.trans.placeholders.owner_type" :data-placeholder="$store.state.trans.placeholders.owner_type" :name="filters.ownerType.key" v-model="selectedOwnerTypeId">
                            <option></option>
                            <option v-for="option, value in filters.ownerType.all" :value="value">{{ option }}</option>
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
        props: ['filters'],
        data() {
            return {
                isOpen: false
            }
        },
        computed: {
            selectedOwnerTypeId() {
                let selected = this.filters.ownerType.selected;
                return selected ? Object.keys(selected)[0] : '';
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
                    $form = $(self.$el),
                    sort = self.$store.state.data.sort,
                    keyword = self.$store.state.data.keyword,
                    query = {page: undefined},
                    formSerialize = $form.find('input, select:visible').serialize();

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
                    $form = $(self.$el);

                $form.find('select').val('').trigger('change');
                self.submit();
            }
        }
    }
</script>