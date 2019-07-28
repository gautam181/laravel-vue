<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-heading">{{ ticket.title }}</div>
                    <div class="panel-body">
                        <p>
                            {{ ticket.description }}
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-heading">Comments</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table v-if="comments.length > 0" class="table table-hover table-bordered table-striped">
                                <tbody>
                                <template v-for="row in comments">
                                    <tr>
                                        <td class="issue-info">
                                            <router-link v-bind:to="{'name': 'project-detail', params: {'id': ticket.id }}" active-class="" class="">
                                                {{ ticket.title }}
                                            </router-link>
                                            <br>
                                            <small>
                                                {{ ticket.description }}
                                            </small>
                                        </td>
                                        <td>
                                            {{ ticket.assigned_to.name }}
                                        </td>
                                        <td>
                                            {{ ticket.updated_at }}
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-default btn-xs"> Edit</button>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                            <p v-else>
                                No comments found for ticket <strong>{{ ticket.title }}</strong>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ticket-detail",
        data(){
            return {
                myRoute : {},
                ticket_id : this.$route.params.id,
                ticket: {},
                comments: []

            }
        },
        mounted(){
            this.getTicket(this.ticket_id);
            this.getComments(this.ticket_id);
            this.$emit('handle-page-header', {label:'Ticket', desc:'Ticket Detail'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getTicket: function (id) {
                axios.get(this.$settings.APIURL+"/ticket/"+id)
                    .then(response => {
                        let res = response.data;
                        this.ticket = res;
                    });
            },
            getComments: function (id, data) {

            }
        }
    }
</script>

<style scoped>

</style>
