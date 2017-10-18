<template>
    <div class="listing__selected">
        <ul class="list-selected">
            <li v-for="filter in filteredParameters[0]" v-if="filter.selected">
                <span>{{ filter.label }}</span>
                <router-link :to="{ path: omitPathQuery(filter.key) }">x</router-link>
            </li>
            <template v-for="filter, filterName in filteredParameters[1]">
                <li v-for="title, index in filter.selected">
                    <span>
                        <em v-if="withLabel(filterName)">{{ filter.label }}: </em>
                        {{ title }}
                    </span>
                    <router-link :to="{ path: omitPathQuery(filter.key + '['+index+']') }">x</router-link>
                </li>
            </template>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['parameters'],
        data() {
            return {
                exclude: [
                    'header',
                    'preferences',
                    'activePreference',
                    'keyword',
                    'year',
                    'category',
                    'month',
                    'country',
                    'state',
                    'role'
                ]
            }
        },
        computed: {
            filteredParameters() {
                var self = this;

                var arr = [{},{}];

                $.map(self.parameters, function(parameter, title){

                    if (self.exclude.filter(n => title == n).length) return;

                    arr[typeof(parameter.selected) != 'object' ? 0 : 1][title] = parameter;
                });

                return arr;
            }
        },
        methods: {
            withLabel(filterName){
                var isWithLabel = false,
                    array = [
                        'ingredientsWith',
                        'ingredientsWithout',
                        'allergens'
                    ];

                array.forEach(n => {
                    if (n == filterName) {
                        isWithLabel = true;
                        return false;
                    }
                });

                return isWithLabel;
            }
        }
    }
</script>
