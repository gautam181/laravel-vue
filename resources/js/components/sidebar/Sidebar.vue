<template>
    <aside id="sidebar">
        <span id="sidebar-toggle" v-on:click="toggleSideBar"><i :class="{'fa':1, 'fa-angle-double-left':!settings.sidebarMinified, 'fa-angle-double-right':settings.sidebarMinified}" ></i></span>
        <div id="navigation">


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
