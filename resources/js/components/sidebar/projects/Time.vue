<template>
    <div class="project-time" v-if="showWidget">
        <div class="sidebar-block">
            <div class="sblock-header">
                <h4>Total Time Logged</h4>
            </div>
            <div class="sblock-body">
                22 hours 20 minutes
            </div>
        </div>
        <div class="sidebar-block">
            <div class="sblock-header">
                <h4>Total Estimated Time</h4>
            </div>
            <div class="sblock-body">
                100 hours 20 minutes
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "project-time",
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
            showWidget(){
                return this.$route.name == 'project-time'?  true : false;
            }
        }
    }
</script>

<style scoped>

</style>
