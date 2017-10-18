<template>
    <section class="search-heading" :style="{ 'background-image': 'url(' + bg + ')' }">
        <div class="site-width">
            <div class="search-heading__spacer">
                <form class="form js-form form-search">
                    <label>{{ label }}:</label>
                    <input type="search" :placeholder="placeholder" :value="value" :name="_key">
                    <button type="submit" class="btn-submit">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-338.2 58.8 23.3 24.4" enable-background="new -338.2 58.8 23.3 24.4" xml:space="preserve" class="icon icon-search">
                            <path d="M-315.3,81.2l-1.5,1.5c-0.4,0.4-1.1,0.4-1.5,0l-5-5c-0.4-0.4-0.4-1.1,0-1.5l-1.8-1.8c0,0,0,0-0.1,0c-1.3,0.8-2.8,1.3-4.5,1.3c-4.6,0-8.3-3.7-8.3-8.4c0-4.6,3.7-8.4,8.3-8.4s8.3,3.7,8.3,8.4c0,2.1-0.8,4.1-2.1,5.5l-0.2,0.1l1.8,1.8c0.4-0.4,1.1-0.4,1.5,0l5,5C-314.9,80.2-314.9,80.8-315.3,81.2z M-329.7,61.7c-3.1,0-5.5,2.5-5.5,5.6s2.5,5.6,5.5,5.6c3.1,0,5.7-2.5,5.7-5.6S-326.7,61.7-329.7,61.7z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: ['label', 'placeholder', 'bg', 'value', '_key'],
        created() {
            console.log('Component SearchHeading created.')
        },
        mounted() {
            var self = this,
                $el = $(self.$el);

            console.log('Component SearchHeading mounted.')
        }
    }
</script>