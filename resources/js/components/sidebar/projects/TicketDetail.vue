<template>
    <div class="ticket-summary" v-if="showSummary">
        <div class="sidebar-block">
            <div class="sblock-header">
                <h4>Description</h4>
                <button class="btn btn-xs" @click="editProject('description')"><i class="fa fa-pen"></i> Edit</button>
            </div>
            <div class="sblock-body">
                description settings
            </div>
        </div>
        <div v-if="showProjectForm.show">
            <project-form :id="ticket_id" :tab="showProjectForm.tab"></project-form>
        </div>
    </div>
</template>

<script>
    import ProjectForm from "../../../pages/projects/forms/ProjectForm";
    export default {
        name: "project-ticket-detail",
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
            ticket_id(){
                return this.$route.params.ticket_id;
            },
            ticket(){
                return this.$store.getters['tickets/getTicket'](this.ticket_id);
            },
            showSummary(){
                return this.$route.name == 'project-ticket'?  true : false;
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
