<template>
    <div>
        <vue-title :title="project.name"></vue-title>
        <div class="row projects">
            <div class="col-md-12">
                <vue-panel
                    id="project"
                    :title="project.name"
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
                    <div class="panel-body">
                    <template v-for="row in tickets">
                        <Ticket
                            :ticket="row"
                            :list=ticketList
                        ></Ticket>
                    </template>
                    </div>
                </div>
                <p v-else>
                    No ticket found for project <strong>{{ project.name }}</strong>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import Ticket from '../../components/util/Ticket';

    export default {
        name: "project-detail",
        data(){
            return {
                myRoute : {},
                project_id : this.$route.params.id,
                project: {},
                tickets: [],
                ticketList: true
            }
        },
        components: {
            Ticket
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
                axios.get("/project/"+id)
                    .then(response => {
                        let res = response.data;
                        this.project = res;
                    });
            },
            getTickets: function (id, data) {
                axios.get("/project/tickets/"+id)
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
