<template>
    <aside id="menu">
        <div id="navigation">
            <Profile></Profile>
            <SidebarNav></SidebarNav>
        </div>
    </aside>
</template>

<script>
    import SidebarNav from "./TopNav"
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

</style>
