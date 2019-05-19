<template>
    <ul class="nav flex-column" id="side-menu" v-if="menus">
        <template v-for="menu in menus">
            <nav-list ref="navList" v-bind:menu="menu" v-bind:scrollTop="scrollTop" v-bind:key="menu.path" v-bind:status="menu.status" v-on:collapse-other="handleCollapseOther(menu)"></nav-list>
        </template>
    </ul>
</template>

<script>
    import Menu from './Menu'
    import NavList from './NavList'

    export default {
        name: "SidebarNav",
        data (){
            return {
                menus: Menu
            }
        },
        components: {
            NavList
        },
        methods: {
            handleCollapseOther: function(menu) {
                for (let i = 0; i < this.menus.length; i++) {
                    this.$refs.navList[i].collapse(menu);
                }
            }
        }
    }
</script>

<style scoped>

</style>