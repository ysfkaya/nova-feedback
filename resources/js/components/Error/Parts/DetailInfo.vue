<!--suppress JSUnresolvedVariable -->
<template>
    <card class="w-full">
        <heading :level="2" class="p-4 bg-30 info-head leading-9">
            Hata Raporu

            <solved-button :resource="resourceData"/>
        </heading>
        <table class="table w-full" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <th>ID :</th>
                <td># {{ resourceData.id }}</td>
            </tr>
            <tr>
                <th>Oluşturan :</th>
                <td>
                    <router-link class="no-underline dim text-primary font-bold" :to="{
                        name:'detail',
                        params:{
                            resourceName:'users',
                            resourceId:resourceData.creator.id
                        }
                    }">
                        {{ resourceData.creator.name }}
                    </router-link>
                </td>
            </tr>
            <tr>
                <th>Durum :</th>
                <td>
                    <loader class="loader" v-if="updatingStatus"/>
                    <span v-html="resourceData.status_html" v-else></span>
                </td>
            </tr>
            <tr>
                <th>Öncelik :</th>
                <td v-html="resourceData.priority_html"></td>
            </tr>
            <tr>
                <th>Tarih :</th>
                <td>{{ resourceData.created_at_localized }}</td>
            </tr>
            </tbody>
        </table>
    </card>
</template>

<script>
    import SolvedButton from "./SolvedButton";
    export default {
        name: "DetailInfo",
        components: {SolvedButton},
        props: ['resource'],
        data: function () {
            return {
                updatingStatus: false,
                resourceData: this.resource
            }
        },
        mounted() {
            const vm = this;

            Nova.$on('updatedReply', function () {
                vm.updatingStatus = true;

                Nova.request().get(`${_requestPrefixFeedback}/errorReport/${vm.resourceData.id}`).then(({data}) => {
                    vm.resourceData = data;

                    vm.updatingStatus = false;
                })
            })
        }
    }
</script>

<style scoped lang="scss">
    .info-head {
        border: 1px solid #dddddd;
    }

    .table {
        th {
            background-color: unset;
            font-size: .85rem;
        }

        tr {
            &:first-child {
                td {
                    border-top: none;
                }
            }
            &:nth-child(2n+1) {
                background: #f4f9ff;
            }
            &:hover {
                td {
                    background-color: unset;
                }
            }
        }
    }

    .loader{
        margin-left: unset;
    }
</style>