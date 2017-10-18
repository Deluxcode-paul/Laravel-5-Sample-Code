<template>
    <div class="form-row filter-group" :class="['filter-group-' + group_name, is_open ? 'is-open' : '']" v-if="isAvailable">
        <h4>
            <a href="javascript:;" class="opener" @click="is_open = !is_open">{{ filter.label || filter.title }}</a>
        </h4>
        <transition name="slide-fade">
            <div class="slide" v-show="is_open">
                <div class="preference-block" v-for="label, id in allowedPreferences" :class="'preference-block-' + id" v-if="!!isDependent ? activePreference == id : true">
                    <checkbox v-for="checkbox, index in elements[0]" :dependent="filter.dependent" :multiple="filter.multiple" :group_key="filter.key" :index="index" :label="checkbox" :is_checked="!!filter.selected[index]"></checkbox>
                    <div class="checkbox-group__more" v-show="show_more">
                        <checkbox v-for="checkbox, index in elements[1]" :dependent="filter.dependent" :multiple="filter.multiple" :group_key="filter.key" :index="index" :label="checkbox" :is_checked="!!filter.selected[index]"></checkbox>
                    </div>
                    <div>
                        <a href="javascript:;" class="link-more" v-if="Object.keys(elements[1]).length" @click="show_more = !show_more">
                            <span v-if="!show_more">{{ $store.state.trans.view_more }}</span>
                            <span v-if="show_more">{{ $store.state.trans.view_less }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import Checkbox from './Checkbox.vue'

    export default {
        props: ['group_name', 'min'],
        components: {Checkbox},
        data() {
            return {
                show_more: false,
                is_open: false
            }
        },
        created() {
            if (this.hasSelected) this.is_open = true;
        },
        mounted() {
            var self = this,
                $el = $(self.$el);

            self.show_more = !!$el.find('.checkbox-group__more input:checked').length;
        },
        computed: {
            preferences() {
                return this.$store.state.data.parameters.preferences;
            },
            filter() {
                var self = this;
                return self.$store.state.data.parameters[self.group_name];
            },
            isDependent() {
                return this.filter.dependent;
            },
            allowedPreferences() {
                var self = this;
                return self.isDependent ? self.preferences.all : {all: self.preferences.all.all};
            },
            activePreference() {
                return this.$store.state.data.parameters.activePreference;
            },
            currentFilter() {
                var self = this;
                return self.filter[self.isDependent ? self.activePreference : 'all'];
            },
            hasSelected() {
                return !!Object.keys(this.filter.selected).length;
            },
            elements() {
                var self = this,
                    index = 0,
                    min = self.min || 4,
                    elements = [{}, {}],
                    input = self.currentFilter;

                $.each(input, function(key, value){
                    elements[index < min ? 0 : 1][key] = value;
                    index++;
                });
                return elements;
            },
            isAvailable(){
                var self = this;

                if (!self.isDependent) return true;

                return self.currentFilter ? !!Object.keys(self.currentFilter).length : false;
            }
        },
        watch: {
            filter() {
                if (!this.hasSelected) {
                    this.show_more = false;
                    this.is_open = false;
                }
            }
        },
        template: `
        <div class="checkbox-group">
            <checkbox v-for="filter, index in elements[0]" :group_key="filter.key" :index="index" :label="filter" :is_checked="!!filter.selected[index]"></checkbox>
            <div class="checkbox-group__more" v-show="show_more">
                <checkbox v-for="filter, index in elements[1]" :group_key="filter.key" :index="index" :label="filter" :is_checked="!!filter.selected[index]"></checkbox>
            </div>
            <a href="javascript:;" class="link-more" v-if="!show_more && Object.keys(elements[1]).length" @click="showMore">{{ $store.state.trans.view_more }}</a>
        </div>
        `
    }
</script>