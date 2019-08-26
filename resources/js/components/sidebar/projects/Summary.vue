<template>
    <div class="project-summary" v-if="showSummary">
        <div class="sidebar-block">
            <div class="sblock-header">
                <h4>Project Owner</h4>
            </div>
            <div class="sblock-body">
                <div class="flex" v-if="project.owner">
                    <avatar :username="project.owner.name" :size="size" :customStyle="avatarStyle"></avatar>
                    <a href="javascript:void(0);">{{ project.owner.name }}</a>
                </div>

            </div>
        </div>
        <div class="sidebar-block">
            <div class="sblock-header">
                <h4>Description</h4>
            </div>
            <div class="sblock-body">
                {{ project.description }}
            </div>
        </div>
        <div class="sidebar-block">
            <div class="sblock-header">
                <h4>Dates</h4>
            </div>
            <div class="sblock-body">
                {{ project.start_date|date }}
                {{ project.end_date|date }}
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "project-summary",
        data(){
            return {
                project_id : this.$route.params.id,
                size:20,
                avatarStyle: {'margin-right':'5px'},
            }
        },
        computed:{
            project(){
                return this.$store.getters['projects/getProject'](this.project_id);
            },
            showSummary(){
                return this.$route.name == 'project-summary'?  true : false;
            }
        }
    }
</script>

<style scoped>

</style>
