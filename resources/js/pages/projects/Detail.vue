<template>
    <div>
        <vue-title :title="project.name"></vue-title>
        <div class="row projects" >
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
                            <router-view ref="myChild"></router-view>
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
                project_id : 0,
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
        },
        computed: {

        },
        created(){
            this.$eventBus.$on('project-info', id=>{
                if (this.project_id != id){
                    this.project_id = parseInt(id);
                    this.getProject(this.project_id)
                }

            });
        },
        components: {
            ProjectForm,
            Ticket
        },
        mounted(){
            this.$eventBus.$emit('header-update', {label:'project detail ...'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                if (modalId == 'project-form')
                    this.project_form = false;
            })
        },
        methods:{
            getProject: function (id) {
                this.$store.dispatch('projects/getProject', id)
                    .then(response =>{
                        let val = this.$store.getters['projects/getProject'](this.project_id);
                        this.$eventBus.$emit('header-update', {label:val.name, type:'project', id:val.id, tools:[{'icon': 'fa-pen',
                                'event':(val)=>{
                                    this.editProjectModal(val);
                                },
                                'id': val.id
                        }]});
                    });
            },
            addTicket: function(){
              this.showAddTicket = true;
            },
            editProjectModal: function (id) {
                this.project_form = true;
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
