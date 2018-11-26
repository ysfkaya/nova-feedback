<template>
    <span class="mt-1 float-right" v-if="!is_solved">
       <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 426.667 426.667" width="25"
            class="cursor-pointer"
            @click.prevent="markAsSolved"
            height="25">
               <path :class="{'solved':is_solved,'unsolved':!is_solved}"
                     d="M213.333 0C95.518 0 0 95.514 0 213.333s95.518 213.333 213.333 213.333c117.828 0 213.333-95.514 213.333-213.333S331.157 0 213.333 0zm-39.134 322.918l-93.935-93.931 31.309-31.309 62.626 62.622 140.894-140.898 31.309 31.309-172.203 172.207z"></path>
       </svg>
    </span>
</template>

<script>
    export default {
        name: "SolvedButton",
        props: ['resource'],
        data: function () {
            return {
                is_solved: this.resource.is_solved
            }
        },
        mounted() {
            const vm = this;

            Nova.$on('updatedReply', function () {
                vm.is_solved = false;
            })
        },
        methods: {
            markAsSolved() {
                if (this.is_solved) {
                    return;
                }

                Nova.request().put(
                    `${_requestPrefixFeedback}/errorReport/markAsSolved/${this.resource.id}`
                ).then(({data}) => {
                    if (!data.success) {
                        Nova.$emit('error', this.__(data.message));

                        return;
                    }

                    Nova.$emit('updatedReply');

                    this.is_solved = true;
                })
            }
        }
    }
</script>

<style scoped lang="scss">
    .solved {
        fill: #6AC259;
    }

    .unsolved {
        fill: #929292;
    }
</style>