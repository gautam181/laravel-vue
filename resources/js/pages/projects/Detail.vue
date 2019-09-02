<template>
    <div>
        <vue-title :title="project.name"></vue-title>
        <div class="row projects">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <div class="nav-htabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <router-link v-bind:to="{'name': 'project-summary', params: {'id': project_id }}" active-class="active" class="nav-link">
                                Summary
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link v-bind:to="{'name': 'project-tickets', params: {'id': project_id }}" active-class="active" v-bind:class="{
                                'nav-link': true,
                                'active': $route.name == 'project-ticket'
                                }">
                                Tickets
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link v-bind:to="{'name': 'project-time', params: {'id': project_id }}" active-class="active" class="nav-link" >
                                Time
                            </router-link>
                        </li>


                    </ul>
                </div>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">
                            <project-form :id="project_id" v-if="project_form"></project-form>
                            <router-view v-on:handle-page-header="handlePageHeader" v-on: ref="myChild"></router-view>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Ticket from '../../components/util/Ticket';
    import ProjectForm from "./forms/ProjectForm";

    export default {
        name: "project-detail",
        data(){
            return {
                myRoute : {},
                //project_id : this.$route.params.id,
                project_form: false,
                project : {},
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
                this.$emit('handle-page-header', {label:val.name, type:'project', id:val.id, tools:[{'icon': 'fa-pen',
                        'event':(val)=>{
                            this.editProjectModal(val);
                        },
                        'id': val.id
                }]});
            }
        },
        computed: {
            project_id(){
                return this.$route.params.id? this.$route.params.id: this.$route.params.ticket_id;
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
                console.log("get project "+id);
                this.$store.dispatch('projects/getProject', id)
                    .then(response =>{
                        this.project = this.$store.getters['projects/getProject'](this.project_id);
                    });
            },
            addTicket: function(){
              this.showAddTicket = true;
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
