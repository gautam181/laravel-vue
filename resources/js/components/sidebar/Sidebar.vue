<template>
    <aside id="sidebar">
        <span id="sidebar-toggle" v-on:click="toggleSideBar"><i :class="{'fa':1, 'fa-angle-double-left':!settings.sidebarMinified, 'fa-angle-double-right':settings.sidebarMinified}" ></i></span>
        <div class="sidebar-content" v-if="!settings.sidebarMinified">
            <div class="projects">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading built">
                                <div class="panel-tools">
                                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                                </div>
                                Filters
                            </div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label class="control-label">Project date:</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" value="10/06/2016">
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-sm btn-block">Apply</button>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </aside>
</template>

<script>
    import SidebarNav from "./SidebarNav"
    import Profile from "./Profile"
    import settings from "../../config/Settings";
    export default {
        name: "Sidebar",
        components: {
            SidebarNav,
            Profile
        },
        data(){
            return {
                settings: settings
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
  #sidebar-toggle {position: absolute;top: 5px; right: 0px; width: 30px; cursor: pointer; text-align: right;padding-right:5px; }
</style>
