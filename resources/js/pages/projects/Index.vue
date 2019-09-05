<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Current Projects</h2>
                    <div class="btn-options text-right">
                        <button class="btn btn-md btn-primary w-10" @click="addProject" ><i class="fa fa-plus-circle"></i> Add Project</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="nav-htabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <router-link v-bind:to="{'name': 'projects'}" active-class="active" class="nav-link">
                                Active
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link v-bind:to="{'name': 'project-tickets', params: {'id': 5 }}" active-class="active" v-bind:class="{
                                'nav-link': true,
                                'active': $route.name == 'project-ticket'
                                }">
                                Completed
                            </router-link>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12" v-if="!showFilters">
                            <div class="alert alert-filter">
                                <i class="fa fa-bolt"></i> Showing {{ pagination.totalRows}} filtered results <button  class="btn btn-default btn-sm"><i class="fa fa-retweet"></i> Clear Filter</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="list-options">
                                <div>{{ pagination.totalRows}} results</div>
                                <div class="btn-options text-right">
                                    <b-dropdown variant="default" size="sm">
                                        <template slot="button-content">
                                            <strong>Sort By: </strong> Updated Date
                                        </template>
                                        <b-dropdown-item-button>Second Action</b-dropdown-item-button>
                                        <b-dropdown-item-button>Second Action</b-dropdown-item-button>
                                        <b-dropdown-item>Second Action</b-dropdown-item>
                                        <b-dropdown-item>Second Action</b-dropdown-item>
                                        <b-dropdown-item>Second Action</b-dropdown-item>
                                    </b-dropdown>
                                    <button class="btn btn-default btn-sm"><i class="fa fa-arrow-down"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="$route.name == 'projects'" class="row  list">
            <template v-for="project in projects">
                <div :class="projectClasses +' projects'">
                    <div class="panel green">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h5>
                                        <router-link v-bind:to="{'name': 'project-tickets', params: {'id': project.id }}" active-class="" class="">
                                            {{ project.name }}
                                        </router-link>
                                    </h5>
                                    <div class="project-details">
                                        {{ project.description}}
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="project-label">OWNER</div>
                                            <small v-if="project.owner" >
                                                <avatar :username="project.owner.name" :size="size" :customStyle="avatarStyle" v-b-tooltip.hover.rightbottom :title="project.owner.name"></avatar>
                                            </small>
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
                                        <img alt="logo" class="img-circle" src="images/92-512.png">
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
                project_id: 0,
                size:25,
                sort: '',
                avatarStyle: {'margin-right':'5px'}
            }
        },
        components:{
            ProjectForm
        },
        computed: {
            projectClasses() {
                return this.$settings.sidebarMinified? 'col-lg-4 col-md-6': 'col-lg-6 col-md-12';
            },
            projects:{
                get() { return this.$store.getters['projects/getProjects']; },
                set(value) { this.$store.commit('projects/setProjects', value); },
            },
            showFilters: function(){
              return _.isEqual(this.$filters.project_list, this.filters);
            },
            ...mapGetters({
                //projects: 'projects/getProjects',
                pagination: 'projects/getPagination',
                filters: 'projects/getFilters'
            })
        },
        mounted(){
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                if (modalId == 'project-form')
                    this.showProjectForm = false;
            })
            this.$eventBus.$emit('header-update', {label:'Manage your projects'});
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
