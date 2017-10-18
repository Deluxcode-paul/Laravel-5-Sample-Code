<template>
    <div class="page-size">
        <span class="page-size__title">{{ size.label || 'View' }}:</span>
        <ul>
            <li v-for="item, index in size.all">
                <label>
                    <input type="radio" :name="name" :checked="size.selected == item.label" @change="submit(item.label)">
                    <span>{{ item.label }}</span>
                </label>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['size'],
        data() {
            return {name: this.size.key + Math.random().toString(36).substring(7)}
        },
        methods: {
            submit(size) {
                var self = this,
                    query = {page: undefined};

                query[self.size.key] = size;

                self.$router.push({
                    path: self.$route.fullPath,
                    query
                });
            }
        }
    }
</script>
<style lang="sass" scoped>
    .page-size {
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
                    &:hover {color: #c79a4b;}
                }
            }
            input:checked + span {
                font-weight: bold;
                color: #c79a4b;
            }
            a {
                color: currentColor;
                display: block;
                &:hover {color: #c79a4b;}
                &.is-active {
                    font-weight: bold;
                    color: #c79a4b;
                }
            }
        }
    }
</style>