<template>
    <card>
        <form @submit.prevent="handleSubmit">
            <div>
                <form-trix-field ref="message" :field="field" :errors="errors"/>
            </div>

            <div class="bg-30 flex px-8 py-4">
                <button type="submit" class="btn btn-default btn-primary ml-auto" :disabled="working"
                        :class="{'pointer-events-none':working}">
                    <loader v-if="working"/>
                    <span v-else>
                    Gönder
                </span>
                </button>
            </div>
        </form>
    </card>
</template>

<script>
    import {Errors} from 'laravel-nova'

    export default {
        name: 'ReplyForm',
        props: ['resourceId'],
        data: () => ({
            field: {
                name: 'Yanıt Gönder',
                attribute: 'body',
                value: null
            },
            working: false,
            errors: new Errors()
        }),
        methods: {
            async handleSubmit() {

                this.working = true;

                try {
                    const response = await Nova.request().post(
                        `${_requestPrefixFeedback}/errorReport/sendReply/${this.resourceId}`,
                        this.createFormData()
                    );

                    this.$emit('success');

                    this.reset();

                } catch (e) {
                    if (e.response.status === 422) {
                        this.errors = new Errors(e.response.data.errors);
                    }

                }

                this.working = false;

            },
            createFormData() {
                return _.tap(new FormData, formData => {
                    this.field.fill(formData);
                })
            },
            reset() {
                this.field.value = '';
                this.$refs.message.value = '';
                this.$refs.message.$children[0].$children[1].$refs.theEditor.editor.loadHTML('');
                this.errors.clear();
            }
        }
    }
</script>

<style scoped>

</style>