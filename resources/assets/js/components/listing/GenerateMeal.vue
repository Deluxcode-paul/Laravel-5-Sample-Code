<template>
    <div class="generate-meal__content site-width ajax-section">
        <div class="spacer">
            <div class="generate-meal__filters">
                <form class="form js-form form-generate-meal" role="form" id="js-form-generate-meal">
                    <div class="form-row">
                        <div class="form-item is-filler">
                            <div class="form-text">{{ trans.labels.i_want_to_cook }}</div>
                        </div>
                        <div class="form-item">
                            <div class="form-input">
                                <select :name="parameters.category.key" :placeholder="trans.placeholders.categories" :data-placeholder="trans.placeholders.categories" autocomplete="off">
                                    <option></option>
                                    <option v-for="item, id in parameters.category.all" :value="id" :selected="parameters.category.selected[id]">{{ item }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-item is-filler">
                            <div class="form-text">{{ trans.labels.meal_that_only_takes }}</div>
                        </div>
                        <div class="form-item">
                            <div class="form-input">
                                <select :name="parameters.cookTime.key" :placeholder="trans.placeholders.time" :data-placeholder="trans.placeholders.time" autocomplete="off">
                                    <option></option>
                                    <option v-for="item, id in parameters.cookTime.all" :value="id" :selected="parameters.cookTime.selected[id]">{{ item }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-item is-filler">
                            <div class="form-text">
                                {{ trans.labels.to_cook_and_have }}
                                <span>{{ trans.labels.choose_ingredients }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-item">
                            <div class="form-input">
                                <select :name="parameters.ingredients.key + '[]'" :placeholder="trans.placeholders.ingredient" :data-placeholder="trans.placeholders.ingredient" data-allow-clear="true" data-tags="true" autocomplete="off">
                                    <option></option>
                                    <option v-for="item, id in ingredients" :value="id" :selected="isSelected(id, 0)">{{ item }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="form-input">
                                <select :name="parameters.ingredients.key + '[]'" :placeholder="trans.placeholders.ingredient" :data-placeholder="trans.placeholders.ingredient" data-allow-clear="true" data-tags="true" autocomplete="off">
                                    <option></option>
                                    <option v-for="item, id in ingredients" :value="id" :selected="isSelected(id, 1)">{{ item }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="form-input">
                                <select :name="parameters.ingredients.key + '[]'" :placeholder="trans.placeholders.ingredient" :data-placeholder="trans.placeholders.ingredient" data-allow-clear="true" data-tags="true" autocomplete="off">
                                    <option></option>
                                    <option v-for="item, id in ingredients" :value="id" :selected="isSelected(id, 2)">{{ item }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="form-input">
                                <select :name="parameters.ingredients.key + '[]'" :placeholder="trans.placeholders.ingredient" :data-placeholder="trans.placeholders.ingredient" data-allow-clear="true" data-tags="true" autocomplete="off">
                                    <option></option>
                                    <option v-for="item, id in ingredients" :value="id" :selected="isSelected(id, 3)">{{ item }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-item is-filler">
                            <div class="form-text">{{ trans.labels.and }}</div>
                        </div>
                        <div class="form-item">
                            <div class="form-input">
                                <select :name="parameters.ingredients.key + '[]'" :placeholder="trans.placeholders.ingredient" :data-placeholder="trans.placeholders.ingredient" data-allow-clear="true" data-tags="true" autocomplete="off">
                                    <option></option>
                                    <option v-for="item, id in ingredients" :value="id" :selected="isSelected(id, 4)">{{ item }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-item is-filler">
                            <div class="form-text">
                                .
                            </div>
                        </div>
                        <div class="form-item">
                            <button type="submit" class="btn-submit btn is-large is-brown" @click.prevent="submit">Generate Meals</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="ajax-section" :class="loading ? 'is-loading' : ''">
                <ul class="grid generate-meal__items">
                    <li v-for="item in [1,2,3,4,5,6,7,8]" v-if="!items.length && firstLoad" class="item-recipe-placeholder"></li>
                    <item v-for="item in items" :item="item"></item>
                </ul>
                <div class="no-results" v-if="!items.length && !firstLoad">
                    <h2 class="no-results__title">{{ trans.no_results.heading }}</h2>
                    <div class="no-results__suggestions">
                        <strong>{{ trans.no_results.title_suggestions }}</strong>
                        <ul>
                            <li v-for="suggestion in trans.no_results.suggestions">{{ suggestion }}</li>
                            <li>
                                <a :href="noResults.postRequest" target="_blank">{{ trans.no_results.link }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="separator"></div>
                    <div class="no-results__top">
                        <strong>{{ trans.title_featured }}</strong>
                        <ul class="grid">
                            <item v-for="item in noResults.itemsFeatured" :item="item"></item>
                        </ul>
                        <div class="a-center">
                            <a :href="noResults.viewAll" class="btn is-brown">{{ trans.view_all }}</a>
                        </div>
                    </div>
                </div>
                <div class="listing__pager" v-if="!items.length">
                    <div class="separator"></div>
                    <div class="listing__panel">
                        <div class="js-pager" v-show="pager" v-html="pager" @click.prevent="changePage"></div>
                        <page-size :size="pageSize"></page-size>
                    </div>
                </div>
                <div class="preloader">
                    <div class="preloader__icon"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import PageSize from './toolbar/PageSize.vue'
    import item from './items/ItemRecipe.vue'

    export default {
        components: {
            PageSize,
            item
        },
        data() {
            return {firstLoad: true}
        },
        computed: {
            // 1st lvl properties
            loading() {return this.$store.state.loading;},
            data() {return this.$store.state.data;},
            trans() {return this.$store.state.trans;},

            // 2nd lvl properties
            items() {return this.data.items;},
            parameters() {return this.data.parameters;},
            pageSize() {return this.data.pageSize;},
            pager() {return this.data.pager;},
            ingredients() {return this.data.ingredients;},
            noResults() {return this.data.noResults;}
        },
        created() {
            this.firstLoad = !!this.items.length;
        },
        mounted() {
            var self = this,
                $el = $(self.$el),
                $selects = $el.find('select');

            $selects.select2({
                theme: 'basic is-white',
                closeOnSelect: true
            });
        },
        methods: {
            isSelected(id, index){
                return this.parameters.ingredients.selected[index] == id;
            },
            submit() {
                var self = this,
                    $form = $(self.$el),
                    query = {page: undefined},
                    $selects = $form.find('select'),
                    serialize = decodeURIComponent($selects.serialize()).split('&');

                self.firstLoad = false;

                serialize.forEach(function(n){
                    var split = n.split('=');

                    if (split[1] == '') return;

                    if (split[0].indexOf('[]') > -1) {
                        // array
                        if (query[split[0]]) {
                            // field already in query
                            if (query[split[0]].indexOf(split[1]) == -1) {
                                // value not yet exists
                                query[split[0]].push(split[1]);
                            }
                        } else {
                            // not in query
                            query[split[0]] = [split[1]];
                        }
                    } else {
                        // no array
                        query[split[0]] = split[1];
                    }
                });

                self.$router.push({
                    path: self.$route.path + '?',
                    query
                });
            }
        }
    }
</script>
