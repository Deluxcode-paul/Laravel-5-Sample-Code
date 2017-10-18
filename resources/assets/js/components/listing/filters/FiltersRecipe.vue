<template>
    <form id="js-list-form" class="form form-listing form-filters-recipe box js-list-form" :class="isOpen ? 'is-open' : ''">
        <div class="form-listing__wrap">
            <div class="form-row">
                <div class="form-listing__title-wrap">
                    <h3 class="form-listing__title">{{ trans.sidebar_title }}</h3>
                    <button class="form-listing__close j-hide-filters" @click.prevent="isOpen = !isOpen"></button>
                </div>
                <div class="form-listing__actions">
                    <div class="switcher is-flexible is-brown with-dividers">
                        <ul>
                            <li v-for="item in preferences">
                                <label class="switcher__item">
                                    <input :class="item.dependent ? 'is-dependent' : 'not-dependent'" :data-id="item.index" :value="item.index" :name="filters.preferences.key + '[]'" :checked="activePreference == item.index" type="radio" @change="submit(item.index)">
                                    <span class="switcher__title">{{ item.label }}</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn is-purple uppercase" @click.prevent="submit">{{ trans.apply_filters }}</button>
                        <a href="javascript:;" class="link-reset" @click.prevent="clearAllFilters">{{ trans.clear_filters }}</a>
                    </div>
                </div>
            </div>

            <!-- INGREDIENTS -->
            <div class="form-row ingredients">
                <h4>{{ trans.ingredients }}</h4>
                <div class="form-row">
                    <autocomplete :placeholder="trans.search_ingredients" :source="data.ingredients" :filter="filters.ingredientsWith" :no_results="trans.search_ingredients_empty" :label="filters.ingredientsWith.label"></autocomplete>
                </div>
                <div class="form-row">
                    <autocomplete :placeholder="trans.search_ingredients" :source="data.ingredients" :filter="filters.ingredientsWithout" :no_results="trans.search_ingredients_empty" :label="filters.ingredientsWithout.label"></autocomplete>
                </div>
            </div>
            <!-- END INGREDIENTS -->

            <!-- CHEFS -->
            <div class="form-row chefs">
                <h4>{{ filters.chefs.label || filters.chefs.title }}</h4>
                <div class="form-row">
                    <autocomplete :placeholder="trans.search_chefs" :source="filters.chefs.ajaxUrl" :filter="filters.chefs" :no_results="trans.search_chefs_empty"></autocomplete>
                </div>
            </div>
            <!-- END CHEFS -->

            <!-- FEATURED -->
            <div class="form-row featured">
                <checkbox :dependent="filters.featured.dependent" :label="filters.featured.all[1]" :group_key="filters.featured.key" :is_checked="filters.featured.selected" :multiple="filters.featured.multiple"></checkbox>
            </div>
            <!-- END FEATURED -->

            <!-- CHECKBOX GROUPS -->
            <div class="checkbox-groups form-row">
                <checkbox-group v-for="group_name in checkboxGroups" :group_name="group_name" :min="4"></checkbox-group>
            </div>
            <!-- END CHECKBOX GROUPS -->

            <div class="form-row">
                <div class="form-actions">
                    <button type="submit" class="btn is-purple uppercase" @click.prevent="submit">{{ trans.apply_filters }}</button>
                    <a href="javascript:;" class="link-reset" @click.prevent="clearAllFilters">{{ trans.clear_filters }}</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import Autocomplete from './Autocomplete.vue'
    import Checkbox from './Checkbox.vue'
    import CheckboxGroup from './CheckboxGroup.vue'

    export default {
        props: ['filters'],
        data(){
            return {
                isOpen: false,
                checkboxGroups: ['allergens', 'blessingTypes', 'diets', 'holidays', 'categories', 'cookTimes', 'sources', 'cuisines']
            }
        },
        computed: {
            // 1st lvl properties
            data() {return this.$store.state.data;},
            trans() {return this.$store.state.trans;},
            loading() {return this.$store.state.loading;},

            parameters() {return this.data.parameters;},
            activePreference() {return this.parameters.activePreference;},
            preferences() {
                var arr = [{
                    index: 'all',
                    label: this.filters.preferences.all['all']
                }];
                for (var index in this.filters.preferences.all) {
                    if (index == 'all') continue;
                    arr.push({
                        index: index,
                        label: this.filters.preferences.all[index]
                    });
                }
                return arr;
            }
        },
        components: {
            Checkbox,
            CheckboxGroup,
            Autocomplete
        },
        methods: {
            submit(pref, event) {
                var self = this,
                    $form = $(self.$el),
                    sort = self.data.sort,
                    keyword = self.data.keyword,
                    query = {page: undefined},
                    formSerialize = typeof(pref) == 'string' ? $form.find('input.not-dependent').serialize() : $form.find('input').serialize();

                query[sort.key] = self.$route.query[sort.key];

                if (keyword) query[keyword.key] = self.$route.query[keyword.key];

                self.$router.push({
                    path: self.$route.path + '?' + decodeURIComponent(formSerialize + '&' + self.data.secondary + '=on'),
                    query
                });
                self.isOpen = false;
            },
            clearAllFilters() {
                var self = this,
                    $form = $(self.$el);

                $form.find('input[type="checkbox"]').prop('checked', false);
                $form.find('.list-selected-multiple input[type="hidden"]').remove();
                self.submit(self.activePreference);
            }
        },
        mounted() {
            var self = this,
                $el = $(self.$el),
                $parent = $(self.$parent.$el);

            var $openFilters = $parent.find('.j-show-filters');

            $openFilters.on('click', function() {
                self.isOpen = !self.isOpen;
            });
        }
    }
</script>