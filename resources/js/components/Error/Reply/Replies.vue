<!--suppress CheckEmptyScriptTag -->
<template>
    <loading-card :loading="loading">
        <div class="text-center" v-if="!replies.length || !repliesData.length">
            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="65" height="51">
                <g fill="#A8B9C5" fill-rule="nonzero">
                    <path d="M159.438 318.871C71.522 318.871 0 247.351 0 159.438S71.523 0 159.438 0c75.175 0 139.609 52.094 155.664 124.805 12.449 2.39 27.886 1.843 39.937-9.84a9.998 9.998 0 0 1 16.832 8.77c-6.672 41.41-37.957 65.714-58.543 77.476-8.812 32.477-28.055 61.785-54.523 82.91-28.489 22.734-62.848 34.75-99.368 34.75zm0-298.871C82.55 20 20 82.55 20 159.438s62.55 139.437 139.438 139.437c64.69 0 120.433-43.863 135.554-106.672.672-2.777 2.5-5.14 5.024-6.484 12.949-6.895 33.074-20.438 44.468-42.23-12.168 3.48-25.964 3.273-40.605-.794a9.99 9.99 0 0 1-7.168-7.882C284.855 68.284 227.129 20 159.438 20zm0 0"/>
                    <path d="M383.5 512c-29.016 0-57.457-9.945-80.09-28.012-21.105-16.843-36.512-40.144-43.715-65.992-16.668-9.68-41.351-29.3-46.699-62.48a10.003 10.003 0 0 1 5.254-10.457 9.992 9.992 0 0 1 11.582 1.687c8.512 8.254 19.406 8.996 28.516 7.496C271.78 296.348 323.378 255 383.5 255c70.855 0 128.5 57.645 128.5 128.5S454.355 512 383.5 512zM240.93 373.965c9.015 14.445 22.879 23.656 32.066 28.55A9.983 9.983 0 0 1 278.02 409c11.77 48.867 55.144 83 105.48 83 59.828 0 108.5-48.672 108.5-108.5S443.328 275 383.5 275c-52.672 0-97.594 37.57-106.813 89.336a10.001 10.001 0 0 1-7.171 7.883c-10.137 2.812-19.797 3.37-28.586 1.746zm0 0"/>
                    <path d="M341 394a10.08 10.08 0 0 1-7.07-2.93c-1.86-1.86-2.93-4.441-2.93-7.07s1.07-5.21 2.93-7.07c1.86-1.86 4.441-2.93 7.07-2.93s5.21 1.07 7.07 2.93c1.86 1.86 2.93 4.441 2.93 7.07s-1.07 5.21-2.93 7.07A10.08 10.08 0 0 1 341 394zm0 0"/>
                    <path d="M384 394a10.08 10.08 0 0 1-7.07-2.93c-1.86-1.86-2.93-4.441-2.93-7.07s1.07-5.21 2.93-7.07c1.86-1.86 4.441-2.93 7.07-2.93s5.21 1.07 7.07 2.93c1.86 1.86 2.93 4.441 2.93 7.07s-1.07 5.21-2.93 7.07A10.08 10.08 0 0 1 384 394zm0 0"/>
                    <path d="M427 394c-2.64 0-5.21-1.07-7.07-2.93-1.86-1.86-2.93-4.441-2.93-7.07s1.07-5.21 2.93-7.07c1.86-1.86 4.43-2.93 7.07-2.93 2.629 0 5.21 1.07 7.07 2.93 1.86 1.86 2.93 4.441 2.93 7.07s-1.07 5.21-2.93 7.07A10.08 10.08 0 0 1 427 394zm0 0"/>
                    <path d="M221.168 145H87c-5.523 0-10-4.477-10-10s4.477-10 10-10h134.168c5.52 0 10 4.477 10 10s-4.48 10-10 10zm0 0"/>
                    <path d="M176 193H87c-5.523 0-10-4.477-10-10s4.477-10 10-10h89c5.523 0 10 4.477 10 10s-4.477 10-10 10zm0 0"/>
                    <path d="M221.172 193a10.12 10.12 0 0 1-7.082-2.93c-1.86-1.86-2.918-4.441-2.918-7.07s1.058-5.21 2.918-7.07a10.107 10.107 0 0 1 7.082-2.93 10.07 10.07 0 0 1 7.066 2.93c1.86 1.86 2.934 4.441 2.934 7.07s-1.07 5.21-2.934 7.07a10.084 10.084 0 0 1-7.066 2.93zm0 0"/>
                </g>
            </svg>

            <h3 class="text-base text-80 font-normal mb-6">
                {{ __('Hiç bir yanıt mevcut değil !') }}
            </h3>
        </div>
        <div id="replies" v-else v-on-clickaway="closeAllReplyEditMode">
            <div class="flex lang" v-for="(reply,index) in repliesData">
                <div class="reply-avatar">
                    <img :src="reply.creator.avatar" class="w-16 rounded-full">
                </div>
                <div class="reply-body">
                    <div class="reply-head">
                        <h3 v-text="reply.creator.name"></h3>
                        <div v-if="reply.user_id === userId">
                            <div class="reply-actions" v-if="!reply.editMode">
                            <span class="reply-delete" @click.prevent="deleteReply(index)">
                                <icon/>
                            </span>
                                <span class="reply-edit" @click.prevent="editMode(index)">
                                <icon type="edit"/>
                            </span>
                            </div>
                            <div class="reply-actions" v-else>
                            <span class="reply-cancel" @click.prevent="reply.editMode = false">
                              <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                   viewBox="0 0 475.2 475.2" width="20" height="20">
                                  <path d="M405.6 69.6C360.7 24.7 301.1 0 237.6 0s-123.1 24.7-168 69.6S0 174.1 0 237.6s24.7 123.1 69.6 168 104.5 69.6 168 69.6 123.1-24.7 168-69.6 69.6-104.5 69.6-168-24.7-123.1-69.6-168zm-19.1 316.9c-39.8 39.8-92.7 61.7-148.9 61.7s-109.1-21.9-148.9-61.7c-82.1-82.1-82.1-215.7 0-297.8C128.5 48.9 181.4 27 237.6 27s109.1 21.9 148.9 61.7c82.1 82.1 82.1 215.7 0 297.8z"/><path
                                      d="M342.3 132.9c-5.3-5.3-13.8-5.3-19.1 0l-85.6 85.6-85.6-85.6c-5.3-5.3-13.8-5.3-19.1 0-5.3 5.3-5.3 13.8 0 19.1l85.6 85.6-85.6 85.6c-5.3 5.3-5.3 13.8 0 19.1 2.6 2.6 6.1 4 9.5 4s6.9-1.3 9.5-4l85.6-85.6 85.6 85.6c2.6 2.6 6.1 4 9.5 4 3.5 0 6.9-1.3 9.5-4 5.3-5.3 5.3-13.8 0-19.1l-85.4-85.6 85.6-85.6c5.3-5.3 5.3-13.8 0-19.1z"/>
                              </svg>
                            </span>
                                <span class="reply-save" @click.prevent="saveReply(index)">
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                     width="20" height="20">
                                        <path d="M437.019 74.98C388.667 26.629 324.38 0 256 0 187.619 0 123.331 26.629 74.98 74.98 26.628 123.332 0 187.62 0 256s26.628 132.667 74.98 181.019C123.332 485.371 187.619 512 256 512c68.38 0 132.667-26.629 181.019-74.981C485.371 388.667 512 324.38 512 256s-26.629-132.667-74.981-181.02zM256 482C131.383 482 30 380.617 30 256S131.383 30 256 30s226 101.383 226 226-101.383 226-226 226z"/><path
                                        d="M378.305 173.859c-5.857-5.856-15.355-5.856-21.212.001L224.634 306.319l-69.727-69.727c-5.857-5.857-15.355-5.857-21.213 0-5.858 5.857-5.858 15.355 0 21.213l80.333 80.333a14.953 14.953 0 0 0 10.606 4.393c3.838 0 7.678-1.465 10.606-4.393l143.066-143.066c5.858-5.857 5.858-15.355 0-21.213z"/>
                                </svg>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="reply-message">
                        <p v-html="reply.reply_body" v-if="!reply.editMode"></p>
                        <form-trix-field :field="reply.field" :errors="reply.errors" v-else/>
                    </div>
                </div>
            </div>
        </div>
    </loading-card>
