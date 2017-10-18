<template>
    <ol class="breadcrumb">
        <li v-for="item in data" :class="item.last ? 'active' : ''">
            <a :href="item.url" v-if="!item.last">{{ item.title }}</a>
            <template v-if="item.last">{{ item.title }}</template>
        </li>
    </ol>
</template>

<script>
    export default {
        computed: {
            data() {
                return this.$store.state.data.breadcrumbs;
            }
        }
    }
</script>