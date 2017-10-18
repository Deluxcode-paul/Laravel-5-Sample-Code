<template>
    <section class="page-heading" :style="{ 'background-image': 'url(' + bg + ')' }">
        <div class="site-width">
            <breadcrumbs :data="breadcrumbs" v-if="breadcrumbs"></breadcrumbs>
            <div class="page-heading__spacer">
                <div class="heading-decorative">
                    <h1 class="heading-decorative__title"><span>{{ heading0 }}</span></h1>
                    <h2 class="heading-decorative__subtitle uppercase">{{ heading1 }}</h2>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import Breadcrumbs from './Breadcrumbs.vue'

    export default {
        components: {
            Breadcrumbs
        },
        computed: {
            breadcrumbs() {
                return this.$store.state.data.breadcrumbs;
            }
        },
        props: ['heading0', 'heading1', 'bg']
    }
</script>