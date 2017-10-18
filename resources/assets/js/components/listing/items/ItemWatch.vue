<template>
    <li class="item-recipe">

        <a :href="item.detailsUrl" class="item-recipe__wrapper">
            <div class="item-recipe__visual" :title="item.title">

                <span class="item-recipe__video">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 86.3 86.3" enable-background="new 0 0 86.3 86.3" xml:space="preserve" class="icon icon-play">
                        <path d="M43.2,85.7c-23.4,0-42.5-19.1-42.5-42.5S19.7,0.7,43.2,0.7s42.5,19.1,42.5,42.5S66.6,85.7,43.2,85.7 M43.2,5.7C22.5,5.7,5.7,22.5,5.7,43.2s16.8,37.5,37.5,37.5s37.5-16.8,37.5-37.5S63.8,5.7,43.2,5.7 M30.5,65.7c-0.4,0-0.9-0.1-1.3-0.3C28.5,65,28,64.1,28,63.2V23.1c0-0.9,0.5-1.7,1.3-2.2c0.8-0.4,1.7-0.4,2.5,0L66.5,41c0.8,0.4,1.3,1.3,1.3,2.2c0,0.9-0.5,1.7-1.3,2.2L31.8,65.4C31.4,65.6,31,65.7,30.5,65.7 M33,27.4v31.5l27.2-15.7L33,27.4z"/>
                    </svg>
                </span>

                <img :src="item.listImage" class="item-recipe__img" alt="" width="285" height="215" />
            </div>

            <div class="item-recipe__subtitle">
                {{ item.type }}
            </div>

            <h4 class="item-recipe__title" :title="item.title">{{ item.title }}</h4>
        </a>


        <div class="item-recipe__meta">
            <a :href="item.creatorUrl" class="item-recipe__author" :title="item.creator">{{ item.creator }}</a>
        </div>
    </li>
</template>

<script>
    export default {
        props: ['item'],
        created() {
        },
        mounted() {
        }
    }
</script>