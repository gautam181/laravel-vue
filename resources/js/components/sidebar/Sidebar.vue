<template>
    <aside id="sidebar" class="sidebar">
        <span id="sidebar-toggle" v-on:click="toggleSideBar"><i :class="{'fa':1, 'fa-angle-double-left':!settings.sidebarMinified, 'fa-angle-double-right':settings.sidebarMinified}" ></i></span>
        <div class="sidebar-content" >
            <div v-if="!settings.sidebarMinified">
                <project-summary></project-summary>
                <project-tickets></project-tickets>
                <project-files></project-files>
                <project-time></project-time>
                <project-list></project-list>
                <project-ticket-detail></project-ticket-detail>
            </div>


        </div>
    </aside>
</template>

<script>
    import ProjectSummary from "./projects/Summary"
    import ProjectTickets from "./projects/Tickets"
    import ProjectFiles from "./projects/Files"
    import ProjectTime from "./projects/Time"
    import ProjectList from "./projects/List"
    import ProjectTicketDetail from "./projects/TicketDetail"
    import settings from "../../config/Settings";
    export default {
        name: "Sidebar",
        components: {
            ProjectSummary,
            ProjectTickets,
            ProjectFiles,
            ProjectTime,
            ProjectList,
            ProjectTicketDetail,
        },
        data(){
            return {
                settings: settings,
                size:20,
                avatarStyle: {'margin-right':'5px'},
                noData: false,
                scOptions: {
                    height: '100%',
                    opacity: 0.3,
                    size : 0,
                    wheelStep : 5,
                    distance: -20
                }
            }
        },
        watch:{

        },
        computed:{

        },
        methods:{
            toggleSideBar: function(){
                this.settings.sidebarMinified = !this.settings.sidebarMinified;
                localStorage.setItem('sidebar_minified', this.settings.sidebarMinified);
            }
        }
    }
</script>

<style scoped>
  #sidebar-toggle {position: absolute;top: 5px; right: 0px; width: 30px; cursor: pointer; text-align: right;padding-right:5px; z-index: 10;}
    #sidebar{}
</style>
