<template>
    <aside id="sidebar" class="sidebar">
        <span id="sidebar-toggle" v-on:click="toggleSideBar"><i :class="{'fa':1, 'fa-angle-double-left':!settings.sidebarMinified, 'fa-angle-double-right':settings.sidebarMinified}" ></i></span>
        <div class="sidebar-content" >
            <div v-if="!settings.sidebarMinified">
                <project-summary></project-summary>
                <project-tickets></project-tickets>
                <project-time></project-time>
                <project-list></project-list>
                <project-ticket-detail></project-ticket-detail>
                <div class="projects" v-if="noData">
                    <div class="sidebar-block">
                        <div class="sblock-header">
                            <h4>Project Owner</h4>
                        </div>
                        <div class="sblock-body">
                            <div class="flex">
                                <avatar username="Abdul Khan" :size="size" :customStyle="avatarStyle"></avatar>
                                <a href="javascript:void(0);">Abdul Khan</a>
                            </div>

                        </div>
                    </div>
                    <div class="sidebar-block">
                        <div class="sblock-header">
                            <h4>Description</h4>
                        </div>
                        <div class="sblock-body">
                            This is body in normal
                        </div>
                    </div>
                    <div class="sidebar-block">
                        <div class="sblock-header">
                            <h4>Manage Dates</h4>
                        </div>
                        <div class="sblock-body">
                            <ul class="slist-links">
                                <li>
                                    <a href="javascript:void(0);">Update project dates</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-header">
                            Keyword
                        </div>
                        <div class="filer-body">
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-header">
                            Created Date
                        </div>
                        <div class="filer-body">

                            <div class="date-range">

                                <div class="date-range-block">
                                    <div class="input-group date">
                                        <label class="label">Start Date</label>
                                        <b-input-group size="sm">
                                            <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                            <date-picker v-model="start_date" ref="startDate" placeholder="Start Date"></date-picker>
                                        </b-input-group>
                                    </div>
                                </div>
                                <div class="date-range-block">
                                    <label class="label">End Date</label>
                                    <b-input-group size="sm">
                                        <b-input-group-text slot="prepend"><i class="fa fa-calendar"></i></b-input-group-text>
                                        <date-picker v-model="start_date" ref="startDate" placeholder="End Date"></date-picker>
                                    </b-input-group>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filer-body">
                            <a href="javascript:void(0)" class="btn btn-default btn-sm"><i class="fa fa-retweet"></i> Reset Filter</a>
                            <a href="javascript:void(0)" class="btn btn-primary pull-right btn-sm"><i class="fa fa-filter"></i> Apply Filter</a>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </aside>
</template>

<script>
    import ProjectSummary from "./projects/Summary"
    import ProjectTickets from "./projects/Tickets"
    import ProjectTime from "./projects/Time"
    import ProjectList from "./projects/List"
    import ProjectTicketDetail from "./projects/TicketDetail"
    import settings from "../../config/Settings";
    export default {
        name: "Sidebar",
        components: {
            ProjectSummary,
            ProjectTickets,
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
    #sidebar{position: fixed;z-index: 2;}
</style>
