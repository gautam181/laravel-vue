<template>
    <div>
        <vue-title :title="project.name"></vue-title>
        <div class="row projects">
            <div class="col-md-12">
                <vue-panel
                    id="project"
                    :title="'Project: '+project.name"
                    tools="1"
                >{{ project.description }}</vue-panel>
            </div>
            <div class="col-md-12">

                <div class="hpanel forum-box" id="tickets" v-if="tickets.length > 0">
                    <div class="panel-heading hbuilt">
                        Ticket List
                        <div class="panel-tools">
                            <a class="showhide" v-on:click="togglePanel('#tickets')"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <template v-for="row in tickets">
                        <div class="panel-body">
                            <div class="media">
                                <div class="media-author pull-left">
                                    <div class="author-info">
                                        <p class="author-name" v-bind:title="row.assigned_to.name">{{ row.assigned_to.name }} </p>
                                        {{ row.updated_at | moment("from", "now" ) }}
                                    </div>
                                </div>
                                <div class="media-body">

                                    <router-link v-bind:to="{'name': 'ticket-detail', params: {'id': row.id }}" active-class="" class="">
                                        <strong>{{ row.title }}</strong>
                                    </router-link><br>
                                    {{ row.description }}
                                </div>
                                <div class="media-info pull-right">
                                    <span v-bind:title="row.updated_at">{{ row.updated_at | moment("from", "now") }}</span>
                                    <button class="btn btn-default dropdown" data-toggle="dropdown" type="button" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="" class="dropdown-item">Edit</a>
                                        <a href="" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <p v-else>
                    No ticket found for project <strong>{{ project.name }}</strong>
                </p>
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
        components: {
            //
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
        },
        beforeRouteUpdate (to, from, next) {
            this.project_id = to.params.id;
            this.getProject(this.project_id);
            this.getTickets(this.project_id);
            next();
        }
    }
</script>

<style scoped>
h5{font-size: 14px;}
</style>
