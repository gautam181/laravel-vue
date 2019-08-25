<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Projects List</h2>
                    <div class="btn-options text-right">
                        <button class="btn btn-md btn-primary" @click="addProject" ><i class="fa fa-plus-circle"></i> Add Project</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="$route.name == 'projects'" class="row  list">
            <template v-for="project in projects">
                <div class="col-lg-4 col-md-6 projects">
                    <div class="panel green">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h4>
                                        <router-link v-bind:to="{'name': 'project-tickets', params: {'id': project.id }}" active-class="" class="">
                                            {{ project.name }}
                                        </router-link>
                                    </h4>
                                    <div class="project-details">
                                        {{ project.description}}
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="project-label">OWNER</div>
                                            <small v-if="project.owner">{{ project.owner.name }}</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="project-label">DEDLINE</div>
                                            <small>{{ project.end_date | date }}</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="project-label">PROGRESS</div>
                                            <div class="progress m-t-xs full progress-small">
                                                <div style="width: 12%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="12" role="progressbar" class=" progress-bar progress-bar-success">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 project-info">
                                    <div class="project-action m-t-md">
                                        <div class="btn-group actions">
                                            <button class="btn btn-xs" @click="editProject(project.id)"><i class="fa fa-pen"></i></button>
                                        </div>
                                    </div>
                                    <div class="project-value">
                                        <h4 class="text-success">
                                            100
                                        </h4>
                                    </div>
                                    <div class="project-people">
                                        <img alt="logo" class="img-circle" src="images/a1.jpg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div >
            <project-form :id="project_id" v-if="showProjectForm"></project-form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <b-pagination v-on:change="paginate"
                              :page="pagination.page"
                              :total-rows="pagination.totalRows"
                              :per-page="pagination.perPage"
                              align="right"
                ></b-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import ProjectForm from "./forms/ProjectForm";
    export default {
        name: "project-index",
        data(){
            return {
                myRoute : {},
                showProjectForm: false,
                project_id: 0
            }
        },
        components:{
            ProjectForm
        },
        computed: {
            projects:{
                get() { return this.$store.getters['projects/getProjects']; },
                set(value) { this.$store.commit('projects/setProjects', value); },
            },
            ...mapGetters({
                //projects: 'projects/getProjects',
                pagination: 'projects/getPagination'
            })
        },
        mounted(){
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                if (modalId == 'project-form')
                    this.showProjectForm = false;
            })
            this.$emit('handle-page-header', {label:'Manage your projects'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            if(this.$route.name == 'projects')
                this.projects = this.fetchProjects();
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            editProject: function(id){
                this.project_id = id;
                this.showProjectForm = true;
            },
            addProject: function(){
                this.project_id = 0;
                this.showProjectForm = true;
            },
            fetchProjects: function () {
                this.$store.dispatch('projects/getProjects');
            },
            paginate: function (val) {
                this.$store.commit('projects/setPage', val);
                this.fetchProjects();
            }
        }
    }
</script>

<style scoped>

</style>
