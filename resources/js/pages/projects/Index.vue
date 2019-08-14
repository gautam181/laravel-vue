<template>
    <div>
        <router-view v-on:handle-page-header="handlePageHeader" ref="myChild"></router-view>
        <div class="row">
            <div class="col-md-12">
                <div class="list-options">
                    <h2 class="">Projects List</h2>
                    <b-pagination v-on:change="paginate"
                                  :page="pagination.page"
                                  :total-rows="pagination.totalRows"
                                  :per-page="pagination.perPage"
                                  align="right"
                    ></b-pagination>
                </div>

            </div>
        </div>
        <div v-if="$route.name == 'projects'" class="row projects list">
            <template v-for="project in projects">
                <div class="col-lg-4 col-md-6">
                    <div class="hpanel hgreen">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h4>
                                        <router-link v-bind:to="{'name': 'project-detail', params: {'id': project.id }}" active-class="" class="">
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
                                <div class="col-sm-4 project-info">
                                    <div class="project-action m-t-md">
                                        <div class="btn-group">
                                            <router-link v-bind:to="{'name': 'project-detail', params: {'id': project.id }}" active-class="" class="btn btn-xs btn-default">
                                                View
                                            </router-link>
                                            <button class="btn btn-xs btn-default"> Edit</button>
                                            <button class="btn btn-xs btn-default"> Delete</button>
                                        </div>
                                    </div>
                                    <div class="project-value">
                                        <h2 class="text-success">
                                            TotalHours
                                        </h2>
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
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        name: "project-index",
        data(){
            return {
                myRoute : {},
            }
        },
        computed: {
            ...mapGetters({
                projects: 'projects/getProjects',
                pagination: 'projects/getPagination'
            })
        },
        mounted(){
            this.$emit('handle-page-header', {label:'', desc:'List of projects'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            if(this.$route.name == 'projects')
                this.projects = this.fetchProjects();
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
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
