<template>
    <li class="item-chef">
        <a :href="item.publicProfileUrl" class="item-chef__visual">
            <img :src="item.searchListImage || item.listImage" :alt="item.title">
        </a>
        <div class="item-chef__info">
            <h3 class="item-chef__title"><a :href="item.publicProfileUrl">{{ item.fullName }}</a></h3>
            <ul class="item-chef__meta">
                <li v-if="item.location">{{ item.location }}</li>
                <li v-if="item.place_of_work">{{ item.place_of_work }}</li>
            </ul>
            <div class="item-chef__bio" v-if="item.bio">
                <p>{{ item.bio }}</p>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        props: ['item'],
        created() {
            console.log('Chef Item created.');
        },
        mounted() {
            console.log('Chef Item mounted.');
        }
    }
</script>