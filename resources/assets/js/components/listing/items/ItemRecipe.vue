<template>
    <li class="item-recipe">

        <a :href="item.detailUrl" class="item-recipe__wrapper">
            <div class="item-recipe__visual" :title="item.title">

                <span class="item-recipe__video" v-if="item.hasVideo">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 86.3 86.3" enable-background="new 0 0 86.3 86.3" xml:space="preserve" class="icon icon-play">
                        <path d="M43.2,85.7c-23.4,0-42.5-19.1-42.5-42.5S19.7,0.7,43.2,0.7s42.5,19.1,42.5,42.5S66.6,85.7,43.2,85.7 M43.2,5.7C22.5,5.7,5.7,22.5,5.7,43.2s16.8,37.5,37.5,37.5s37.5-16.8,37.5-37.5S63.8,5.7,43.2,5.7 M30.5,65.7c-0.4,0-0.9-0.1-1.3-0.3C28.5,65,28,64.1,28,63.2V23.1c0-0.9,0.5-1.7,1.3-2.2c0.8-0.4,1.7-0.4,2.5,0L66.5,41c0.8,0.4,1.3,1.3,1.3,2.2c0,0.9-0.5,1.7-1.3,2.2L31.8,65.4C31.4,65.6,31,65.7,30.5,65.7 M33,27.4v31.5l27.2-15.7L33,27.4z"/>
                    </svg>
                </span>

                <img src="/images/ribbon-recipe.png" alt="" class="item-recipe__ribbon" v-if="item.icon == 'top_chef'" />
                <img src="/images/ribbon-recipe.png" alt="" class="item-recipe__ribbon" v-if="item.icon == 'community_chef'" />

                <img :src="item.listImage" class="item-recipe__img" alt="" width="285" height="215" />

            </div>
            <h4 class="item-recipe__title" :title="item.title">{{ limitedTitle }}</h4>
        </a>

        <div class="item-recipe__meta">
            <a :href="item.creatorUrl" class="item-recipe__author" :title="item.creator">{{ item.creator }}</a>
            <div class="item-recipe__time">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1010 1010" enable-background="new 0 0 1010 1010" xml:space="preserve" class="icon icon-time">
                    <path d="M713.4,98.3c31-32.6,62.4-64.8,93.4-97.3c28.4,16.9,55.2,36.6,80.6,57.8c38,31.6,71.7,68.1,101.2,107.7c6.8,9.1,13.2,18.6,19.3,28.2c-31.3,32.2-62.3,64.8-93.6,97c-27-21-54.1-41.9-81.2-62.8c-3.2,3.3-6.3,6.6-9.6,9.9c36.7,43.2,65.2,93.4,83.8,147c31.6,90.9,33.6,191.8,5.8,283.9c-20.5,68.4-57.3,131.7-106.2,183.7c-51.2,54.5-115.7,96.4-186.4,120.7c-89,30.8-187.4,33.2-277.9,7.2c-44.2-12.7-86.4-32.1-124.9-57.2c-47.8-31.3-89.8-71.4-123.2-117.8C49.1,742.8,19.9,667.6,11.1,590c-6-52.3-3.2-105.6,8.6-156.9c11.8-51.5,32.6-100.8,61.1-145.2c30.9-48.3,70.9-90.8,117.2-124.6c50.6-37,108.8-63.6,170-77.5C446.3,68,529.4,71,606.2,94.7c61.2,18.8,118.2,50.7,166.6,92.5c2.8-2.7,5.3-5.5,8-8.3C758.3,152.1,735.9,125.2,713.4,98.3 M338.8,163.8c-47.1,16.6-90.9,42.4-128.5,75.2c11.6,11.6,23.2,23.2,34.8,34.8c6.7,6.8,9.9,16.8,8,26.2c-1.5,8.3-6.9,15.8-14.2,19.9c-7.8,4.5-17.7,5.1-25.9,1.6c-6.3-2.5-10.8-7.7-15.5-12.3c-9.5-9.5-19-19-28.5-28.5c-28.2,33.2-51,71-66.9,111.5c-15,37.9-23.8,78.3-26.5,118.9c24.4,0.1,48.9-0.1,73.3,0.1c14.1,0.5,26.6,12.6,27.5,26.7c1.1,11.1-4.8,22.3-14.5,27.8c-5.1,3-11.1,4.1-17,3.9c-22.9,0-45.8,0-68.8,0c0.9,9.4,1.9,18.8,3.4,28.2c11.3,73.3,44.2,143,93.1,198.7c10.5-10.5,21-21,31.5-31.5c8.1-7.9,21-10.2,31.5-5.8c9,3.6,15.9,12.1,17.5,21.6c1.9,9.4-1.4,19.4-8,26.2c-10.2,10.3-20.5,20.5-30.7,30.8c24.6,20.8,51.6,38.8,80.5,53.1c45.5,22.7,95.6,36.3,146.3,40.1c0-23,0-46,0-69c-0.1-8.5,4.1-16.9,10.7-22.2c10-8.5,25.8-8.8,36.1-0.7c7.5,5.5,11.8,14.6,11.7,23.8c0,22.7,0,45.4,0,68.1c10.8-0.9,21.5-2.1,32.2-3.7c71.5-11.1,139.6-42.5,194.5-89.5c-10.7-10.7-21.5-21.4-32.2-32.2c-7.1-7.9-9-19.8-5.2-29.7c2.9-8,9.6-14.5,17.7-17.2c7.9-2.7,17-2,24.2,2.2c4.7,2.5,8,6.7,11.8,10.3c8.5,8.5,16.9,16.9,25.4,25.4c55.2-62.8,89.8-143.5,96.5-227c-23.5,0-47,0-70.6,0c-7.6,0.1-15.2-2.9-20.7-8.1c-9.3-8.7-11.8-23.7-5.6-34.9c4.8-9.2,14.8-15.4,25.2-15.5c24,0,48.1,0,72.2,0c-4.9-84.3-38.6-166.4-93.4-230.5c-10,10-20,20-30,30c-3.9,3.9-7.6,8.2-12.8,10.4c-11.3,5.4-25.8,2.5-34.2-6.8c-10-10.6-10-28.9,0.1-39.4c11.9-11.9,23.8-23.8,35.8-35.8c-63.8-56.1-146-90.8-230.8-96.7c0,24.9,0.1,49.8,0,74.7c-0.1,9.9-5.7,19.4-14.2,24.4c-9.9,6-23.3,5.4-32.5-1.6c-7.8-5.6-12.3-15.3-11.8-24.9c0.1-24.2,0-48.5,0-72.7C406.3,144.9,371.8,152.1,338.8,163.8z"/>
                    <path d="M570.1,394.2c37.6-16.8,75.5-33,113.7-48.6c-16.9,41.1-34.3,82-52.7,122.5c-16,35.3-32.3,70.4-50.7,104.5c-7.4,13.6-15,27.1-24.2,39.6c-9.7,13.2-23.3,23.3-38.3,29.9c-22.8,10-49.3,10.9-72.7,2.6c-29.2-10.1-53-34.6-62-64.2c-7.1-22.9-5.7-48.3,4.1-70.1c6.8-15,17.1-28.6,30.5-38.2c14.5-10.4,30.2-18.9,45.9-27.3C498.7,426.7,534.3,410.3,570.1,394.2z"/>
                </svg>
                <span>{{ item.cookingTime }}</span>
            </div>
        </div>

        <a :href="item.deleteUrl" class="item-recipe__delete" v-if="item.deleteUrl"></a>

    </li>
</template>

<script>
    export default {
        props: ['item'],
        data() {
            return {
                maxTitle: null
            }
        },
        computed: {
            limitedTitle() {
                var self = this,
                    title = self.item.title;

                if (self.item.title.length > self.maxTitle) title = self.item.title.substring(0, self.maxTitle).trim() + '...';

                return title;
            }
        },
        created() {
            this.maxTitle = 48;
        }
    }
</script>