<template>
    <div class="vue-autocomplete form-item">
        <label v-if="label">{{ label }}:</label>
        <div class="form-input vue-autocomplete__field">
            <input type="text" :placeholder="placeholder" v-model="searchValue">
            <transition name="fade">
                <div class="vue-autocomplete__dropdown" v-show="isOpen && searchValue.length">
                    <ul v-show="hasResults">
                        <li v-for="item in filteredData">
                            <a href="javascript:;" @click.prevent="addItem(item)">{{ item.value }}</a>
                        </li>
                    </ul>
                    <ul v-show="!hasResults && !isLoading">
                        <li><span>{{ no_results }}</span></li>
                    </ul>
                </div>
            </transition>
        </div>
        <ul class="list-selected-multiple">
            <li v-for="item, index in selected">
                <input type="hidden" :class="filter.dependent ? 'is-dependent' : 'not-dependent'" :name="filter.key + '[' + index + ']'" value="on">
                <a href="javascript:;" @click.prevent="removeItem(index, item)">{{ trans.remove }}</a>
                <span>{{ item }}</span>
            </li>
        </ul>
    </div>
</template>

<script>

    export default {
        props: ['placeholder', 'filter', 'source', 'title', 'no_results', 'label'],
        data() {
            var self = this,
                data = {
                    searchValue: '',
                    isOpen: false,
                    items: [],
                    selected: {},
                    ajax: false,
                    timer: null,
                    isLoading: false,
                    debounce: 400
                };

            if (typeof self.source == 'object') {
                $.each(self.source, function(id, value){
                    data.items.push({
                        id,
                        value
                    });
                });
            } else {
                data.ajax = true;
            }

            if (!self.filter.selected.length) {
                data.selected = $.extend({}, self.filter.selected);
            }

            return data;
        },
        computed: {
            trans() {return this.$store.state.trans;},
            filteredData(){
                var self = this;

                return self.items.filter(function(item){
                    return (!self.selected[item.id]) && (item.value.toLowerCase().indexOf(self.searchValue.toLowerCase().trim().replace(/ +(?= )/g,'')) !== -1);
                });
            },
            hasResults(){return !!this.filteredData.length;}
        },
        watch: {
            filter() {
                var self = this,
                    selected = self.filter.selected;

                self.selected = !selected.length ? $.extend({}, selected) : {};

                self.searchValue = '';
            },
            searchValue() {
                var self = this;

                if (!self.ajax) return;

                self.fetch(self.searchValue);
            }
        },
        mounted() {
            var self = this,
                $el = $(self.$el),
                $input = $el.find('input[type="text"]'),
                $dropdown = $el.find('.vue-autocomplete__dropdown');

            $dropdown[0].addEventListener('outclick', e => {
                self.isOpen = false;
            }, [$input[0]]);

            $input.on('focus', () => {
                self.isOpen = true;
            });
        },
        methods: {
            removeItem(id, value){
                var self = this,
                    $el = $(self.$el);

                Vue.delete(self.selected, id);
            },
            addItem(item){
                var self = this,
                    $el = $(self.$el);

                self.selected[item.id] = item.value;
                self.searchValue = '';
            },
            fetch(value){
                var self = this,
                    $el = $(self.$el),
                    results = [];

                clearTimeout(self.timer);

                self.isLoading = true;

                self.timer = setTimeout(function(){

                    if (value == '') {
                        self.items = [];
                        self.isLoading = false;
                        return;
                    }

                    self.$http.get(self.filter.ajaxUrl + value).then((response) => {
                        self.isLoading = false;
                        if (!$.isEmptyObject(response.body)) {
                            $.each(response.body, function(id, value){
                                results.push({
                                    id,
                                    value
                                });
                            });
                        }
                        self.items = results;
                    }, (response) => {
                        self.isLoading = false;
                    });
                }, self.debounce);
            },
            fetchData(event){
                let self = this,
                    $el = $(self.$el),
                    $dropdown = $el.find('.vue-autocomplete__dropdown'),
                    $input = $(event.target);

                clearTimeout(self.timer);

                self.timer = setTimeout(function(){

                    self.noResults = false;

                    if (!$input.val()) {
                        self.results = {};
                        return;
                    }

                    self.isLoading = true;

                    self.$http.get(self.url + $input.val()).then((response) => {
                        self.isLoading = false;
                        if (!$.isEmptyObject(response.body)) {
                            self.results = response.body;
                            $dropdown.addClass('is-open');
                        } else {
                            self.results = {};
                            self.noResults = true;
                        }
                    }, (response) => {
                        // error callback
                        self.isLoading = false;
                    });
                }, self.debounce);
            }
        }
    }
</script>