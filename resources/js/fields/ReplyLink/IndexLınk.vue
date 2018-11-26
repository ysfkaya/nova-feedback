<template>
    <router-link
            class="cursor-pointer text-70 hover:text-primary float-right eye"
            :to="{
                name:'show.errorReport',
                params: {
                    id: field.value,
                },
            }"
            :title="__('Reply')">

        <icon type="reply" width="25" height="25" view-box="0 0 511.971 511.971"/>
    </router-link>
</template>

<script>

    export default {
        props: ['resourceName', 'field'],
        mounted() {
            this.$el.parentElement.style.paddingRight = '0px'
        }
    }
</script>

