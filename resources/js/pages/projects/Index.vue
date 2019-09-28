<template>
    <div>
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
                                <router-link v-bind:to="{'name': 'projects-active'}" active-class="active" class="nav-link">
                                    Active
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link v-bind:to="{'name': 'projects-completed'}" active-class="active" class="nav-link">
                                    Completed
                                </router-link>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <router-view :key="$route.fullPath" ></router-view>
                        <div >
                            <project-form :id="project_id" v-if="showProjectForm"></project-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import ProjectForm from "./forms/ProjectForm";
    import SortFilter from "../../components/ui/SortFilter";
    import LoadMore from "../../components/ui/LoadMore";

    export default {
        name: "project-index",
        data(){
            return {
                myRoute : {},
                project_id: 0,
                showProjectForm: false,
                sortOptions: [
                    {id: 'id', 'label': 'Default'},
                    {id: 'name', 'label': 'Project Name'},
                    {id: 'update_date', 'label': 'Updated Date'},
                    {id: 'created_date', 'label': 'Created Date'},
                    {id: 'due_date', 'label': 'Due Date'},
                ]
            }
        },
        components:{
            ProjectForm, SortFilter, LoadMore
        },
        created(){
            this.$root.$on('project-form', val => {
                this.project_id = val;
                this.showProjectForm = true;
            });
            this.$root.$on('project-form-hide', () => {
                this.project_id = 0;
                this.showProjectForm = false;
            });
        },
        computed: {

        },
        mounted(){
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                if (modalId == 'project-form')
                    this.showProjectForm = false;
            })
            this.$root.$emit('header-update', {label:'Manage your projects'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
        },
        methods:{
            addProject: function(){
                this.showProjectForm = true;
                this.project_id = 0;
            },
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            handleSortOrder: function(val){
                this.$store.commit('projects/setOrderBy', val);
            },
            handleSort: function(val){
                this.$store.commit('projects/setSortBy', val);
            },
        },
        beforeRouteUpdate (to, from, next) {
            next();
        }
    }
</script>

<style scoped>

</style>
