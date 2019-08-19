<template>
    <aside id="sidebar">
        <span id="sidebar-toggle"><i class="fa fa-angle-double-left"></i></span>
        <div id="navigation">


        </div>
    </aside>
</template>

<script>
    import SidebarNav from "./SidebarNav"
    import Profile from "./Profile"
    export default {
        name: "Sidebar",
        components: {
            SidebarNav,
            Profile
        }
    }
</script>

<style scoped>
  #sidebar-toggle {position: absolute; right: 0px; width: 30px; cursor: pointer; text-align: right;padding-right:5px; }
</style>
