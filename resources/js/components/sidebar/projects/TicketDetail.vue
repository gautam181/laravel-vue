<template>
    <div class="ticket-summary" v-if="showSummary">
        <div v-if="ticket">
            <div class="sidebar-block">
                <div class="sblock-header">
                    <h4>Assigned to</h4>
                </div>
                <div class="sblock-body">
                    <div class="flex" v-if="ticket.assigned_to">
                        <avatar :username="ticket.assigned_to.name" :size="size" :customStyle="avatarStyle"></avatar>
                        <a href="javascript:void(0);" @click="editProject('owner')">{{ ticket.assigned_to.name }}</a>
                    </div>
                    <div v-else>
                        <a href="javascript:void(0);" @click="editProject('owner')">Owner not set</a>
                    </div>

                </div>
            </div>
            <div class="sidebar-block">
                <div class="sblock-header">
                    <h4>Estimated Time</h4>
                </div>
                <div class="sblock-body">
                    10 hours
                </div>
            </div>
            <div class="sidebar-block">
                <div class="sblock-header">
                    <h4>Start Date</h4>
                </div>
                <div class="sblock-body">
                    {{ ticket.start_date | date }}
                </div>
            </div>
            <div class="sidebar-block">
                <div class="sblock-header">
                    <h4>End Date</h4>
                </div>
                <div class="sblock-body">
                    {{ ticket.end_date | date }}
                </div>
            </div>
            <div class="sidebar-block">
                <div class="sblock-header">
                    <h4>Created By</h4>
                </div>
                <div class="sblock-body">
                    <div class="flex" v-if="ticket.created_by">
                        <avatar :username="ticket.created_by.name" :size="size" :customStyle="avatarStyle"></avatar>
                        <a href="javascript:void(0);">{{ ticket.created_by.name }}</a>
                    </div>
                    <div v-else>
                        <a href="javascript:void(0);">Created by not found</a>
                    </div>
                    <div>
                        {{ ticket.created_at | fulldate }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
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
