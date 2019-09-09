<template>
    <div class="project-summary" v-if="showSummary">
        <div v-if="project">
            <div class="sidebar-block">
                <div class="sblock-header">
                    <h4>Project Owner</h4>
                </div>
                <div class="sblock-body">
                    <div class="flex" v-if="project.owner">
                        <avatar :username="project.owner.name" :size="size" :customStyle="avatarStyle"></avatar>
                        <a href="javascript:void(0);" @click="editProject('owner')">{{ project.owner.name }}</a>
                    </div>
                    <div v-else>
                        <a href="javascript:void(0);" @click="editProject('owner')">Owner not set</a>
                    </div>

                </div>
            </div>
            <div class="sidebar-block">
                <div class="sblock-header">
                    <h4>Description</h4>
                    <button class="btn btn-xs" @click="editProject('description')"><i class="fa fa-pen"></i> Edit</button>
                </div>
                <div class="sblock-body">
                    {{ project.description }}
                </div>
            </div>
            <div class="sidebar-block">
                <div class="sblock-header">
                    <h4>Progress</h4>
                    <button class="btn btn-xs" @click="editProject('progress')"><i class="fa fa-pen"></i> Edit</button>
                </div>
                <div class="sblock-body">
                    <b-progress  :max="100" variant="success" class="m-t-xs full"  show-progress>
                        <b-progress-bar :value="project.progress" :label="project.progress+'%'"></b-progress-bar>
                    </b-progress>
                </div>
            </div>
            <div class="sidebar-block">
                <div class="sblock-header">
                    <h4>Dates</h4>
                    <button class="btn btn-xs" @click="editProject('dates')"><i class="fa fa-pen"></i> Edit</button>
                </div>
                <div class="sblock-body">
                    <div v-if="hasDates">
                        {{ project.start_date|date }} - {{ project.end_date|date }}
                    </div>
                    <div v-else>
                        No start or end date
                    </div>

                </div>
            </div>
            <div v-if="showProjectForm.show">
                <project-form :id="project_id" :tab="showProjectForm.tab"></project-form>
            </div>
        </div>

    </div>
</template>

<script>
    import ProjectForm from "../../../pages/projects/forms/ProjectForm";
    export default {
        name: "project-summary",
        data(){
            return {
                size:20,
                avatarStyle: {'margin-right':'5px'},
                showProjectForm: {
                    show: false, tab: 'description'
                },

            }
        },
        mounted(){
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                if (modalId == 'project-form')
                    this.showProjectForm.show = false;
            })
        },
        components:{
            ProjectForm
        },
        computed:{
            project_id(){
                return this.$route.params.id;
            },
            project(){
                return this.$store.getters['projects/getProject'](this.project_id);
            },
            showSummary(){
                return this.$route.name == 'project-summary'?  true : false;
            },
            hasDates(){
                return this.project.start_date && this.project.end_date;
            }
        },
        methods:{
            editProject: function (tab) {
                this.showProjectForm.show = true;
                this.showProjectForm.tab = tab;
            }
        },
        beforeRouteUpdate (to, from, next) {
            next();
        }
    }
</script>

<style scoped>

</style>
