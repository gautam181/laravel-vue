<template>
    <div>
        <div v-if="loaded">
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
                                        <sort-filter :order="sortOrder" :selected="sortOption" v-on:update-sort="handleSort"  v-on:update-order="handleSortOrder" :options="sortOptions"></sort-filter>
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
                                                <div class="col-sm-12">
                                                    <h5>
                                                        <router-link v-bind:to="{'name': 'project-tickets', params: {'id': project.id }}" active-class="" class="">
                                                            {{ project.name }}
                                                        </router-link>
                                                    </h5>
                                                    <div class="project-details">
                                                        {{ project.description}}
                                                    </div>

                                                    <div class="row project-actions">
                                                        <div class="col-sm-2 col">
                                                            <div class="project-label">OWNER</div>
                                                            <small v-if="project.owner" >
                                                                <avatar :username="project.owner.name" :size="size" :customStyle="avatarStyle" v-b-tooltip.hover.rightbottom :title="project.owner.name"></avatar>
                                                            </small>
                                                        </div>
                                                        <div class="col-sm-4 col">
                                                            <div class="project-label">DEADLINE</div>
                                                            <small>{{ project.end_date | date }}</small>
                                                        </div>
                                                        <div class="col-sm-4 col">
                                                            <div class="project-label">PROGRESS</div>
                                                            <div class="progress m-t-xs full progress-small">
                                                                <div style="width: 12%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="12" role="progressbar" class=" progress-bar progress-bar-success">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col">
                                                            <div class="project-label">ACTIONS</div>
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-circle btn-default" v-b-popover.click.left="popoverConfig(project.id)">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div class="col-md-12">
                                <a class="load-more" v-if="pagination.totalPages > 1" href="javascript:void(0);" @click="loadMore">
                                    <i class="fa fa-ellipsis-h fa-lg"></i>
                                    Load {{ pagination.perPage }} more from the next {{ remaining}}
                                </a>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <loading-spinner label="Loading projects" :show="loading"></loading-spinner>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div >
                <project-form :id="project_id" v-if="showProjectForm"></project-form>
            </div>
        </div>

    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import ProjectForm from "./forms/ProjectForm";
    import SortFilter from "../../components/ui/SortFilter";

    export default {
        name: "project-index",
        data(){
            return {
                myRoute : {},
                showProjectForm: false,
                project_id: 0,
                loaded: false,
                loading: false,
                size:25,
                popoverShow: false,
                sortOptions: [
                    {id: 'id', 'label': 'Default'},
                    {id: 'name', 'label': 'Project Name'},
                    {id: 'update_date', 'label': 'Updated Date'},
                    {id: 'created_date', 'label': 'Created Date'},
                    {id: 'due_date', 'label': 'Due Date'},
                ],
                avatarStyle: {'margin-right':'5px'}
            }
        },
        components:{
            ProjectForm, SortFilter
        },
        created(){
            this.$eventBus.$on('project-list-loading', val => {
                this.loading = val;
            });
        },
        computed: {
            projectClasses() {
                return this.$settings.sidebarMinified? 'col-lg-4 col-md-6': 'col-lg-4 col-md-12';
            },
            remaining: function () {
                return this.pagination.totalRows - (this.pagination.perPage*this.pagination.page);
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
                filters: 'projects/getFilters',
                sortOrder: 'projects/getOrderBy',
                sortOption: 'projects/getSortBy'
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
            projectActions: function(id){
                let html = "";
                return html;
            },
            handleSortOrder: function(val){
                this.$store.commit('projects/setOrderBy', val);
                this.fetchProjects();
            },

            handleSort: function(val){
                this.$store.commit('projects/setSortBy', val);
                this.fetchProjects();
            },
            editProject: function(id){
                console.log(id);
                this.project_id = id;
                this.showProjectForm = true;
            },
            addProject: function(){
                this.project_id = 0;
                this.showProjectForm = true;
            },
            loadMore: function(){
                this.$store.commit('projects/setPage', this.pagination.page + 1);
                this.fetchProjects(true);
            },
            fetchProjects: function (val) {
                let mode = val != undefined ? val : false;
                if(!mode)
                    this.$eventBus.$emit('project-list-loading', true);
                this.$store.dispatch('projects/getProjects', mode)
                    .then(res => {
                        this.loaded = true;
                        this.loading = false;
                    })
                    .catch(e => {
                        this.loading = false;
                    });
            },
            popoverConfig:function(id){
                return {
                    html: true,
                    content: () => {
                        // Note this is called only when the popover is opened
                        let html = '<div class="popover-actions">';
                        html += '<a href="javascript:void(0);">' +
                            '   <i class="fa fa-times"></i>' +
                            '   Delete' +
                            '</a>';
                        html += "<a href=\"javascript:void(0);\" v-on:click=\"editProject("+id+")\">" +
                            '                            <i class="fa fa-pen"></i>\n' +
                            '                        Edit\n' +
                            '                        </a>';
                        html += '<a href="javascript:void(0);">\n' +
                            '                            <i class="fa fa-check"></i>\n' +
                            '                        Complete\n' +
                            '                        </a>';
                        html +='</div>';
                        return html
                    }
                }
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
