<!--suppress JSUnresolvedVariable, JSUnresolvedFunction -->
<template>
    <loading-view :loading="initialLoading">
        <div class="flex">
            <div class="w-3/4 mr-3">
                <card class="mb-4">
                    <heading :level="2" class="subject-title bg-30">
                        {{ item.subject }}

                        <span class="resource-time">
                            {{ item.updated_ago }}
                        </span>
                    </heading>

                    <div class="resource-body" v-html="item.body"></div>
                </card>

                <reply-form class="overflow-hidden mt-4" @success="handleForm" :resource-id="resourceId"/>

                <replies class="p-4 mt-4" :loading="repliesLoading" :replies="replies" :resource-id="resourceId"/>
            </div>

            <div class="w-1/4 ml-3">
                <detail-info :resource="resource"/>
            </div>
        </div>
    </loading-view>
</template>

<script>

    import {Minimum} from 'laravel-nova'
    import Replies from './Reply/Replies'
    import ReplyForm from "./Reply/Form";
    import DetailInfo from "./Parts/DetailInfo";

    export default {
        props: ['resourceId'],
        components: {
            DetailInfo,
            Replies,
            ReplyForm
        },
        data: () => ({
            initialLoading: true,
            repliesLoading: true,
            resource: null,
            replies: []
        }),
        mounted() {
            this.initialComponent()
        },
        methods: {
            async initialComponent() {
                await this.getResource();
                await this.getReplies();

                this.initialLoading = false;
            },
            async handleForm() {
                await this.getReplies();

                Nova.$emit('updatedReply');
            },
            getReplies() {
                this.repliesLoading = true;
                this.replies = [];


                return Minimum(Nova.request().get(`${_requestPrefixFeedback}/errorReport/${this.resourceId}/replies`))
                    .then(({data}) => {
                        this.replies = data;
                        this.repliesLoading = false;
                    })
                    .catch(error => {
                        this.repliesLoading = false;
                    })
            },
            getResource() {
                this.resource = null;

                return Minimum(Nova.request().get(`${_requestPrefixFeedback}/errorReport/${this.resourceId}`))
                    .then(({data}) => {
                        this.resource = data;
                    })
                    .catch(error => {
                        if (error.response.status >= 500) {
                            Nova.$emit('error', error.response.data.message);
                            return
                        }

                        if (error.response.status === 404 && this.initialLoading) {
                            this.$router.push({name: '404'});
                            return
                        }

                        if (error.response.status === 403) {
                            this.$router.push({name: '403'});
                            return
                        }

                        this.$toasted.show(this.__('This resource no longer exists'), {type: 'error'});

                        this.$router.push({
                            name: 'index',
                            params: {resourceName: 'errors'},
                        })
                    })


            }
        },
        computed: {
            item() {
                return this.resource !== null ? this.resource : {};
            }
        }
    }
</script>

<style scoped lang="scss">
    .subject-title {
        padding: 1.5rem;
        line-height: 20px;

        .resource-time {
            float: right;
            color: #afc4d8;
            font-size: 12px;
        }
    }

    .resource-body {
        margin-top: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem
    }

</style>