</template>

<script>
    import {Errors} from 'laravel-nova';
    import {mixin as clickaway} from 'vue-clickaway'

    export default {
        mixins: [clickaway],

        name: 'Replies',
        props: ['replies', 'loading'],
        data: function () {
            return {
                repliesData: [],
                userId: window.config.userId
            }
        },
        watch: {
            replies() {
                this.filteredReplies();
            },
            repliesData: {
                handler(data) {
                    this.$nextTick(function () {


                        let trixFlexDiv = document.body.querySelector('.reply-message .flex');
                        let trixEmptyDiv = document.body.querySelectorAll('.reply-message .flex > div.w\\-1\\/5');

                        trixEmptyDiv.forEach(function (div) {
                            div.remove();
                        });

                        if (trixFlexDiv) {
                            trixFlexDiv.classList.remove('border-b');
                            trixFlexDiv.classList.remove('border-40');
                        }

                    })
                },
                deep: true
            }
        },
        created() {
            this.filteredReplies();
        },
        methods: {
            async deleteReply(index) {
                if (!confirm('Emin misiniz ?')) {
                    return;
                }

                await Nova.request().delete(
                    `${_requestPrefixFeedback}/errorReport/deleteReply/${this.repliesData[index].id}`,
                );

                this.repliesData.splice(index, 1);

                Nova.$emit('updatedReply');
            },
            async saveReply(index) {
                try {
                    const {data} = await Nova.request().post(
                        `${_requestPrefixFeedback}/errorReport/updateReply/${this.repliesData[index].id}`,
                        this.createFormData(index)
                    );

                    this.$toasted.show('Yanıt kaydedildi !', {type: 'success'});

                    let reply = this.repliesData[index];

                    reply.reply_body = data.item.reply_body;
                    reply.errors = new Errors();
                    reply.editMode = false;
                    reply.field.value = data.item.reply_body;
                } catch (e) {
                    if (e.response.status === 422) {
                        this.repliesData[index].errors = new Errors(e.response.data.errors);
                    }
                }
            },
            editMode(index) {
                this.repliesData[index].editMode = true;
                this.repliesData[index].errors = new Errors();
            },
            createFormData(index) {
                return _.tap(new FormData, formData => {
                    this.repliesData[index].field.fill(formData)

                    formData.append('index', index);
                })
            },
            closeAllReplyEditMode() {
                this.repliesData.forEach(function (reply) {
                    reply.editMode = false;
                })
            },
            filteredReplies() {
                const vm = this;
                this.repliesData = [];

                _.each(this.replies, function (item, key) {
                    vm.repliesData.push(Object.assign({}, item, {
                        field: {
                            attribute: 'reply_' + key,
                            value: item.reply_body,
                            name: ''
                        },
                        editMode: false,
                        errors: new Errors()
                    }));
                })
            }
        }
    }

</script>

<style lang="scss">

    #replies {

        > .flex {
            padding: 2rem;

            .reply-avatar {
                margin-right: 2rem;
            }

            .reply-head {
                content: "";
                display: table;
                clear: both;
                width: 100%;

                h3 {
                    float: left;
                    width: 90%;
                }

                .reply-actions {
                    float: right;
                    span {
                        margin-right: .35rem;
                        margin-left: .35rem;
                        cursor: pointer;
                    }
                }
            }

            .reply-body {
                width: 100%;
                display: block;

                .reply-head {
                    margin-bottom: 2rem;
                }

                .reply-message {
                    .flex {
                        > div {
                            padding: 0;
                        }
                    }
                }
            }
        }
    }

    blockquote {
        margin: 0 0 0 0.3em;
        padding: 0 0 0 0.6em;
        border-left: 0.3em solid #ccc;
        box-sizing: border-box;
    }

    pre {
        display: inline-block;
        width: 100%;
        vertical-align: top;
        font-family: monospace;
        margin: 0;
        padding: 0.5em;
        white-space: pre;
        background-color: #eee;
        overflow-x: auto;
    }
</style>