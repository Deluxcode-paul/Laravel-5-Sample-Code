<template>
    <div class="sort-by form-item">
        <label>{{ sort.label || 'Sort By' }}:</label>
        <div class="form-input">
            <select :name="_key">
                <option v-for="(option, index) in sort.all" :value="index" :selected="index == selected">{{ option }}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['sort', '_key'],
        computed: {
            selected() {return this.sort.selected;}
        },
        mounted() {
            var self = this,
                $el = $(self.$el),
                $select = $el.find('select'),
                query = {page: undefined};

            $select.select2({
                theme: 'basic is-white'
            });

            $select.on('change', function(e){
                e.preventDefault();
                query[$select.prop('name')] = $select.val();

                self.$router.push({
                    path: self.$route.fullPath,
                    query
                });
            });
        }
    }
</script>
