<template>
    <div>
        <div class="row" v-if="loaded">
            <div class="col-md-12">
                <filter-alert :total="pagination.totalRows" :show="!showFilters" id="project-list"></filter-alert>
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
        <div class="row  list" >
            <loading-spinner label="Loading projects" :show="loading"></loading-spinner>
            <template v-for="project in projects">
                <div :class="projectClasses +' projects'" v-if="showProject(project.progress)">
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
                                            <div class="project-label" @click="editProject(project.id)">DEADLINE</div>
                                            <small>{{ project.end_date | date }}</small>
                                        </div>
                                        <div class="col-sm-4 col">
                                            <div class="project-label">PROGRESS</div>
                                            <b-progress  :max="100" variant="success" class="m-t-xs full"  show-progress>
                                                <b-progress-bar :value="project.progress" :label="project.progress+'%'"></b-progress-bar>
                                            </b-progress>
                                        </div>
                                        <div class="col-sm-2 col text-right">
                                            <div class="project-label">&nbsp;</div>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-circle btn-default" :id="'project-'+project.id" >
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                            <b-popover :target="'project-'+project.id" triggers="focus" placement="left">
                                                <template v-slot:title></template>
                                                <div class="popover-actions">
                                                    <a href="javascript:void(0);" v-if="!completed" @click="deleteProject(project.id)"><i class="fa fa-times"></i>Delete</a>
                                                    <a href="javascript:void(0);" @click="editProject(project.id)"><i class="fa fa-pen"></i>Edit</a>
                                                    <a href="javascript:void(0);" v-if="!completed" @click="completeProject(project.id)"><i class="fa fa-check"></i> Complete</a>
                                                </div>
                                            </b-popover>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <div class="col-md-12" v-if="loaded">
                <load-more :pagination="pagination" v-on:load-more="loadMore"></load-more>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import SortFilter from "../../../components/ui/SortFilter";
    import LoadMore from "../../../components/ui/LoadMore";
    import FilterAlert from "../../../components/ui/FilterAlert";


    export default {
        name: "project-active",
        data(){
            return {
                myRoute : {},
                showProjectForm: false,
                project_id: 0,
                loaded: false,
                completed: this.$route.name == 'projects-active' ? 0:  1,
                loading: true,
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
            SortFilter, LoadMore, FilterAlert
        },
        created(){
            this.$root.$on('project-list-loading', val => {
                this.loading = val;
            });
        },
        computed: {
            projectClasses() {
                return this.$settings.sidebarMinified? 'col-lg-4 col-md-6': 'col-lg-4 col-md-12';
            },
            projects:{
                get() { return this.$store.getters['projects/getProjects']; },
                set(value) { this.$store.commit('projects/setProjects', value); },
            },
            showFilters: function(){
              return _.isEqual(this.$filters.project_list, this.filters);
            },
            ...mapGetters({
                pagination: 'projects/getPagination',
                filters: 'projects/getFilters',
                sortOrder: 'projects/getOrderBy',
                sortOption: 'projects/getSortBy'
            })
        },
        mounted(){
            this.$store.commit('projects/setPage', 1);
            this.$store.commit('projects/setCompleted', this.completed);
            this.$root.$emit('header-update', {label:'Manage your projects'});
            this.projects = this.fetchProjects();
        },
        methods:{
            showProject(val){
                return true;
                if (this.completed){
                    return val == 100 ? true : false;
                } else {
                    return val != 100 ? true : false;
                }

            },
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
                this.$root.$emit('project-form', id);
            },
            loadMore: function(){
                this.$store.commit('projects/setPage', this.pagination.page + 1);
                this.fetchProjects(true);
            },
            fetchProjects: function (val) {
                this.loading = true;
                let mode = val != undefined ? val : false;
                if(!mode)
                    this.$root.$emit('project-list-loading', true);
                this.$store.dispatch('projects/getProjects', mode)
                    .then(res => {
                        this.loaded = true;
                        this.loading = false;
                    })
                    .catch(e => {
                        this.loading = false;
                    });
            },
            completeProject: function(id){
                this.$store.dispatch('projects/completeProject', id)
                    .then(res=>{
                        this.$toast.success('Project completed successfully', "Success", {
                            timout: 1000,
                            position: 'bottomRight'
                        });
                    })
                    .catch(exp=>{
                        this.$emit('handle-exception', exp);
                    })
            },
            deleteProject: function(id){
                this.$swal(
                    {
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            this.$store.dispatch('projects/deleteProject', id)
                                .then(res=>{
                                    this.$toast.success('Project deleted successfully', "Success", {
                                        timout: 1000,
                                        position: 'bottomRight'
                                    });
                                })
                                .catch(exp=>{
                                    this.$emit('handle-exception', exp);
                                })
                        }
                    }
                );
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
