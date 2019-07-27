<template>
    <div>
        <router-view v-on:handle-page-header="handlePageHeader" ref="myChild"></router-view>
        <div v-if="$route.name == 'projects'" class="row projects">
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


                                    <p>
                                        {{ project.description}}
                                    </p>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="project-label">OWNER</div>
                                            <small v-if="project.owner">{{ project.owner.name }}</small>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="project-label">DEDLINE</div>
                                            <small>{{ project.end_date }}</small>
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
                                            <button class="btn btn-xs btn-default"> View</button>
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
    export default {
        name: "project-index",
        data(){
            return {
                myRoute : {},
                projects : [],
                current_page: 1,
                totalPages : 0
            }
        },
        mounted(){
            this.$emit('handle-page-header', {label:'Projects', desc:'List of projects'});
            this.myRoute = this.$router.options.routes.find(route => route.name === this.$route.name);
            if(this.$route.name == 'projects')
                this.projects = this.getProjects();
        },
        methods:{
            handlePageHeader: function(data){
                this.$emit('handle-page-header', data);
            },
            getProjects: function (data) {
                axios.get(this.$settings.APIURL+"/projects")
                    .then(response => {
                        let res = response.data;
                        this.projects = res.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
