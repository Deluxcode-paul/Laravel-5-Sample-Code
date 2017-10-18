<template>
    <div class="sort-by2">
        <span class="sort-by2__title">{{ sort.label || 'View' }}:</span>
        <ul>
            <li v-for="item, index in sort.all">
                <label>
                    <input type="radio" :name="name" :checked="sort.selected == index" @change="submit(index)">
                    <span>{{ item }}</span>
                </label>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['sort'],
        data() {
            return {name: this.sort.key + Math.random().toString(36).substring(7)}
        },
        methods: {
            submit(sort) {
                var self = this,
                    query = {page: undefined};

                query[self.sort.key] = sort;

                self.$router.push({
                    path: self.$route.fullPath,
                    query
                });
            }
        }
    }
</script>
<style lang="sass" scoped>
    .sort-by2 {
        color: #8b8d90;
        text-align: center;
        font-size: 16px;
        line-height: 16px;
        &__title {
            display: inline-block;
            vertical-align: middle;
            margin-right: 7px;
        }
        ul {
            display: inline-flex;
            vertical-align: middle;
            li {
                padding: 0 11px;
                &:first-child {padding-left: 0;}
                &:last-child {padding-right: 0;}
                & + li {border-left: 1px solid #696a6c;}
            }
            input {
                position: absolute;
                z-index: -1;
                width: .1px;
                height: .1px;
                opacity: 0;
                overflow: hidden;
            }
            span {
                color: currentColor;
                cursor: pointer;
                display: block;
                .no-touchevents & {
                    &:hover {color: #7a087a;}
                }
            }
            input:checked + span {
                font-weight: bold;
                color: #7a087a;
            }
            a {
                color: currentColor;
                display: block;
                &:hover {color: #7a087a;}
                &.is-active {
                    font-weight: bold;
                    color: #7a087a;
                }
            }
        }
    }
</style>