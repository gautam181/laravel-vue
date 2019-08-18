<template>
    <ul class="nav navbar-nav navbar-left" v-if="menus">
        <template v-for="menu in menus">
            <nav-list ref="navList" v-bind:menu="menu" v-bind:key="menu.path" v-bind:status="menu.status" v-on:collapse-other="handleCollapseOther(menu)"></nav-list>
        </template>
    </ul>
</template>

<script>
    import Menu from './Menu'
    import NavList from './NavList'

    export default {
        name: "TopNav",
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
