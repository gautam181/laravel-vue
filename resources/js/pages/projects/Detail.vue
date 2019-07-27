<template>
    <div>
        <div class="row projects">
            <div class="col-md-12">
                <div class="hpanel">
                    <div class="panel-heading">Project: {{ project.name }}</div>
                    <div class="panel-body">

                        <p>
                            {{ project.description }}
                        </p>

                        <div class="table-responsive">
                            <table v-if="tickets" class="table table-hover table-bordered table-striped">
                                <tbody>
                                <template v-for="ticket in tickets">
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
                                No project found for project <strong>{{ project.name }}</strong>
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
        name: "project-detail",
        data(){
            return {
                myRoute : {},
                project_id : this.$route.params.id,
                project: {},
                tickets: []

            }
        },
        mounted(){
            this.getProject(this.project_id);
            this.getTickets(this.project_id);
            this.$emit('handle-page-header', {label:'Project', desc:'Project Detail'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getProject: function (id) {
                axios.get(this.$settings.APIURL+"/project/"+id)
                    .then(response => {
                        let res = response.data;
                        this.project = res;
                    });
            },
            getTickets: function (id, data) {
                axios.get(this.$settings.APIURL+"/project/tickets/"+id)
                    .then(response => {
                        let res = response.data;
                        this.tickets = res.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
