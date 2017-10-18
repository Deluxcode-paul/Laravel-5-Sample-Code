<template>

<li class="item-community">
    <div class="item-community__wrapper">
        <div class="item-community__photo">
            <a :href="item.user.publicProfileUrl">
                <img :src="item.user.activityImage" :alt="item.user.fullName">
            </a>
        </div>
        <div class="item-community__content">
            <ul class="rating" :data-rating="item.hasRating ? item.rating : ''" v-if="item.hasRating">
                <li v-for="n in 5">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 92.3 88.2" enable-background="new 0 0 92.3 88.2" xml:space="preserve" class="icon icon-star">
                        <path d="M71.5,87.1c-0.6,0-1.3-0.1-1.8-0.5L46.2,74.3L22.6,86.6c-0.6,0.3-1.2,0.5-1.8,0.5c-0.8,0-1.6-0.3-2.3-0.8c-1.2-0.9-1.8-2.4-1.6-3.9l4.5-26.2l-19-18.6c-1.1-1-1.5-2.6-1-4c0.5-1.4,1.7-2.5,3.2-2.7l26.3-3.8L42.6,3.3c0.7-1.3,2-2.2,3.5-2.2S49,2,49.7,3.3l11.8,23.9L87.8,31c1.5,0.2,2.7,1.3,3.2,2.7c0.5,1.4,0.1,3-1,4l-19,18.6l4.5,26.2c0.3,1.5-0.4,3-1.6,3.9C73.2,86.8,72.4,87.1,71.5,87.1"/>
                    </svg>
                </li>
            </ul>
            <h3 class="title">
                <a :href="item.detailsUrl">{{ item.title }}</a>
            </h3>
            <div class="descr">{{ limitedDetails }}</div>
            <div class="author">
                {{ trans.posted_by || 'Posted by' }}
                <a :href="item.user.publicProfileUrl">{{ item.user.fullName }}</a>
                | <span>{{ item.publishedAt }}</span>
            </div>
            <ul class="tags" v-if="item.tags">
                <li v-for="tag in item.tags"><a :href="tag.communitySearchUrl">{{ tag.title }}</a></li>
            </ul>
            <ul class="chefs" v-if="item.chefs">
                <li v-for="chef in item.chefs"><a :href="chef.publicProfileUrl">{{ chef.fullName }}</a></li>
            </ul>
        </div>
    </div>
    <div class="item-community__meta">
        <div class="item-community__info">
            <a href="#" class="item js-vote" :data-id="item.id" :data-type="item.dataType" v-if="item.userCanVote">
                <svg class="icon icon-heart" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="14.327px" height="12.28px" viewBox="0 0 14.327 12.28" >
                    <path d="M13.312,0.991C12.635,0.33,11.7,0,10.506,0c-0.331,0-0.668,0.058-1.012,0.173C9.15,0.286,8.83,0.441,8.535,0.636  C8.239,0.83,7.985,1.014,7.771,1.184S7.356,1.535,7.163,1.728C6.972,1.535,6.769,1.354,6.556,1.184S6.088,0.83,5.793,0.636  c-0.297-0.195-0.616-0.35-0.96-0.463C4.489,0.058,4.152,0,3.822,0c-1.194,0-2.13,0.33-2.808,0.991C0.338,1.652,0,2.569,0,3.741  c0,0.357,0.063,0.726,0.188,1.104c0.125,0.379,0.268,0.702,0.428,0.968s0.341,0.527,0.543,0.78C1.362,6.846,1.51,7.02,1.603,7.115  c0.094,0.096,0.166,0.166,0.221,0.208l4.988,4.813c0.096,0.096,0.214,0.144,0.352,0.144c0.139,0,0.256-0.048,0.353-0.143  l4.981-4.798c1.22-1.221,1.83-2.421,1.83-3.599C14.327,2.569,13.989,1.652,13.312,0.991"/>
                </svg>
                <span>{{ item.votes }}</span>
            </a>
            <div class="item" v-if="!item.userCanVote">
                <svg class="icon icon-heart" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="14.327px" height="12.28px" viewBox="0 0 14.327 12.28" >
                    <path d="M13.312,0.991C12.635,0.33,11.7,0,10.506,0c-0.331,0-0.668,0.058-1.012,0.173C9.15,0.286,8.83,0.441,8.535,0.636  C8.239,0.83,7.985,1.014,7.771,1.184S7.356,1.535,7.163,1.728C6.972,1.535,6.769,1.354,6.556,1.184S6.088,0.83,5.793,0.636  c-0.297-0.195-0.616-0.35-0.96-0.463C4.489,0.058,4.152,0,3.822,0c-1.194,0-2.13,0.33-2.808,0.991C0.338,1.652,0,2.569,0,3.741  c0,0.357,0.063,0.726,0.188,1.104c0.125,0.379,0.268,0.702,0.428,0.968s0.341,0.527,0.543,0.78C1.362,6.846,1.51,7.02,1.603,7.115  c0.094,0.096,0.166,0.166,0.221,0.208l4.988,4.813c0.096,0.096,0.214,0.144,0.352,0.144c0.139,0,0.256-0.048,0.353-0.143  l4.981-4.798c1.22-1.221,1.83-2.421,1.83-3.599C14.327,2.569,13.989,1.652,13.312,0.991"/>
                </svg>
                <span>{{ item.votes }}</span>
            </div>
            <a :href="item.detailsUrl + '#replies'" class="item">
                <svg class="icon icon-comment" xmlns="http://www.w3.org/2000/svg"x="0px" y="0px" width="392.238px" height="356.768px" viewBox="0 0 392.238 356.768">
                    <path d="M0,40.641v188.48c0,22.479,18.16,40.641,40.641,40.641h9.039v81.078c0,5.281,6.398,7.922,10.16,4.16L188,269.761h163.602   c22.477,0,40.637-18.161,40.637-40.641V40.641C392.238,18.16,374.078,0,351.602,0H40.641C18.16,0,0,18.16,0,40.641 M79.762,152.562   c0-4.184,2.316-7.557,5.199-7.557h124.801c2.879,0,5.199,3.373,5.199,7.557v29.883c0,4.184-2.32,7.555-5.199,7.555H84.879   c-2.879,0-5.199-3.371-5.199-7.555v-29.883H79.762z M79.359,73.853c0-3.794,2.321-6.853,5.2-6.853H307.68   c2.879,0,5.199,3.059,5.199,6.853v27.097c0,3.794-2.32,6.851-5.199,6.851H84.559c-2.879,0-5.2-3.057-5.2-6.851V73.853z"/>
                </svg>
                <span>{{ item.replies }}</span>
            </a>
        </div>
        <div class="item-community__actions" v-if="item.userCanEdit">
            <a :href="item.editUrl" class="link">{{ trans.links.edit }}</a>
        </div>
    </div>
</li>

</template>

<script>
    export default {
        props: ['item'],
        data() {
            return {
                maxDetails: null
            }
        },
        computed: {
            trans() {return this.$store.state.trans;},
            limitedDetails() {
                var self = this,
                    details = self.item.details;

                if (self.item.details.length > self.maxDetails) details = self.item.details.substring(0, self.maxDetails).trim() + '...';

                return details;
            }
        },
        created() {
            this.maxDetails = 256;
        }
    }
</script>