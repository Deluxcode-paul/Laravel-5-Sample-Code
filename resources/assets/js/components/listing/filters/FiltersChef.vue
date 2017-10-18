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
                        <select :placeholder="$store.state.trans.placeholders.role" :data-placeholder="$store.state.trans.placeholders.role" :name="filters.role.key" v-model="selectedRoleId">
                            <option></option>
                            <option v-for="option, value in filters.role.all" :value="value">{{ option }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-item">
                    <label>{{ this.$store.state.trans.labels.location }}</label>
                    <div class="form-input">
                        <select :placeholder="$store.state.trans.placeholders.country" :data-placeholder="$store.state.trans.placeholders.country" :name="filters.country.key" v-model="selectedCountryId">
                            <option></option>
                            <option v-for="option, value in filters.country.all" :value="value">{{ option }}</option>
                        </select>
                    </div>
                    <div class="form-input" v-show="statesAvailable">
                        <select :placeholder="$store.state.trans.placeholders.state" :data-placeholder="$store.state.trans.placeholders.state" :name="filters.state.key" v-model="selectedStateId">
                            <option></option>
                            <option v-for="option, value in filters.state.all" :value="value">{{ option }}</option>
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
                selectedCountryId: '',
                isOpen: false
            }
        },
        computed: {
            statesAvailable() {
                return this.selectedCountryId == 1;
            },
            selectedStateId() {
                let selected = this.filters.state.selected;
                return selected ? Object.keys(selected)[0] : '';
            },
            selectedRoleId() {
                let selected = this.filters.role.selected;
                return selected || '';
            }
        },
        created() {
            this.selectedCountryId = Object.keys(this.filters.country.selected)[0];
        },
        mounted() {
            var self = this,
                $el = $(self.$el),
                $parent = $(self.$parent.$el),
                $select = $el.find('select'),
                query = {page: undefined};

            $select.select2({
                theme: 'basic is-white'
            }).on('change', function(e){
                if ($(e.target).attr('name') != self.filters.country.key) return;
                self.selectedCountryId = $(e.target).val();
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