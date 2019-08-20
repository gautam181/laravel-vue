<template>
    <div>
        <vue-title :title="project.name"></vue-title>
        <div class="row projects">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="tabs">
                    <router-link v-bind:to="{'name': 'project-summary', params: {'id': project_id }}" active-class="active" class="" tag="li" >
                        <a class="">Summary</a>
                    </router-link>
                    <router-link v-bind:to="{'name': 'project-tickets', params: {'id': project_id }}" active-class="active" class="" tag="li" >
                        <a class="">Tickets</a>
                    </router-link>
                    <router-link v-bind:to="{'name': 'project-time', params: {'id': project_id }}" active-class="active" class="" tag="li" >
                        <a class="">Time</a>
                    </router-link>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">
                            <project-form :project="project" v-if="project_form"></project-form>
                            <router-view v-on:handle-page-header="handlePageHeader" ref="myChild"></router-view>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Ticket from '../../components/util/Ticket';
    import ProjectForm from "./forms/Project";

    export default {
        name: "project-detail",
        data(){
            return {
                myRoute : {},
                project_id : this.$route.params.id,
                project_form: false,
                project: {},
                tickets: [],
                ticketList: true,
                showAddTicket: false,
                blankTicket: {
                    project: {id:this.$route.params.id},
                    title: '', description: '',
                    assigned_to: {id:'', name: ''}
                }
            }
        },
        watch: {
            project: function(val) {
                this.$emit('handle-page-header', {label:val.name, tools:[{'icon': 'fa-pen',
                        'event':(val)=>{
                            this.editProjectModal(val);
                        },
                        'id': val.id
                }]});
            }
        },
        components: {
            ProjectForm,
            Ticket
        },
        mounted(){
            this.getProject(this.project_id);
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                if (modalId == 'project-form')
                    this.project_form = false;
            })
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
            addTicket: function(){
              this.showAddTicket = true;
            },
            getTickets: function (id, data) {
                axios.get("/project/tickets/"+id)
                    .then(response => {
                        let res = response.data;
                        this.tickets = res.data;
                    });
            },
            editProjectModal: function (id) {
                this.project_form = true;
                //this.$refs['project-form'].show();
                console.log(this.project_form, id);
            }
        },
        beforeRouteUpdate (to, from, next) {
            next();
        }
    }
</script>

<style scoped>
h5{font-size: 14px;}
</style>
